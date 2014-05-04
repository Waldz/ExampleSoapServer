<?php

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /landing-page/:controller/:action
            'landing-page' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'domain'        => 'LandingPage.domain',
                        'controller'    => 'LandingPage\Controller\Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => ':action[/:param][/]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'param'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'LandingPage\Controller\Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'home' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '',
                            'defaults' => array(
                                'controller' => 'LandingPage\Controller\Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                // Console routes go here
            )
        )
    ),

    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'LandingPage\Controller\Index' => 'LandingPage\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => include __DIR__ . '/../template_map.php',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'layout' => 'layout-landing/layout_landing',
    ),
);