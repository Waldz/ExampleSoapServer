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
);