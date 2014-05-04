<?php
namespace ZendExtensions\Navigation\Service;

use Zend\Navigation\Page\AbstractPage;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class CustomNavigationFactory
    extends DefaultNavigationFactory
{

    /**
     * Config path name Config[navigation.{name}] where pages configuration lays
     *
     * @var string
     */
    private $_name;

    /**
     * Class that will be used as navigation pages container
     * @var string
     */
    private $_classNavigation = 'Zend\Navigation\Navigation';

    /**
     * Set Config path name Config[navigation.{name}]
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Get Config path name Config[navigation.{name}]
     *
     * @return string
     */
    public function getName()
    {
        if(isset($this->_name)) {
            return $this->_name;
        } else {
            return parent::getName();
        }
    }

    /**
     * Change navigation container class name
     *
     * @param string $class
     */
    public function setClassNavigation($class)
    {
        $this->_classNavigation = $class;
    }

    /**
     * @return string
     */
    public function getClassNavigation()
    {
        return $this->_classNavigation;
    }

    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $pages = $this->getPages($serviceLocator);
        $navigation = new $this->_classNavigation($pages);

        $this->_configurePages($navigation->getPages());

        return $navigation;
    }

    /**
     * @param AbstractPage[] $pages
     */
    protected function _configurePages($pages)
    {
        foreach($pages as $page) {
            // Hook before kids load
            $this->_preConfigurePage($page);

            // Load kinds
            $this->_configurePages($page->getPages());

            // Hook after kids loaded
            $this->_postConfigurePage($page);
        }
    }

    /**
     * Hook to calculate page options before his kids load
     *
     * @param AbstractPage $page
     */
    protected function _preConfigurePage($page)
    {
        // Do nothing

        /*
        $class = $page->getClass();
        if(empty($class)) {
            $page->setClass('page');
        };
        */
    }

    /**
     * Hook to calculate page options before his kids load
     *
     * @param AbstractPage $page
     */
    protected function _postConfigurePage($page)
    {
        // Do nothing
    }

}