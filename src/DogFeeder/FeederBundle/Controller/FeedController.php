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
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm('DogFeeder\FeederBundle\Form\Type\ManualFeedType');
        $form->handleRequest($request);
        $data = $form->getData();
        $output = array();
        exec("/var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/hello.py", $output);
        $stat = new FeedStat();
        $em = $this->getDoctrine()->getManager();
        if(isset($output[0]) && $output[0] === "Hello, World!" )
        {
            $stat->setQuantity($data['quantity']);
            $stat->setDescription("everything was OK");
            $em->persist($stat);
        } else {
            $stat->setQuantity(0);
            $stat->setDescription("something was went wrong");
            $em->persist($stat);
        }

        $em->flush();
        return $this->redirectToRoute('home_home_index');
    }
}