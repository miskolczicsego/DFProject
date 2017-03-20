<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 16:15
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Form\Type\FilterType;
use DogFeeder\FeederBundle\Form\Type\ManualFeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FeedstatController extends Controller
{
    public function removeAction(Request $request)
    {
        $statId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $stat = $em->getRepository('FeederBundle:FeedStat')->findOneBy(array(
           'id' => $statId
        ));
        $em->remove($stat);
        $em->flush();

        $config = $this->get('config');
        $statLimit = $config->get('stat_limit', $this->getUser()->getId())->getValue();

        $lastfeedstat = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->getLastFeedstatsByUserId($this->getUser()->getId(), $statLimit);
        return $this->render('@Feeder/FeedstatTable/feedstat_table.html.twig', array(
            'getLastFeedstatsByUserId' => $lastfeedstat,
        ));
    }

    public function filterAction(Request $request)
    {
        $feederName = $request->get('name');

        $optionValue = $request->get('value');

        $config = $this->get('config');
        $statLimit = $config->get('stat_limit', $this->getUser()->getId())->getValue();
        if ($optionValue != false) {

            $filteredStats = $this->getDoctrine()->getManager()->getRepository('FeederBundle:FeedStat')->findStatsByFeeder($feederName, $statLimit);
            return $this->render('@Feeder/FeedstatTable/feedstat_table.html.twig', array(
                'getLastFeedstatsByUserId' => $filteredStats
            ));
        }

        $allStats = $this->getDoctrine()->getManager()->getRepository('FeederBundle:FeedStat')->getLastFeedstatsByUserId($this->getUser()->getId(), $statLimit);
        return $this->render('@Feeder/FeedstatTable/feedstat_table.html.twig', array(
            'getLastFeedstatsByUserId' => $allStats
        ));

    }
}