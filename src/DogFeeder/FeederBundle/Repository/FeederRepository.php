<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 13:06
 */

namespace DogFeeder\FeederBundle\Repository;


use Doctrine\ORM\EntityRepository;

class FeederRepository extends EntityRepository
{
    public function getFeederToUser($id)
    {
        $qb = $this->getQueryBuilder();

        $qb->select('u')
            ->join('u.feeders', 'f')
            ->where('u.id = ?1')
            ->setParameter(1, $id);
        return $qb->getQuery()->getArrayResult();
    }
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
        $qb = $em->getRepository('FeederBundle:Feeder')
            ->createQueryBuilder('f');
        return $qb;
    }
}