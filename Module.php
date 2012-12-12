<?php
/**
 * BaconLiquibase
 *
 * @link      http://github.com/Bacon/BaconLiquibase For the canonical source repository
 * @copyright 2011-2012 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconLiquibase;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Module for aggregating Liquibase changesets.
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * getConfig(): defined by ConfigProviderInterface.
     *
     * @see    ConfigProviderInterface::getConfig()
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * getAutoloaderConfig(): defined by AutoloaderProviderInterface.
     *
     * @see    AutoloaderProviderInterface::getAutoloaderConfig()
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * getServiceConfig(): defined by ServiceProviderInterface.
     *
     * @see    ServiceProviderInterface::getServiceConfig()
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'BaconAssetLoader.AssetManager' => function ($sm) {
                    $service = new AssetManager($sm->get('EventManager'));
                    return $service;
                },
            ),
        );
    }
}
