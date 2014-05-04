<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace LandingPage;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Register a dispatch event
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'setLayout'), 2);
    }

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

    /**
     * Set the layout template for all controllers from this module
     *
     * @param MvcEvent $e
     */
    public function setLayout(MvcEvent $e)
    {
        $matches    = $e->getRouteMatch();
        $domain = $matches->getParam('domain');
        if(!in_array($domain, array('LandingPage.domain'))) {
            return;
        }

        $controller = $matches->getParam('controller');
        if (false===strpos($controller, __NAMESPACE__)) {
            return;
        }

        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('layout-landing/layout_landing');
    }

}
