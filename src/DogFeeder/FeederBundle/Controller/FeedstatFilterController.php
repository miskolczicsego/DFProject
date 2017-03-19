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


        $config = $this->get('config');
        $statLimit = $config->get('stat_limit', $this->getUser()->getId())->getValue();

        $filteredStats = $this->getDoctrine()->getManager()->getRepository('FeederBundle:FeedStat')->findStatsByFeeder($feederName, $statLimit);
        //TODO itt talán megoldható lenne hogy a formot ne adjuk vissza csak a táblázatot mert a form mindig ua
        // TODO ehhez a formot külön kell kezelni egy twigben és csak a táblázatot renderelni egy másikból
        $form = $this->createForm(new ManualFeedType($this->getUser()->getId()));
        $filterForm = $this->createForm(new FilterType());
        return $this->render('@Home/Stat/feedstat.html.twig', array(
            'getLastFeedstatsByUserId' => $filteredStats,
            'form' => $form->createView(),
            'filterForm' => $filterForm->createView()
        ));
    }
}