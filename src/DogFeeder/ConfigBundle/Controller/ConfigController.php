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

class ConfigController extends Controller
{
    public function indexAction()
    {
        // TODO: itt még ki kell szedni az inputba azt ami db ben van
        $form = $this->createForm('DogFeeder\ConfigBundle\Form\Type\ConfigType');
        return $this->render('@Config/config/config.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function saveAction(Request $request)
    {
        $translator = $this->get('translator');
        $form = $this->createForm('DogFeeder\ConfigBundle\Form\Type\ConfigType');
        $form->handleRequest($request);
        $data = $form->getData();
        $em = $this->getDoctrine()->getManager();

        foreach ($data as $key => $value) {

            $setting = $this->getDoctrine()->getRepository('ConfigBundle:Config')->findOneBy(array(
                'config' => $key
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