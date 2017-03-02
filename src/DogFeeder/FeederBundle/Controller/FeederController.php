<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 14:57
 */

namespace DogFeeder\FeederBundle\Controller;


use DogFeeder\FeederBundle\Entity\Feeder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeederController extends Controller
{
    public function addAction(Request $request)
    {
        $feederRegistrationForm = $this->createForm('DogFeeder\FeederBundle\Form\Type\FeederType');
        $feederRegistrationForm->handleRequest($request);
        $translator = $this->container->get('translator');

        if($feederRegistrationForm->isSubmitted()) {
            $feeder = new Feeder();
            $data = $feederRegistrationForm->getData();
            $em = $this->getDoctrine()->getManager();
            $feeder->setUser($this->getUser());
            $feeder->setName($data['name']);
            $em->persist($feeder);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('add_feeder_success'));
            ;

            return $this->redirectToRoute('home_home_index');
        }

        return $this->render("@Feeder/FeederRegistration/feederreg.html.twig", array(
            'form' => $feederRegistrationForm->createView()
        ));
    }

    public function listAction()
    {
        $user = $this->getUser();
        $feedersToUser = $this->getDoctrine()->getRepository('FeederBundle:Feeder')->findBy(
            array(
                'user' => $user
            )
        );
        return $this->render('@Feeder/FeederList/feeder_list.html.twig', array(
            'feedersToUser' => $feedersToUser
        ));
    }
}