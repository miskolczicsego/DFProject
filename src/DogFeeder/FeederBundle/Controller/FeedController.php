<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 0:23
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Entity\FeedStat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedController extends Controller
{
    public function indexAction()
    {

        $output = array();
        exec("/var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/hello.py", $output);
        if($output[0] === "Hello, World!" )
        {
            $stat = new FeedStat();
            $stat->setQuantity("20");
            $stat->setDescription("everything was OK");

            $em = $this->getDoctrine()->getManager();
            $em->persist($stat);
            $em->flush();

            return $this->redirectToRoute('home_home_index');
        }
        return $this->redirectToRoute('home_home_index');
    }
}