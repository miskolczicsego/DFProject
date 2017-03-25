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
    private $formData;

    public function indexAction(Request $request)
    {
        $this->formData = $this->getFormData($request);
        $feeder = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->find($this->formData['feeder']);

        $feedResponse = $this->feed();

        $messages = implode(', ', $feedResponse);

        $this->addFeedStat($feeder, $messages);

        return $this->redirectToRoute('home_home_index');
    }

    public function feed()
    {
        $output = array();
        exec("/var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/feed.py", $output);

        return $output;
    }

    public function getFormData($request)
    {
        $form = $this->createForm($this->get('manualfeed.type'));
        $form->handleRequest($request);
        $data = $form->getData();

        return $data;
    }

    public function addFeedStat($feeder, $messages)
    {
        $stat = new FeedHistory();
        $em = $this->getDoctrine()->getManager();

        $stat->setQuantity($messages == 'Successful feed' ? $this->formData['quantity'] : 0);
        //TODO: itt a visszatérő angol üzeneteket magyarra kéne fordítani
        $stat->setDescription($messages);
        $stat->setFeeder($feeder);
        $em->persist($stat);

        $em->flush();
    }

}