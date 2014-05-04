<?php
namespace ZendExtensions\Test\PHPUnit;

use PhlyRestfully\ResourceController;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\MvcEvent;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

abstract class AbstractRestfulControllerTestCase
    extends AbstractHttpControllerTestCase
{

    /**
     * @var ResourceController
     */
    private $_resourceController;

    /**
     * @var Resource
     */
    private $_resource;

    private $_router;

    /**
     * @var MvcEvent
     */
    private $_event;

    /**
     * @var AbstractListenerAggregate
     */
    protected $_resourceListener;

    //protected $_request;
    //protected $_response;
    //protected $_routeMatch;

    protected function setUp()
    {
        parent::setUp();

        /*$resourceController = $this->getResourceController();
        if(!$resourceController) {
            throw new \UnexpectedValueException('Please setResourceController() before setUp()');
        }

        $resourceListener = $this->getResourceListener();
        if(!$resourceListener) {
            throw new \UnexpectedValueException('Please setResourceListener() before setUp()');
        }

        $resourceController->getEventManager()->attach($resourceListener);*/
    }

    /**
     * @param \PhlyRestfully\ResourceController $controller
     */
    public function setResourceController($controller)
    {
        if(!$controller instanceof AbstractController) {
            /** @var ControllerManager $controllerManager */
            $controllerManager = $this->getApplicationServiceLocator()->get('ControllerLoader');
            $controller = $controllerManager->get($controller);
        }
        $this->_resourceController = $controller;
    }

    /**
     * @return \PhlyRestfully\ResourceController
     */
    public function getResourceController()
    {
        return $this->_resourceController;
    }

    /**
     * @param \Zend\EventManager\AbstractListenerAggregate $resourceListener
     */
    public function setResourceListener($resourceListener)
    {
        $this->_resourceListener = $resourceListener;
    }

    /**
     * @return \Zend\EventManager\AbstractListenerAggregate
     */
    public function getResourceListener()
    {
        return $this->_resourceListener;
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return parent::getResponse();
    }

    /**
     * @return ViewModel|mixed
     */
    public function getResponseResult()
    {
        /** @var MvcEvent $event */
        $event = $this->getApplication()->getMvcEvent();
        return $event->getResult();
    }
}