<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.03.
 * Time: 23:01
 */

namespace DogFeeder\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DogFeeder\UserBundle\Form\Validator\Constraints as UsernameValidator;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $username;

    protected $password;

    public function __construct()
    {
        parent::__construct();

    }
}