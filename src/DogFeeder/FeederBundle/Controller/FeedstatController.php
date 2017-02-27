<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 16:15
 */

namespace DogFeeder\FeederBundle\Controller;


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

        $lastfeedstat = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->getLastFiveFeedstatByUserId();
        $form = $this->createForm('DogFeeder\FeederBundle\Form\Type\ManualFeedType');
        return $this->render('@Home/Stat/feedstat.html.twig', array(
            'lastFiveFeedStatsByUserId' => $lastfeedstat,
            'form' => $form->createView()
        ));
    }
}