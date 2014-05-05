<?php

namespace WordSoapServerTest\Service;

use WordSoapServer\Entity\RequestLog;
use WordSoapServer\Service\LoggerService;

/**
 * Class LoggerServiceTest is responsible for:
 *  - Tests if saving logs to database is performed correctly
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class LoggerServiceTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
    }

    public function testRequestStartSavesToDatabase()
    {
        $ormMock = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            array('persist', 'flush'),
            array(),
            '',
            false
        );
        $serviceLogger = new LoggerService($ormMock);

        $ormMock->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(true));
        $ormMock->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(true));

        $requestLog = $serviceLogger->requestStart('soap/service', 'XML request');
        $this->assertEquals('soap/service', $requestLog->getEndpoint());
        $this->assertEquals('XML request', $requestLog->getRequest());
        $this->assertEquals(null, $requestLog->getResponse());
        $this->assertNotNull($requestLog->getCreateDate());
        $this->assertNull($requestLog->getDuration());
    }

    public function testRequestEndSavesToDatabaseWhenEditing()
    {
        $ormMock = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            array('persist', 'flush'),
            array(),
            '',
            false
        );
        $serviceLogger = new LoggerService($ormMock);

        $ormMock->expects($this->never())
            ->method('persist')
            ->will($this->returnValue(true));
        $ormMock->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(true));

        $requestLog = new RequestLog();
        $requestLog->setId(1);
        $requestLog->setEndpoint('soap/service');
        $requestLog->setRequest('XML request');
        $requestLog->setCreateDate(new \DateTime('2014-05-05 13:56:10'));

        $requestLog = $serviceLogger->requestEnd($requestLog, 'XML response');
        $this->assertEquals('soap/service', $requestLog->getEndpoint());
        $this->assertEquals('XML request', $requestLog->getRequest());
        $this->assertEquals('XML response', $requestLog->getResponse());
        $this->assertNotNull($requestLog->getCreateDate());
        $this->assertNotNull($requestLog->getDuration());
    }

    public function testRequestEndSavesToDatabaseWhenCreatingNew()
    {
        $ormMock = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            array('persist', 'flush'),
            array(),
            '',
            false
        );
        $serviceLogger = new LoggerService($ormMock);

        $ormMock->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(true));
        $ormMock->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(true));

        $requestLog = new RequestLog();
        $requestLog->setId(null);
        $requestLog->setEndpoint('soap/service');
        $requestLog->setRequest('XML request');
        $requestLog->setCreateDate(new \DateTime('2014-05-05 13:56:10'));

        $requestLog = $serviceLogger->requestEnd($requestLog, 'XML response');
        $this->assertEquals('soap/service', $requestLog->getEndpoint());
        $this->assertEquals('XML request', $requestLog->getRequest());
        $this->assertEquals('XML response', $requestLog->getResponse());
        $this->assertNotNull($requestLog->getCreateDate());
        $this->assertNotNull($requestLog->getDuration());
    }

}
