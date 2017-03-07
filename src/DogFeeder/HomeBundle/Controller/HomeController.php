<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 0:18
 */

namespace DogFeeder\HomeBundle\Controller;


use DogFeeder\FeederBundle\Form\Type\ManualFeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            $manualFeedForm->handleRequest($request);
            // TODO: Ezt majd össze kell még kötni felhasználóval, vagy etetővel, mert így mindenkinél ugyanaz jelenik majd meg
            $config = $this->get('config');
            $statLimit = $config->get('stat_limit')->getValue();
            $feedStats = $this
                ->getDoctrine()
                ->getRepository('FeederBundle:FeedStat')
                ->getLastFeedstatsByUserId($this->getUser()->getId(), $statLimit);
            return $this->render("@Home/layout.html.twig",array(
                'renderStatTable' => true,
                'getLastFeedstatsByUserId' => $feedStats,
                'form' => $manualFeedForm->createView()
            ));
        } else {
            return $this->render("@Home/layout.html.twig",array(
                'renderStatTable' => false,
            ));
        }


    }
}