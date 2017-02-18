<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 0:08
 */

namespace DogFeeder\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction()
    {
        return new Response("dkosdksd");
    }
}