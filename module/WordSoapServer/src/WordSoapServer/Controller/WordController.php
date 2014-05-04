<?php
namespace WordSoapServer\Controller;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Soap\AutoDiscover;

class WordController extends AbstractActionController
{   
    
    public function indexAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        /** @var Response $response */
        $response = $this->getResponse();

        // TODO Implement server
        $response->setContent('SOAP');

        return $response;
    }
     
}
