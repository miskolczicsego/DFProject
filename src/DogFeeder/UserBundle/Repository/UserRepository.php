<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.26.
 * Time: 11:39
 */

namespace DogFeeder\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getFeedersByUserId($id)
    {
        $qb = $this->getQueryBuilder();

        $qb->select('u')
            ->innerJoin('u.feeders', 'f')
            ->where('u.id = ?1')
            ->setParameter(1, $id);
        return $qb->getQuery()->getResult();
    }

    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
        $qb = $em->getRepository('UserBundle:User')
            ->createQueryBuilder('u');
        return $qb;
    }
}