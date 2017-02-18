<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.16.
 * Time: 20:24
 */

namespace DogFeeder\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $request = $this->container->get('request');
        $session = $this->container->get('session');
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('@User/Security/login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * Login check
     */
    public function loginCheckAction()
    {

    }

    /**
     * Logout
     */
    public function logoutAction()
    {

    }
}