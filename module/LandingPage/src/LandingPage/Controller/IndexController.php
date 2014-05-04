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
use Zend\View\Model\ViewModel;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

class IndexController extends AbstractActionController
{   
    
    public function indexAction()
    {           
        return new ViewModel(array(
        ));
    }

    public function pageAction()
    {
        return new ViewModel(array(
        ));
    }
     
}
