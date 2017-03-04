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
    public function getLastFiveFeedstat($id)
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
        )->setMaxResults(5)->getArrayResult();

        return $query;
    }
}