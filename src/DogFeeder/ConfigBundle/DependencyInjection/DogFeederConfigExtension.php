<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.07.
 * Time: 22:11
 */

namespace DogFeeder\ConfigBundle\DependencyInjection;


use DogFeeder\ConfigBundle\ConfigRegistry;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class DogFeederConfigExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.xml');

        $this->addClassesToCompile(array(
            ConfigRegistry::class,
        ));
    }


}