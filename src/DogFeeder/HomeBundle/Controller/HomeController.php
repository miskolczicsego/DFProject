<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 0:18
 */

namespace DogFeeder\HomeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function defaultAction()
    {
        return $this->redirectToRoute('home_home_index');
    }

    public function indexAction()
    {
        $feedStats = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->findAll();
        return $this->render("@Home/layout.html.twig",array(
            'feedStats' => $feedStats
        ));
    }
}