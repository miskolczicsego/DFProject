<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.26.
 * Time: 19:35
 */

namespace DogFeeder\ScheduleBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ScheduleRepository extends EntityRepository
{
    public function getFirstScheduleByDate()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT s
             FROM ScheduleBundle:Schedule s
             ORDER BY s.createdAt ASC
             "
        )->getOneOrNullResult();

        return $query;
    }
}