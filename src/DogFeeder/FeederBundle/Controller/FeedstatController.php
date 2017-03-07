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

        $config = $this->get('config');
        $statLimit = $config->get('stat_limit')->getValue();

        $lastfeedstat = $this->getDoctrine()->getRepository('FeederBundle:FeedStat')->getLastFeedstatsByUserId($this->getUser()->getId(), $statLimit);
        //TODO itt talán megoldható lenne hogy a formot ne adjuk vissza csak a táblázatot mert a form mindig ua
        // TODO ehhez a formot külön kell kezelni egy twigben és csak a táblázatot renderelni egy másikból
        $form = $this->createForm(new ManualFeedType($this->getUser()->getId()));
        return $this->render('@Home/Stat/feedstat.html.twig', array(
            'getLastFeedstatsByUserId' => $lastfeedstat,
            'form' => $form->createView()
        ));
    }
}