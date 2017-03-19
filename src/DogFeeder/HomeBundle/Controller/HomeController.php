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

    public function indexAction(Request $request)
    {
        if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $feeder = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->findOneBy(array(
                'user' => $this->getUser()->getId()
            ));
        }
        if (isset($feeder)) {
            $manualFeedForm = $this->createForm(new ManualFeedType($this->getUser()->getId()));
            $statFilterForm = $this->createForm(new FilterType());
            $manualFeedForm->handleRequest($request);
            $config = $this->get('config');
            $statLimit = $config->get('stat_limit', $this->getUser()->getId())->getValue();
            $feedStats = $this
                ->getDoctrine()
                ->getRepository('FeederBundle:FeedStat')
                ->getLastFeedstatsByUserId($this->getUser()->getId(), $statLimit);
            return $this->render("@Home/layout.html.twig",array(
                'renderStatTable' => true,
                'getLastFeedstatsByUserId' => $feedStats,
                'form' => $manualFeedForm->createView(),
                'filterForm' => $statFilterForm->createView()
            ));
        } else {
            return $this->render("@Home/layout.html.twig",array(
                'renderStatTable' => false,
            ));
        }


    }
}