<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.07.
 * Time: 21:36
 */

namespace DogFeeder\ConfigBundle;


use Doctrine\ORM\EntityManager;
use DogFeeder\ConfigBundle\Entity\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConfigRegistry
{
    public $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get config by key
     *
     * @param $key
     */
    public function get($key)
    {
        $config =  $this->getConfigRepository()->findOneBy(array(
           'key' => $key
        ));

        if ($config === null) {
            return new NotFoundHttpException('Config with this key, was not found');
        }

        return $config;
    }

    public function getConfig($key) {
        return $this->get($key);
    }

    /**
     * Set new config
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $config = new Config();
        $config->setKey($key);
        $config->setValue($value);

        $this->em->persist($config);
        $this->em->flush();
    }

    public function getConfigRepository()
    {
        return $this->em->getRepository('ConfigBundle:Config');
    }



}