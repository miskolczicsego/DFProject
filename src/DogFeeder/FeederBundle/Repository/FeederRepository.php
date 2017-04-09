<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 13:06
 */

namespace DogFeeder\FeederBundle\Repository;


use Doctrine\ORM\EntityRepository;
use DogFeeder\FeederBundle\Entity\Feeder;

class FeederRepository extends EntityRepository
{
    public function getFeederToSchedule($scheduleId)
    {
         $query = $this->getQueryBuilder();
         $query->leftJoin('f.schedule', 's')
             ->where('s.id =?1')
             ->setParameter(1,$scheduleId);
        return $query->getQuery()->getOneOrNullResult();
    }

    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
        $qb = $em->getRepository('FeederBundle:Feeder')
            ->createQueryBuilder('f');
        return $qb;
    }
}