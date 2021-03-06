<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 0:23
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Entity\FeedHistory;
use DogFeeder\FeederBundle\Form\Type\ManualFeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    const SUCCESSFULL_FEED_RESPONESE = 'OK'. PHP_EOL;

    private $formData;

    public function indexAction(Request $request)
    {
        $this->formData = $this->getFormData($request);

        $feeder = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->find($this->formData['feeder']);

        $feedResponse = $this->feed();

        $this->addFeedHistroy($feeder, $feedResponse);

        return $this->redirectToRoute('home_home_index');
    }

    public function feed()
    {
        $output = shell_exec("python /var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/feed.py");
        return $output;
    }

    public function getFormData($request)
    {
        $form = $this->createForm($this->get('manualfeed.type'));
        $form->handleRequest($request);
        $data = $form->getData();

        return $data;
    }

    public function addFeedHistroy($feeder, $feedResponse)
    {
        $stat = new FeedHistory();
        $em = $this->getDoctrine()->getManager();
        $stat->setQuantity($feedResponse == self::SUCCESSFULL_FEED_RESPONESE ? $this->formData['quantity'] : 0);
        $stat->setDescription($feedResponse);
        $stat->setFeeder($feeder);
        $em->persist($stat);

        $em->flush();
    }

}