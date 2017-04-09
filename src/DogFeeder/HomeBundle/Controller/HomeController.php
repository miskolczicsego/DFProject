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
        if ($this->isFeederBelongsToUser()) {
            $manualFeedForm = $this->createForm($this->get('manualfeed.type'));
            $statFilterForm = $this->createForm($this->get('filter.type'));
            $userId = $this->getUser()->getId();
            $config = $this->get('config');
            $isScheduleEnabled = $config->getValue('schedule_feed', $userId);
            $historyLimit = $config->getValue('history_limit', $userId);
            $feedHistoriesToUser = $this->getLastFeedhistoriesToCurrentUser($historyLimit);
            return $this->render("@Home/layout.html.twig",array(
                'renderHistoryTable' => true,
                'getLastFeedhistoriesByUserId' => $feedHistoriesToUser,
                'form' => $manualFeedForm->createView(),
                'filterForm' => $statFilterForm->createView(),
                'isScheduleEnabled' => $isScheduleEnabled
            ));
        } else {
            return $this->render("@Home/layout.html.twig",array(
                'renderHistoryTable' => false,
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