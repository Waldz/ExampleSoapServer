<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace LandingPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Soap\Client;
use Zend\View\Helper\ServerUrl;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

class IndexController extends AbstractActionController
{

    /** @var Client */
    private $_soapClient;

    /**
     * @param Client $soapClient
     */
    public function setSoapClient($soapClient)
    {
        $this->_soapClient = $soapClient;
    }

    /**
     * @return Client
     */
    public function getSoapClient()
    {
        if(!isset($this->_soapClient)) {
            $helperServer = new ServerUrl();
            $this->_soapClient = new Client(
                $helperServer($this->url()->fromRoute('word-soap'))
            );
        }
        return $this->_soapClient;
    }

    /**
     * UI form for Word SOAP service demonstration
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $soapClient = $this->getSoapClient();
        $view = new ViewModel();

        // Read form params
        $word = $this->params()->fromQuery('word');
        $view->setVariable('word', $word);

        // Perform request if form was submitted
        if ($this->params()->fromQuery('submit')) {
            try {
                $wordFlipped = $soapClient->wordFlip($word);
                $view->setVariable('wordFlipped', $wordFlipped);
            } catch(\Exception $e) {
                $view->setVariable('wordFlipped', null);
            }
            $view->setVariable('soapRequest', $soapClient->getLastRequest());
            $view->setVariable('soapResponse', $soapClient->getLastResponse());
        }

        return $view;
    }

    public function pageAction()
    {
        return new ViewModel(array(
        ));
    }
     
}
