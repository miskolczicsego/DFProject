<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.05.
 * Time: 6:17
 */

namespace DogFeeder\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="config")
 */
class Config
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="config", type="string", length=64, unique=true)
     */
    private $config;

    /**
     * @ORM\Column(name="value", type="string", length=64)
     */
    private $value;

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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $key
     */
    public function setConfig($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }



}