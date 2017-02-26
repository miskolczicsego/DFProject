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

        if($feederRegistrationForm->isSubmitted()) {
            $feeder = new Feeder();
            $data = $feederRegistrationForm->getData();
            $em = $this->getDoctrine()->getManager();
            $feeder->setUser($this->getUser());
            $feeder->setName($data['name']);
            $em->persist($feeder);
            $em->flush();

            $this->redirect('home_home_index');
        }

        return $this->render("@Feeder/FeederRegistration/feederreg.html.twig", array(
            'form' => $feederRegistrationForm->createView()
        ));
    }
}