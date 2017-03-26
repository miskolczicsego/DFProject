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
            "SELECT s.id, s.feed_hour_1, s.feed_hour_2, s.feed_hour_3, s.feed_hour_4, s.feed_hour_5, s.feedCounter, s.numberOfFeedPerDay
             FROM ScheduleBundle:Schedule s
             ORDER BY s.createdAt ASC
             "
        )->setMaxResults(1)->getArrayResult();

        return $query;
    }
}