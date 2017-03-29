<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 16:15
 */

namespace DogFeeder\FeederBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedhistoryController extends Controller
{
    public function removeAction(Request $request)
    {
        $historyId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $history = $em->getRepository('FeederBundle:FeedHistory')->findOneBy(array(
           'id' => $historyId
        ));
        $em->remove($history);
        $em->flush();

        $config = $this->get('config');
        $historyLimit = $config->get('history_limit', $this->getUser()->getId())->getValue();

        $lastFeedHistory = $this->getDoctrine()->getRepository('FeederBundle:FeedHistory')->getLastFeedhistoriesByUserId($this->getUser()->getId(), $historyLimit);
        return $this->render('@Feeder/FeedhistoryTable/feedhistory_table.html.twig', array(
            'getLastFeedhistoriesByUserId' => $lastFeedHistory,
        ));
    }

    public function filterAction(Request $request)
    {
        $feederName = $request->get('name');

        $optionValue = $request->get('value');

        $config = $this->get('config');
        $historyLimit = $config->get('history_limit', $this->getUser()->getId())->getValue();
        if ($optionValue != false) {

            $filteredHistories = $this->getDoctrine()->getManager()->getRepository('FeederBundle:FeedHistory')->findHistoryByFeeder($feederName, $historyLimit);
            return $this->render('@Feeder/FeedhistoryTable/feedhistory_table.html.twig', array(
                'getLastFeedhistoriesByUserId' => $filteredHistories
            ));
        }

        $allHistories = $this->getDoctrine()->getManager()->getRepository('FeederBundle:FeedHistory')->getLastFeedhistoriesByUserId($this->getUser()->getId(), $historyLimit);
        return $this->render('@Feeder/FeedhistoryTable/feedhistory_table.html.twig', array(
            'getLastFeedhistoriesByUserId' => $allHistories
        ));

    }
}