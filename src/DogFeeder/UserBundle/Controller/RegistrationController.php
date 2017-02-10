<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.10.
 * Time: 19:46
 */

namespace DogFeeder\UserBundle\Controller;

use DogFeeder\UserBundle\Entity\User;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends Controller
{
    public function registerAction()
    {
        $user = new User();
        $form = $this->createForm('DogFeeder\UserBundle\Form\Type\RegistrationType', $user);

        return $this->container->get('templating')->renderResponse('UserBundle:Registration:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}