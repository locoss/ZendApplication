<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'GoodCo\Controller\GoodCo' => 'GoodCo\Controller\GoodCoController',
				),
		),
		
		'router' => array(
				'routes' => array(
						'goodco' => array(
								'type' => 'segment',
								'options' => array(
										'route' => '/goodco[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'GoodCo\Controller\GoodCo',
												'action' => 'index',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'goodco' => __DIR__ . '/../view',
				),
		),
		
		
);