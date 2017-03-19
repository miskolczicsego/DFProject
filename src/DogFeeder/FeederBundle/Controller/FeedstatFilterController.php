<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.18.
 * Time: 19:44
 */

namespace DogFeeder\FeederBundle\Controller;


use Doctrine\ORM\EntityManager;
use DogFeeder\FeederBundle\Form\Type\FilterType;
use DogFeeder\FeederBundle\Form\Type\ManualFeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedstatFilterController extends Controller
{

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