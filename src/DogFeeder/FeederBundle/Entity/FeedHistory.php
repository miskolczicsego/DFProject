<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 0:08
 */

namespace DogFeeder\FeederBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use DogFeeder\UserBundle\Entity\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;
use DogFeeder\UserBundle\Form\Validator\Constraints as UsernameValidator;

/**
 * @ORM\Entity(repositoryClass="DogFeeder\FeederBundle\Repository\FeedhistoryRepository")
 * @ORM\Table(name="feedhistory")
 */
class FeedHistory extends Timestampable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * Many feedstat have One Feeder.
     * @ManyToOne(targetEntity="Feeder", inversedBy="feedstats")
     * @JoinColumn(name="feeder_id", referencedColumnName="id")
     */
    private $feeder;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
}