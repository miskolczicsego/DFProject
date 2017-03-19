<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.25.
 * Time: 21:28
 */

namespace DogFeeder\FeederBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use DogFeeder\UserBundle\Entity\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="DogFeeder\FeederBundle\Repository\FeederRepository")
 * @ORM\Table(name="feeder")
 */
class Feeder extends Timestampable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $name;

    /**
     * @ManyToOne(targetEntity="DogFeeder\UserBundle\Entity\User", inversedBy="feeders")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * One Feeder has Many feedstat.
     * @OneToMany(targetEntity="DogFeeder\FeederBundle\Entity\FeedStat", mappedBy="feeder", cascade={"remove"})
     */
    private $feedstats;

    /**
     * Constructor
     */

    public function __construct()
    {
        $this->feedstats = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getFeedstats()
    {
        return $this->feedstats;
    }

    /**
     * @param mixed $feedstats
     */
    public function addFeedstat($feedstat)
    {
        $this->feedstats->add($feedstat);
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getName();
    }


}