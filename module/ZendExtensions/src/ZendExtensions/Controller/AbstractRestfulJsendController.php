<?php
namespace ZendExtensions\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Http\Response;

class AbstractRestfulJsendController
    extends AbstractRestfulController
{
    protected function _methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
    }

    # Override default actions as they do not return valid JsonModels
    public function create($data)
    {
        return $this->_methodNotAllowed();
    }

    public function delete($id)
    {
        return $this->_methodNotAllowed();
    }

    public function deleteList()
    {
        return $this->_methodNotAllowed();
    }

    public function get($id)
    {
        return $this->_methodNotAllowed();
    }

    public function getList()
    {
        return $this->_methodNotAllowed();
    }

    public function head($id = null)
    {
        return $this->_methodNotAllowed();
    }

    public function options()
    {
        return $this->_methodNotAllowed();
    }

    public function patch($id, $data)
    {
        return $this->_methodNotAllowed();
    }

    public function replaceList($data)
    {
        return $this->_methodNotAllowed();
    }

    public function patchList($data)
    {
        return $this->_methodNotAllowed();
    }

    public function update($id, $data)
    {
        return $this->_methodNotAllowed();
    }
}