<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.10.
 * Time: 19:46
 */

namespace DogFeeder\UserBundle\Controller;

use DogFeeder\UserBundle\Entity\User;
use DogFeeder\UserBundle\Form\Type\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);
        $translator = $this->container->get('translator');
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('registration_success'));
            ;

            return $this->redirectToRoute('user_registration_register');
        }

        return $this->render("@User/Registration/register.html.twig", array(
           'form' => $form->createView()
        ));
    }
}