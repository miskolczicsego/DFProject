<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 16:39
 */

namespace DogFeeder\UserBundle\Controller;


use DogFeeder\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm('DogFeeder\UserBundle\Form\Type\UserType', $user);
        $editForm->handleRequest($request);
        $translator = $this->container->get('translator');
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('profile_modify_success'));
            ;
            return $this->redirectToRoute('home_home_index', array('id' => $user->getId()));
        }
        return $this->render(
            '@User/Profile/edit.html.twig',
            array('user' => $user, 'edit_form' => $editForm->createView())
        );
    }
    public function __toString()
    {
        return 'My string version of UserCategory'; // if you have a name property you can do $this->getName();
    }
}