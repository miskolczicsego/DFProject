<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 16:15
 */

namespace DogFeeder\FeederBundle\Controller;


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

        $lastfeedstat = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->getLastFiveFeedstat($this->getUser()->getId());
        $form = $this->createForm(new ManualFeedType($this->getUser()->getId()));
        return $this->render('@Home/Stat/feedstat.html.twig', array(
            'getLastFiveFeedstat' => $lastfeedstat,
            'form' => $form->createView()
        ));
    }
}