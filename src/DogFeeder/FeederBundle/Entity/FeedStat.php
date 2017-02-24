<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.21.
 * Time: 0:08
 */

namespace DogFeeder\FeederBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DogFeeder\UserBundle\Entity\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;
use DogFeeder\UserBundle\Form\Validator\Constraints as UsernameValidator;

/**
 * @ORM\Entity(repositoryClass="DogFeeder\FeederBundle\Repository\FeedstatRepository")
 * @ORM\Table(name="feedstat")
 */
class FeedStat extends Timestampable
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
     * @ORM\Column(type="integer")
     */
    private $quantity;
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