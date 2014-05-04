<?php
namespace ZendExtensions\View\Model;

use Zend\Json\Json;
use Zend\View\Model\JsonModel;

/**
 * JSEND specification implemented as ViewModel of Zend Framework 2.0 @link http://labs.omniti.com/labs/jsend/wiki
 *
 * Class FeedbackValidator is responsible for:
 *  - Standardize the format for communication type SERVER -> CLIENT
 *  - This object will convert given information to JSON response, which meets the specification of JSEND
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 * @package ZendExtensions\View
 */
class JsendModel extends JsonModel
{

    /**
     * When an API call is successful.
     * The JSend object is used as a simple envelope for the results, using the 'data' key, as in the following:
<code>
{
  status : "success",
  data : {
    "post" : {
      "id" : 1,
      "title" : "A blog post",
      "body" : "Some useful content"
    }
  }
}
</code>
     *
     * @var string
     */
    const STATUS_SUCCESS = 'success';

    /**
     * When an API call is rejected due to invalid data or call conditions.
     * The JSend object's 'data' key contains an object explaining what went wrong,
     * typically a hash of validation errors. For example:
<code>
{
  "status" : "fail",
  "data" : {
    "errors": {
      "title" : "A title is required"
    }
  }
}
</code>
     *
     * @var string
     */
    const STATUS_FAIL = 'fail';

    /**
     * When an API call fails due to an error on the server. For example:
<code>
{
  "status" : "error",
  "message" : "Fatal error. DB is unreachable at the moment"
}
</code>
     *
     * @var string
     */
    const STATUS_ERROR = 'error';

    /**
     * Status of the response
     *
     * @var string
     */
    protected $_status;

    /**
     * Error message for STATUS_ERROR status responses.
     *
     * @var string
     */
    protected $_errorMessage;

    /**
     * Error code for STATUS_ERROR status responses.
     *
     * @var string
     */
    protected $_errorCode;

    /**
     * New instance creation method for method chaining
     *
     * @param string $status Response status
     * @param array $data Response data to be returned to client-side
     */
    public function __construct($status = null, $data = null)
    {
        if(isset($status)){
            $this->setStatus($status);
        }
        if(isset($data)) {
            $this->setVariables($data);
        }
    }

    /**
     * @param array $data Response data to be returned to client-side
     *
     * @return $this
     */
    public static function statusSuccess($data = null)
    {
        return new self(self::STATUS_SUCCESS, $data);
    }

    /**
     * @param array|string|int $data Response data to be returned to client-side
     *
     * @return $this
     */
    public static function statusFail($data = null)
    {
        return new self(self::STATUS_FAIL, $data);
    }

    /**
     * @param string $errorMessage
     * @param string $errorCode
     * @param array|string|int $data Response data to be returned to client-side
     *
     * @return $this
     */
    public static function statusError($errorMessage = null, $errorCode = null, $data = null)
    {
        $jsend = new self(self::STATUS_ERROR, $data);
        return $jsend->setErrorMessage($errorMessage)
            ->setErrorCode($errorCode);
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->_status = $status;

        return $this;
    }

    /**
     * @param string $msg
     * @return $this
     */
    public function setErrorMessage($msg)
    {
        $this->_errorMessage = $msg;

        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setErrorCode($code)
    {
        $this->_errorCode = $code;

        return $this;
    }

    /**
     * Converts current object to JSEND structure
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function toArray()
    {
        $data = $this->getVariables();
        if ($data instanceof Traversable) {
            $data = ArrayUtils::iteratorToArray($data);
        }

        switch ($this->_status) {
            case self::STATUS_SUCCESS:
            case self::STATUS_FAIL:
                $jsend = array(
                    'status' => $this->_status,
                    'data'   => $data,
                );
                break;

            case self::STATUS_ERROR:
                $jsend = array(
                    'status'  => $this->_status,
                    'message' => $this->_errorMessage,
                );
                if (!is_null($this->_errorCode)) {
                    $jsend['code'] = $this->_errorCode;
                }
                if (!is_null($this->_data)) {
                    $jsend['data'] = $data;
                }
                break;

            default:
                throw new \InvalidArgumentException('Unknown status: "' . $this->_status . '"');
        }

        return $jsend;
    }

    /**
     * Serialize to JSON
     * @depreciated Please dont echo to response!! Use @see send() because it prints HTTP headers for IE
     *
     * @return string
     */
    public function serialize()
    {
        $jsend = $this->toArray();
        return Json::encode($jsend);
    }

    /**
     * Serialize to JSON
     *
     * @return string
     */
    public function serializePreview()
    {
        // TODO Better to develop separate methods documentation viewer for browsing users
        $priorities = explode(',', $_SERVER['HTTP_ACCEPT']);
        // Output for browser
        if(isset($priorities[0]) && $priorities[0]=='text/html') {
            ob_start();
            var_export($this->getVariables());
            return ob_get_clean();

        // Output for AJAX client
        } else {
            return parent::serialize();
        }

    }

    /**
     * @depreciated Please dont echo to response!! Use @see $event->setViewModel() because it prints HTTP headers for IE
     * @return string
     */
    public function __toString()
    {
        return $this->serialize();
    }
}
