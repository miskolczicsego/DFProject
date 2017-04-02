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
     * @param $key
     * @param $userId
     * @return Config|null|object|NotFoundHttpException
     */
    public function get($key, $userId)
    {
        $config =  $this->getConfigRepository()->findOneBy(array(
            'key' => $key,
            'user' => $userId
        ));

        if ($config === null) {
            return new NotFoundHttpException('Config with this key, was not found');
        }

        return $config;
    }

    public function getValue($key, $userId)
    {
        return $this->get($key, $userId )->getValue();
    }

    /**
     * Set new config
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value, $user)
    {
        $config = new Config();
        $config->setKey($key);
        $config->setValue($value);
        $config->setUser($user);

        $this->em->persist($config);
        $this->em->flush();
    }

    /**
     * Update config
     *
     * @param $key
     * @param $value
     */
    public function update($key, $value)
    {
        $config = $this->getConfigRepository()->findOneBy(array(
            'key' => $key
        ));

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