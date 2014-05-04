<?php

namespace ZendExtensions\Model;

/**
 * Class Debug
 */
class Debug {

    /**
     * @param string|mixed $message
     */
    public static function debug($message) {
        self::log($message);
        if ($message instanceof Exception) {
            //$this->logger->error($message);
        } else {
            //$this->logger->info($message);
        }
    }

    /**
     * Let me print all callstack for You
     *
     * @param boolean $printVariables (optional) Print variable values in backtrace or not
     *
     */
    public static function backtrace($printVariables=false)
    {
        ob_start(array('Debug::debug'));
        if(!$printVariables && version_compare(PHP_VERSION, '5.3.6') >=0) {
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        } else {
            debug_print_backtrace();
        }
        ob_get_clean();
    }

    public static function log($message)
    {
        return;

        // TODO Error loging by config
        $message = self::_prepareObjectForPrint($message);
        if (!is_string($message)) {
            $message = \Zend\Debug\Debug::dump($message, null, false);
        }

        echo $message;
    }

    /**
     * @param mixed $message
     *
     * @return string
     */
    private static function _prepareObjectForPrint($message) {
        if(is_string($message)) {
            // Do nothing
        } elseif (is_array($message)) {
            foreach($message as &$element) {
                $element = self::_prepareObjectForPrint($element);
            }
        } elseif ($message instanceof \Exception) {
            $message = self::_printException($message);
        } elseif ($message instanceof \Zend\Db\Sql\AbstractSql) {
            $message = $message->__toString();
        } else {
            ob_start();
            \Doctrine\Common\Util\Debug::dump($message);
            $message = ob_get_clean();
        }

        return $message;
    }

    /**
     * @param Exception $exception
     */
    private static function _printException($exception) {
        // TODO Padaryti loginima i faila
        /*
        $serviceAccess = $this->getServiceAccess();

        $message = $exception->__toString();
        if($user = $serviceAccess->getUser()) {
            $message .= PHP_EOL. sprintf('USER: %s %s (%d)', $user['first_name'], $user['last_name'], $user['id']);
        }
        if($client = $serviceAccess->getClient()) {
            $message .= PHP_EOL. sprintf("CLIENT: %s (%d)", $client['about'], $client['id']);
        }
        if (!empty($_SERVER)) {
            $message .= PHP_EOL. "URL: ".$_SERVER['REQUEST_URI'];
        }
        if (!empty($_GET)) {
            $message .= PHP_EOL. "GET: ".print_r($_GET, 1);
        }
        if (!empty($_POST)) {
            $message.= PHP_EOL. "POST: ".print_r($_POST, 1);
        }

        return $message;
        */
    }

}