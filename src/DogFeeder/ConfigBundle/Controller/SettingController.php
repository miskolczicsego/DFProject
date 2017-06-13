<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.05.
 * Time: 6:56
 */

namespace DogFeeder\ConfigBundle\Controller;


use DogFeeder\ConfigBundle\Entity\Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends Controller
{
    public function indexAction()
    {
        $data = array();
        $userId = $this->getUser()->getId();
        $config = $this->get('config');
        $data['history_limit'] = $config->get('history_limit', $userId);
        $data['schedule_feed'] = $config->get('schedule_feed', $userId);
        $form = $this->createForm('DogFeeder\ConfigBundle\Form\Type\ConfigType');
        return $this->render('@Config/config/config.html.twig', array(
            'form' => $form->createView(),
            'data' => $data
        ));
    }

    public function saveAction(Request $request)
    {
        $translator = $this->get('translator');
        $form = $this->createForm('DogFeeder\ConfigBundle\Form\Type\ConfigType');
        $form->handleRequest($request);
        $data = $form->getData();
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($data as $key => $value) {
                $setting = $this->getDoctrine()->getRepository('ConfigBundle:Config')->findOneBy(array(
                    'key' => $key,
                    'user' => $this->getUser()->getId()
                ));
                $setting->setValue($value);
                $em->persist($setting);
            }
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('config_save_success'));
            ;

            return $this->redirectToRoute('config_config_index');
        }
        $userId = $this->getUser()->getId();
        $config = $this->get('config');
        $data['history_limit'] = $config->get('history_limit', $userId);
        $data['schedule_feed'] = $config->get('schedule_feed', $userId);
        return $this->render('@Config/config/config.html.twig', array(
            'form' => $form->createView(),
            'data' => $data
        ));
    }
}