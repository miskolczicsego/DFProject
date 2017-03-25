<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 14:57
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Entity\Feeder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FeederController extends Controller
{
    public function addAction(Request $request)
    {
        $feederRegistrationForm = $this->createForm('DogFeeder\FeederBundle\Form\Type\FeederType');
        $feederRegistrationForm->handleRequest($request);
        $translator = $this->container->get('translator');
        $data = $feederRegistrationForm->getData();
        // TODO: valami validációt rakni kéne ide
        if($feederRegistrationForm->isSubmitted()) {
            $feeder = new Feeder();
            $em = $this->getDoctrine()->getManager();
            $feeder->setUser($this->getUser());
            $feeder->setName($data->getName());
            $em->persist($feeder);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('add_feeder_success'));
            ;

            return $this->redirectToRoute('home_home_index');
        }

        $template = $this->renderView("@Feeder/FeederRegistration/feederreg.html.twig", array(
            'form' => $feederRegistrationForm->createView()
        ));

        return new Response($template);
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

        $editForm->handleRequest($request);
        $translator = $this->container->get('translator');
        if ($editForm->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('feeder_modify_success'));

            return $this->redirectToRoute('home_home_index');
        }
        $template = $this->renderView('@Feeder/FeederList/feeder_edit.html.twig', array(
                'edit_form' => $editForm->createView()
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
}