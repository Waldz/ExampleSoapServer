<?php

namespace ZendExtensions\Test\PHPUnit;

abstract class AbstractDatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var \Zend\Mvc\ApplicationInterface
     */
    protected $_application;

    /**
     * only instantiate pdo once for test clean-up/fixture load
     *
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    static private $conn = null;

    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    final public function getConnection()
    {
        if (!isset(self::$conn)) {
            /** @var \Doctrine\ORM\EntityManager $orm */
            $orm = $this->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
            $params = $orm->getConnection()->getParams();

            $pdo = new \PDO(
                sprintf('mysql:host=%s;post=%d;dbname=%s', $params['host'], $params['port'], $params['dbname']),
                $params['user'],
                $params['password']
            );
            self::$conn = $this->createDefaultDBConnection($pdo, $params['dbname']);
        }

        return self::$conn;
    }

    /**
     * Returns the database operation executed in test setup.
     *
     * @return PHPUnit_Extensions_Database_Operation_DatabaseOperation
     */
    protected function getSetUpOperation()
    {
        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            \PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }

    /**
     * @return \Zend\Mvc\ApplicationInterface
     */
    abstract public function getApplication();
}