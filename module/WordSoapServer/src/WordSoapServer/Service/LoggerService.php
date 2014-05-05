<?php

namespace WordSoapServer\Service;
use Doctrine\ORM\EntityManager;
use WordSoapServer\Entity\RequestLog;

/**
 * Class LoggerService is responsible for:
 *  - Logs SOAP requests to DB
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class LoggerService
{

    /**
     * @var EntityManager
     */
    private $_entityManager;

    /**
     * Constructor with essential data
     *
     * @param EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * @param EntityManager $entityManager
     * @return $this
     */
    public function setEntityManager($entityManager)
    {
        $this->_entityManager = $entityManager;
        return $this;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->_entityManager;
    }

    /**
     * Inits log event for SOAP request
     *
     * @param string $endpoint ULL of endpoint which was requested e.g. soap/word
     * @param string $requestXml Request XML source
     *
     * @return RequestLog Log event
     */
    public function requestStart($endpoint, $requestXml)
    {
        $orm = $this->getEntityManager();

        $requestLog = new RequestLog();
        $requestLog->setCreateTime(microtime(true));
        $requestLog->setEndpoint($endpoint);
        $requestLog->setRequest($requestXml);

        $orm->persist($requestLog);
        $orm->flush($requestLog);

        return $requestLog;
    }

    /**
     * Ands response data to log events
     *
     * @param RequestLog $requestLog Log event
     * @param string $responseXml Response XML source
     *
     * @return RequestLog Log event
     */
    public function requestEnd($requestLog, $responseXml)
    {
        $orm = $this->getEntityManager();

        $requestLog->setResponse($responseXml);
        $requestLog->setDuration(
            microtime(true) - $requestLog->getCreateTime()
        );

        // Save node
        if($requestLog->getId()>0) {
            $orm->flush();
        } else {
            $orm->persist($requestLog);
            $orm->flush();
        }

        return $requestLog;
    }
}