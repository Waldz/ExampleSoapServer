<?php
namespace WordSoapServer\Controller;

use WordSoapServer\Service\LoggerService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;
use Zend\View\Helper\ServerUrl;

/**
 * Class WordController is responsible for:
 *  - Generates WSDL document for @see WordService
 *  - Serve HTTP requests for @see WordService
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class WordController extends AbstractActionController
{

    /** @var AutoDiscover */
    private $_soapGenerator;

    /** @var Server */
    private $_soapServer;

    /** @var LoggerService */
    private $_soapLogger;

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
            $this->_soapGenerator->setClass('\WordSoapServer\Service\WordService');
            $this->_soapGenerator->setUri(
                $helperServer($this->url()->fromRoute())
            );
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
            $helperServer = new ServerUrl();

            $this->_soapServer = new Server();
            $this->_soapServer->setClass('\WordSoapServer\Service\WordService');
            $this->_soapServer->setUri(
                $helperServer($this->url()->fromRoute())
            );
            $this->_soapServer->registerFaultException('\InvalidArgumentException');
        }

        return $this->_soapServer;
    }

    /**
     * @param \WordSoapServer\Service\LoggerService $soapLogger
     */
    public function setSoapLogger($soapLogger)
    {
        $this->_soapLogger = $soapLogger;
    }

    /**
     * @return \WordSoapServer\Service\LoggerService
     */
    public function getSoapLogger()
    {
        if(!isset($this->_soapLogger)) {
            $this->_soapLogger = $this->getServiceLocator()->get('WordSoapServer_service_LoggerService');
        }
        return $this->_soapLogger;
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
        /** @var Request $request */
        $request = $this->getRequest();
        /** @var Response $response */
        $response = $this->getResponse();
        $serviceLogger = $this->getSoapLogger();
        $server = $this->getSoapServer()
            ->setReturnResponse(true);

        // Read XML request
        $requestXml = $request->getContent();
        $requestLog = $serviceLogger->requestStart($this->url()->fromRoute(), $requestXml);

        // Handle XML request
        $responseXml = $server->handle($requestXml);
        if($responseXml instanceof \SoapFault) {
            $responseXml = (string) $responseXml;
        }
        $requestLog = $serviceLogger->requestEnd($requestLog, $responseXml);

        // Send XML response
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/xml');
        $response->setContent($responseXml);

        return $response;
    }
     
}