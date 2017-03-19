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
    public function getLastFeedstatsByUserId($id, $limit)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT fs.id, fs.createdAt, fs.description, fs.quantity, f.name
             FROM FeederBundle:FeedStat fs
             JOIN FeederBundle:Feeder f
             WITH fs.feeder = f.id
             AND f.user = {$id}
             ORDER BY fs.createdAt DESC
             "
        )->setMaxResults($limit)->getArrayResult();

        return $query;
    }

    public function findStatsByFeeder($feederName, $statLimit)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT fs.id, fs.createdAt, fs.description, fs.quantity, f.name
             FROM FeederBundle:FeedStat fs
             JOIN FeederBundle:Feeder f
             WHERE f.name = '" . $feederName . "'
             AND fs.feeder = f.id
             ORDER BY fs.createdAt DESC"
        )->setMaxResults($statLimit)->getArrayResult();
        return $query;
    }

    public function findAllLimited($statLimit)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT fs.id, fs.createdAt, fs.description, fs.quantity, f.name
             FROM FeederBundle:FeedStat fs
             JOIN FeederBundle:Feeder f
             WHERE f.name = '" . $feederName . "'
             AND fs.feeder = f.id
             ORDER BY fs.createdAt DESC"
        )->setMaxResults($statLimit)->getArrayResult();
        return $query;
    }
}