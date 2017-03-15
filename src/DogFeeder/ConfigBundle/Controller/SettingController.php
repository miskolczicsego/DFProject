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
        $config = $this->get('config');
        $data['stat_limit'] = $config->get('stat_limit', $this->getUser()->getId());

        $form = $this->createForm('DogFeeder\ConfigBundle\Form\Type\ConfigType');
        return $this->render('@Config/config/config.html.twig', array(
            'form' => $form->createView(),
            'data' => $data
        ));
    }

    public function saveAction(Request $request)
    {
        // TODO variálni kicsit hogy ezt is a service csinálja
        $translator = $this->get('translator');
        $form = $this->createForm('DogFeeder\ConfigBundle\Form\Type\ConfigType');
        $form->handleRequest($request);
        $data = $form->getData();
        $em = $this->getDoctrine()->getManager();

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
}