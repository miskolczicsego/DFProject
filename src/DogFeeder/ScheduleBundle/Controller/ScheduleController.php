<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.29.
 * Time: 19:11
 */

namespace DogFeeder\ScheduleBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ScheduleController extends Controller
{
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $schedule = $em->getRepository('ScheduleBundle:Schedule')->find($id);
        $em->remove($schedule);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', $translator->trans('delete_schedule_success'));
        ;

        return $this->redirectToRoute('feeder_feeder_list');
    }
}