<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 22:09
 */

namespace DogFeeder\FeederBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FeedstatRepository extends EntityRepository
{
    public function getLastFiveFeedstat()
    {
        $qb = $this->getEntityManager()->
            createQueryBuilder()
            ->select('fs')
            ->from('FeederBundle:FeedStat', 'fs')
            ->orderBy('fs.createdAt', 'DESC')
            ->setMaxResults(5);

        return $qb->getQuery()->getArrayResult();
    }
}