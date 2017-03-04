<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 0:23
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Entity\FeedStat;
use DogFeeder\FeederBundle\Form\Type\ManualFeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new ManualFeedType($this->getUser()->getId()));
        $form->handleRequest($request);
        $data = $form->getData();
//        dump($data);die;
        $feeder = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->find($data['feeder']);
        $output = array();
        exec("/var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/hello.py", $output);
        $stat = new FeedStat();
        $em = $this->getDoctrine()->getManager();

        if(isset($output[0]) && $output[0] === "Hello, World!" )
        {
            $stat->setQuantity($data['quantity']);
            $stat->setDescription("everything was OK");
            $stat->setFeeder($feeder);
            $em->persist($stat);
        } else {
            $stat->setQuantity(0);
            $stat->setDescription("something was went wrong");
            $stat->setFeeder($feeder);
            $em->persist($stat);
        }

        $em->flush();
        return $this->redirectToRoute('home_home_index');
    }

}