<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.02.03.
 * Time: 23:01
 */

namespace DogFeeder\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use DogFeeder\ConfigBundle\Entity\Config;
use DogFeeder\FeederBundle\Entity\Feeder;
use DogFeeder\FeederBundle\Entity\FeedHistory;
use DogFeeder\FeederBundle\Repository\FeedhistoryRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use DogFeeder\UserBundle\Form\Validator\Constraints as UsernameValidator;

/**
 * @ORM\Entity(repositoryClass="DogFeeder\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends Timestampable implements UserInterface, \Serializable
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
    private $username;


    /**
     * @ORM\Column(type="string", length=64)
     */
    private $firstname;


    /**
     * @ORM\Column(type="string", length=64)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $email;

    /**
     * One user has many feeders
     *
     * @ORM\OneToMany(targetEntity="DogFeeder\FeederBundle\Entity\Feeder", mappedBy="user")
     */
    private $feeders;

    private $plainPassword;

    /**
     * One User has Many Config.
     *
     * @OneToMany(targetEntity="DogFeeder\ConfigBundle\Entity\Config", mappedBy="user")
     */
    private $configs;

    /**
     * @return mixed
     */

    /**
     * @ORM\Column(type="string", length=4069)
     */
    private $password;

    public function __construct()
    {
        $this->configs = new ArrayCollection();
        $this->feeders = new ArrayCollection();
    }

    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * @param Config $configs
     */
    public function addConfig($config)
    {
        $this->configs[] = $config;
    }

    /**
     * @return ArrayCollection
     */
    public function getFeeders()
    {
        return $this->feeders;
    }

    /**
     * @param Feeder $feeder
     */
    public function addFeeder($feeder)
    {
        $this->feeders[] = $feeder;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $password
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
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
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}