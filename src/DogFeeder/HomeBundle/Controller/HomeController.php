<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.18.
 * Time: 0:18
 */

namespace DogFeeder\HomeBundle\Controller;


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
        $form = $this->createForm('DogFeeder\FeederBundle\Form\Type\ManualFeedType');
        $form->handleRequest($request);
        // TODO: Ezt majd össze kell még kötni felhasználóval, vagy etetővel, mert így mindenkinél ugyanaz jelenik majd meg
        $feedStats = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->getLastFiveFeedstat();
        return $this->render("@Home/layout.html.twig",array(
            'lastFiveFeedStats' => $feedStats,
            'form' => $form->createView()
        ));
    }

    public function feedAction()
    {
        $feedStats = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->getLastFiveFeedstat();

    }
}