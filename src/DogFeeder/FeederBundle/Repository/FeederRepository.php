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
    public function getFeederToUser($id)
    {
        $qb = $this->getQueryBuilder();

        $qb->select('u')
            ->join('u.feeders', 'f')
            ->where('u.id = ?1')
            ->setParameter(1, $id);
        return $qb->getQuery()->getArrayResult();
    }

    public function getChoices()
    {
        $feeders = $this->createQueryBuilder('f')
            ->getQuery()
            ->getResult();

        $result = [];
        /** @var Feeder $f */
        foreach ($feeders as $feeder) {
            $result[$feeder->getId()] = $feeder->getName();
        }

        return $result;
    }

    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
        $qb = $em->getRepository('FeederBundle:Feeder')
            ->createQueryBuilder('f');
        return $qb;
    }
}