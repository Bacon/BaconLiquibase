<?php
return array(
    'console' => array(
        'router' => array(
            'routes' => array(
                'baconliquibase-aggregate' => array(
                    'type' => 'simple',
                    'options' => array(
                        'route' => 'bacon liquibase aggregate <output>',
                        'defaults' => array(
                            'controller' => 'BaconLiquibase.Controller.Aggregate',
                            'action'     => 'aggregate'
                        )
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'BaconLiquibase.Controller.Aggregate' => function ($sm) {
                return new BaconLiquibase\Controller\AggregateController(
                    $sm->getServiceLocator()->get('ModuleManager')
                );
            },
        ),
    ),
);
