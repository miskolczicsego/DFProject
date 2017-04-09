<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 22:09
 */

namespace DogFeeder\FeederBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FeedhistoryRepository extends EntityRepository
{
    public function getLastFeedhistoriesByUserId($id, $limit)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT fh.id, fh.createdAt, fh.description, fh.quantity, f.name
             FROM FeederBundle:FeedHistory fh
             JOIN FeederBundle:Feeder f
             WITH fh.feeder = f.id
             AND f.user = {$id}
             ORDER BY fh.createdAt DESC
             "
        )->setMaxResults($limit)->getArrayResult();

        return $query;
    }

    public function findHistoryByFeeder($feederName, $historyimit)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT fh.id, fh.createdAt, fh.description, fh.quantity, f.name
             FROM FeederBundle:FeedHistory fh
             JOIN FeederBundle:Feeder f
             WHERE f.name = '" . $feederName . "'
             AND fh.feeder = f.id
             ORDER BY fh.createdAt DESC"
        )->setMaxResults($historyimit)->getArrayResult();
        return $query;
    }
}