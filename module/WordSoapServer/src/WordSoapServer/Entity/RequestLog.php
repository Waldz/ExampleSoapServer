<?php

namespace WordSoapServer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\I18n\Validator\DateTime;

/**
 * Class RequestLog is responsible for:
 *  - Data model that wraps data of SOAP log event
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(
 *   name="soap_log",
 *   indexes={
 *      @ORM\Index(name="endpoint", columns={"endpoint"}),
 *      @ORM\Index(name="create_time", columns={"create_time"})
 *   }
 * )
 */

class RequestLog
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    protected $create_time;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=10, scale=3, nullable=true)
     */
    protected $duration;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $endpoint;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $request;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $response;
    
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    /**
     * @return float
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param \DateTime $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_time = $create_date->getTimestamp();

    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        $date = new \DateTime();
        $date->setTimestamp($this->create_time);
        return $date;
    }

    /**
     * @param float $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return float
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

}