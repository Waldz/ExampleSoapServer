<?php

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /soap/:controller/:action
            'word-soap' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/soap/word',
                    'defaults' => array(
                        'controller' => 'WordSoapServer\Controller\Word',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'WordSoapServer\Controller\Word' => 'WordSoapServer\Controller\WordController',
        ),
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'WordSoapServerEntities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/WordSoapServer/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'WordSoapServer\Entity' => 'WordSoapServerEntities',
                )
            ),
        ),
    ),
);