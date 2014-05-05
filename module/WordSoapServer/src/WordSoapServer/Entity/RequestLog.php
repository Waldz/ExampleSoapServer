<?php

namespace WordSoapServer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RequestLog is responsible for:
 *  - Data model that wraps data of SOAP log event
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="soap_log")
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
     * @var \DateTime
     *
     * @ORM\Column(nullable=false)
     * @ORM\Column(type="datetime")
     */
    protected  $create_date;

    /**
     * @var float
     *
     * @ORM\Column(nullable=false)
     * @ORM\Column(type="decimal", precision=10, scale=3, nullable=true)
     */
    protected  $duration;

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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $create_date
     * @return $this
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param float $duration
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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