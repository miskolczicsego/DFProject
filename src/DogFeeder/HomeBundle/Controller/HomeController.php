<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 0:18
 */

namespace DogFeeder\HomeBundle\Controller;


use DogFeeder\FeederBundle\Form\Type\FilterType;
use DogFeeder\FeederBundle\Form\Type\ManualFeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Tests\Dumper\FileDumperTest;

class HomeController extends Controller
{
    public function defaultAction()
    {
        return $this->redirectToRoute('home_home_index');
    }

    public function indexAction()
    {
//        $schedule.xml = $this->getDoctrine()->getManager()->getRepository('FeederBundle:Feeder')->getFeederToSchedule(1);
//        dump($schedule.xml);die;

//        $schedule.xml = $this->getDoctrine()->getManager()->getRepository('ScheduleBundle:Schedule')->getFirstScheduleByDate();
//        dump($schedule.xml);die;

//        dump($this->get('security.token_storage')->getToken());die;
        if ($this->isFeederBelongsToUser()) {
            $manualFeedForm = $this->createForm($this->get('manualfeed.type'));
            $statFilterForm = $this->createForm($this->get('filter.type'));
            $userId = $this->getUser()->getId();
            $historyLimit = $this->get('config')->get('history_limit', $userId)->getValue();
            $feedHistoriesToUser = $this->getLastFeedhistoriesToCurrentUser($historyLimit);
//            dump($feedHistoriesToUser);die;
            return $this->render("@Home/layout.html.twig",array(
                'renderStatTable' => true,
                'getLastFeedhistoriesByUserId' => $feedHistoriesToUser,
                'form' => $manualFeedForm->createView(),
                'filterForm' => $statFilterForm->createView()
            ));
        } else {
            return $this->render("@Home/layout.html.twig",array(
                'renderStatTable' => false,
            ));
        }
    }

    public function getLastFeedhistoriesToCurrentUser($limit)
    {
        return $this->getDoctrine()->getRepository('FeederBundle:FeedHistory')->getLastFeedhistoriesByUserId($this->getUser()->getId(), $limit);
    }

    public function isFeederBelongsToUser()
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $feeder = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->findOneBy(array(
                'user' => $this->getUser()->getId()
            ));
        }
        return isset($feeder) ? true : false;
    }
}