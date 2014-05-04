<?php
namespace WordSoapServer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;
use Zend\View\Helper\ServerUrl;

class WordController extends AbstractActionController
{

    /** @var AutoDiscover */
    private $_soapGenerator;

    /** @var  Server */
    private $_soapServer;

    /**
     * @param \Zend\Soap\AutoDiscover $soapGenerator
     */
    public function setSoapGenerator($soapGenerator)
    {
        $this->_soapGenerator = $soapGenerator;
    }

    /**
     * @return \Zend\Soap\AutoDiscover
     */
    public function getSoapGenerator()
    {
        if(!isset($this->_soapGenerator)) {
            $helperServer = new ServerUrl();

            $this->_soapGenerator = new AutoDiscover();
            $this->_soapGenerator->setServiceName('WordService');
            $this->_soapGenerator->setUri(
                $helperServer( $this->url()->fromRoute()) );
        }

        return $this->_soapGenerator;
    }

    /**
     * @param \Zend\Soap\Server $soapServer
     */
    public function setSoapServer($soapServer)
    {
        $this->_soapServer = $soapServer;
    }

    /**
     * @return \Zend\Soap\Server
     */
    public function getSoapServer()
    {
        if(!isset($this->_soapServer)) {
            $this->_soapServer = new Server();
        }

        return $this->_soapServer;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        switch($request->getMethod()) {
            // Serve server actions
            case Request::METHOD_POST:
                return $this->soapAction();

            // Render server WSDL document
            case Request::METHOD_GET:
            default:
                return $this->wsdlAction();
        }
    }

    /**
     * Render server WSDL document
     *
     * @return Response
     */
    public function wsdlAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();
        $wsdlGenerator = $this->getSoapGenerator();

        //$response->getHeaders()->addHeaderLine('Content-Type', 'application/wsdl+xml');
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/xml');
        $response->setContent(
            $wsdlGenerator->generate()->toXML()
        );

        return $response;
    }

    /**
     * Serves all server's calls
     *
     * @return Response
     */
    public function soapAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();
        $server = $this->getSoapServer()
            ->setReturnResponse(true);

        $response->getHeaders()->addHeaderLine('Content-Type', 'application/xml');
        $response->setContent(
            $server->handle()
        );

        return $response;
    }
     
}