<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.25.
 * Time: 13:16
 */

namespace DogFeeder\ScheduleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use DogFeeder\UserBundle\Entity\Timestampable;


/**
 * @ORM\Entity(repositoryClass="DogFeeder\ScheduleBundle\Repository\ScheduleRepository")
 * @ORM\Table(name="scheduled_feeds")
 */

class Schedule extends Timestampable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="feed_hour_1", type="string", length=2, nullable=true, options={"default" : 0})
     */
    private $feed_hour_1;

    /**
     * @ORM\Column(name="feed_hour_2", type="string", length=2, nullable=true, options={"default" : 0})
     */
    private $feed_hour_2;

    /**
     * @ORM\Column(name="feed_hour_3", type="string", length=2, nullable=true, options={"default" : 0})
     */
    private $feed_hour_3;

    /**
     * @ORM\Column(name="feed_hour_4", type="string", length=2, nullable=true, options={"default" : 0})
     */
    private $feed_hour_4;

    /**
     * @ORM\Column(name="feed_hour_5", type="string", length=2, nullable=true, options={"default" : 0})
     */
    private $feed_hour_5;

    /**
     * @ORM\Column(name="number_of_feed_per_day", type="string", length=1, nullable=true, options={"default" : 0})
     */
    private $numberOfFeedPerDay;

    /**
     * @ORM\Column(name="quantity", type="string", length=3, nullable=true, options={"default" : 0})
     */
    private $quantity;

    /**
     * @ORM\Column(name="feedcounter", type="string", length=1, nullable=true, options={"default" : 0})
     */
    private $feedCounter;

    /**
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * One Cart has One Customer.
     * @OneToOne(targetEntity="DogFeeder\FeederBundle\Entity\Feeder", inversedBy="schedule")
     * @JoinColumn(name="feeder_id", referencedColumnName="id")
     */
    private $feeder;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    /**
     * @return mixed
     */
    public function getFeedHour1()
    {
        return $this->feed_hour_1;
    }

    /**
     * @param mixed $feed_hour_1
     */
    public function setFeedHour1($feed_hour_1)
    {
        $this->feed_hour_1 = $feed_hour_1;
    }

    /**
     * @return mixed
     */
    public function getFeedHour2()
    {
        return $this->feed_hour_2;
    }

    /**
     * @param mixed $feed_hour_2
     */
    public function setFeedHour2($feed_hour_2)
    {
        $this->feed_hour_2 = $feed_hour_2;
    }

    /**
     * @return mixed
     */
    public function getFeedHour3()
    {
        return $this->feed_hour_3;
    }

    /**
     * @param mixed $feed_hour_3
     */
    public function setFeedHour3($feed_hour_3)
    {
        $this->feed_hour_3 = $feed_hour_3;
    }

    /**
     * @return mixed
     */
    public function getFeedHour4()
    {
        return $this->feed_hour_4;
    }

    /**
     * @param mixed $feed_hour_4
     */
    public function setFeedHour4($feed_hour_4)
    {
        $this->feed_hour_4 = $feed_hour_4;
    }

    /**
     * @return mixed
     */
    public function getFeedHour5()
    {
        return $this->feed_hour_5;
    }

    /**
     * @param mixed $feed_hour_5
     */
    public function setFeedHour5($feed_hour_5)
    {
        $this->feed_hour_5 = $feed_hour_5;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getNumberOfFeedPerDay()
    {
        return $this->numberOfFeedPerDay;
    }

    /**
     * @param mixed $numberOfFeedPerDay
     */
    public function setNumberOfFeedPerDay($numberOfFeedPerDay)
    {
        $this->numberOfFeedPerDay = $numberOfFeedPerDay;
    }

    /**
     * @return mixed
     */
    public function getFeedCounter()
    {
        return $this->feedCounter;
    }

    /**
     * @param mixed $feedCounter
     */
    public function setFeedCounter($feedCounter)
    {
        $this->feedCounter = $feedCounter;
    }

    /**
     * @return mixed
     */
    public function getFeeder()
    {
        return $this->feeder;
    }

    /**
     * @param mixed $feeder
     */
    public function setFeeder($feeder)
    {
        $this->feeder = $feeder;
    }

    public function __toString()
    {
        return 'id' . $this->getId();
    }


}