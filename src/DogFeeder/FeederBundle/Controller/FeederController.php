<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 14:57
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Entity\Feeder;
use DogFeeder\ScheduleBundle\Entity\Schedule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FeederController extends Controller
{
    public $error = false;
    public function addAction(Request $request)
    {
        $feederRegistrationForm = $this->createForm('DogFeeder\FeederBundle\Form\Type\FeederType');
        $feederRegistrationForm->handleRequest($request);
        $config = $this->get('config');
        $translator = $this->container->get('translator');
        $data = $feederRegistrationForm->getData();
        $isScheduledFeedEnabled = $config->getValue('schedule_feed', $this->getUser()->getId());

        if($feederRegistrationForm->isSubmitted()) {
            $feeder = new Feeder();
            $em = $this->getDoctrine()->getManager();
            $feeder->setUser($this->getUser());
            $feeder->setName($data['name']);
            $em->persist($feeder);
            $em->flush();
            if ($isScheduledFeedEnabled ) {
                $this->addSchedule($request);
            }

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('add_feeder_success'));
            ;

            return $this->redirectToRoute('home_home_index');
        }

        $template = $this->renderView("@Feeder/FeederRegistration/feederreg.html.twig", array(
            'form' => $feederRegistrationForm->createView(),
            'isScheduledFeedEnabled' => $isScheduledFeedEnabled
        ));

        return new Response($template);
    }

    public function isFormValid($request)
    {
        $editFormData = $request->request->get('feeder');
        foreach ($editFormData as $key => $value) {
            if(($key == 'feed-hour-1' ||
                $key == 'feed-hour-2' ||
                $key == 'feed-hour-3' ||
                $key == 'feed-hour-4' ||
                $key == 'feed-hour-5' ) &&
                !is_numeric($value))
            {
                $this->error = true;
                return false;
            }

        }
        return true;
    }
    public function listAction()
    {

        $user = $this->getUser();
        $feedersToUser = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->findBy(
            array(
                'user' => $user
            )
        );
        $template =  $this->renderView('@Feeder/feederLayout.html.twig', array(
            'feedersToUser' => $feedersToUser
        ));

        return new Response($template);
    }
    
    public function editAction(Request $request, $feederId)
    {
        $feeder = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->find($feederId);
        $editForm = $this->createForm('DogFeeder\FeederBundle\Form\Type\FeederType',$feeder);
        $config = $this->get('config');
        $isScheduledFeedEnabled = $config->getValue('schedule_feed', $this->getUser()->getId());

        $scheduleToFeeder = $this->getDoctrine()->getRepository('ScheduleBundle:Schedule')->findOneBy(array(
            'feeder' => $feeder
        ));

        $editForm->handleRequest($request);
        $translator = $this->container->get('translator');
        if ($editForm->isSubmitted() && $this->isFormValid($request)) {
            if (!$this->isScheduleExists($feederId)) {
                $this->addSchedule($request);
            } else {
                $this->refreshSchedule($request, $feederId);
            }
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('feeder_modify_success'));

            return $this->redirectToRoute('feeder_feeder_list');
        }

        if (!$isScheduledFeedEnabled) {
            $request->getSession()
                ->getFlashBag()
                ->add('information', $translator->trans('schedule_disabled'));
        } else {
            $request->getSession()
                ->getFlashBag()
                ->add('information', $translator->trans('update_information'));
        }
        if($this->error) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', $translator->trans('validation_error'));
            $this->error = false;
        }
        $template = $this->renderView('@Feeder/FeederList/feeder_edit.html.twig', array(
                'edit_form' => $editForm->createView(),
                'feederId' => $feederId,
                'isScheduledFeedEnabled' => $isScheduledFeedEnabled,
                'scheduleToFeeder' => $scheduleToFeeder,
                'error' => $this->error
            )
        );
        return new Response($template);
    }

    public function deleteAction(Request $request, $feederId)
    {
        $em = $this->getDoctrine()->getManager();
        $feeder = $em->getRepository('FeederBundle:Feeder')->find($feederId);
        $em->remove($feeder);
        $em->flush();

        return $this->redirectToRoute('feeder_feeder_list');
    }

    public function addSchedule(Request $request)
    {
        $editFormData = $request->request->get('feeder');
        $feeder = $this->getDoctrine()->getManager()->getRepository('FeederBundle:Feeder')->findOneBy(array(
            'name' => $editFormData['name']
        ));
        $schedule = new Schedule();
        foreach ($editFormData as $key => $value) {
            if (isset($editFormData['numberOfFeedPerDay']) && $key == 'numberOfFeedPerDay') {
                $schedule->setNumberOfFeedPerDay($value);
            }
            if (isset($editFormData['feed-hour-1']) && $key == 'feed-hour-1') {
                $schedule->setFeedHour1($value);
            }
            if (isset($editFormData['feed-hour-2']) && $key == 'feed-hour-2') {
                $schedule->setFeedHour2($value);
            }
            if (isset($editFormData['feed-hour-3']) && $key == 'feed-hour-3') {
                $schedule->setFeedHour3($value);
            }
            if (isset($editFormData['feed-hour-4']) && $key == 'feed-hour-4') {
                $schedule->setFeedHour4($value);
            }
            if (isset($editFormData['feed-hour-5']) && $key == 'feed-hour-5') {
                $schedule->setFeedHour5($value);
            }
            if (isset($editFormData['scheduled-feed-quantity']) && $key == 'scheduled-feed-quantity') {
                $schedule->setQuantity($editFormData['scheduled-feed-quantity']);
            }
        }
        $schedule->setFeedCounter(0);
        $schedule->setFeeder($feeder);
        $schedule->setUserId($this->getUser()->getId());
        $this->getDoctrine()->getManager()->persist($schedule);
        $this->getDoctrine()->getManager()->flush();
    }

    public function isScheduleExists($feederId)
    {
        $schedule = $this->getDoctrine()->getManager()->getRepository('ScheduleBundle:Schedule')->findOneBy(array(
            'feeder' => $feederId
        ));

        if (null == $schedule) {
            return false;
        } else {
            return true;
        }
    }

    public function refreshSchedule($request, $feederId)
    {
        $editFormData = $request->request->get('feeder');

        $schedule = $this->getDoctrine()->getManager()->getRepository('ScheduleBundle:Schedule')->findOneBy(array(
            'feeder' => $feederId
        ));

        $schedule->setNumberOfFeedPerDay($editFormData['numberOfFeedPerDay']);
        $schedule->setFeedHour1(isset($editFormData['feed-hour-1']) ? $editFormData['feed-hour-1'] : null);
        $schedule->setFeedHour2(isset($editFormData['feed-hour-2']) ? $editFormData['feed-hour-2'] : null);
        $schedule->setFeedHour3(isset($editFormData['feed-hour-3']) ? $editFormData['feed-hour-3'] : null);
        $schedule->setFeedHour4(isset($editFormData['feed-hour-4']) ? $editFormData['feed-hour-4'] : null);
        $schedule->setFeedHour5(isset($editFormData['feed-hour-5']) ? $editFormData['feed-hour-5'] : null);
        $schedule->setQuantity(isset($editFormData['scheduled-feed-quantity']) ? $editFormData['scheduled-feed-quantity'] : null);
        $schedule->setFeedCounter(0);

        $this->getDoctrine()->getManager()->flush();
    }
}