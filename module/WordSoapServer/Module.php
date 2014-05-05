<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace WordSoapServer;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'WordSoapServer_service_WordService' => function (ServiceManager $sm) {
                    $service = new Service\WordService();
                    return $service;
                },
                'WordSoapServer_service_LoggerService' => function (ServiceManager $sm) {
                    /** @var EntityManager $orm */
                    $orm = $sm->get('doctrine.entitymanager.orm_default');

                    $service = new Service\LoggerService($orm);
                    return $service;
                },
            ),
        );
    }

}
