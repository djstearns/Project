<?php
/**
 * Routes
 *
 * project_routes.php will be loaded in main app/config/routes.php file.
 */
Croogo::hookRoutes('Project');

/**
 * Behavior
 *
 * This plugin's Project behavior will be attached whenever Node model is loaded.
 */
//Croogo::hookBehavior('Node', 'Project.Project', array());

/**
 * Component
 *
 * This plugin's Project component will be loaded in ALL controllers.
 */
//Croogo::hookComponent('*', 'Project.Project');

/**
 * Helper
 *
 * This plugin's Project helper will be loaded via NodesController.
 */
Croogo::hookHelper('Nodes', 'Project.Project');

/**
 * Admin menu (navigation)
 */
CroogoNav::add(
		'Apps', array(
			'title' => 'Apps',
			'url' => '#',
			'children' => array(
				'Projects' => array(
					'title' => 'Projects',
					'url' => '#',
					'children'=> array(
						'List' => array(
							'title' => 'List',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'projects',
								'action' => 'index',
							),
						),
						'Add' => array(
							'title' => 'Add',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'projects',
								'action' => 'add',
							),
						),
					)
				),
				
				'Objects' => array(
					'title' => 'Objects',
					'url' => '#',
					'children'=> array(
						'List' => array(
							'title' => 'List',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'pobjects',
								'action' => 'index',
							),
						),
						'Add' => array(
							'title' => 'Add',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'pobjects',
								'action' => 'add',
							),
						),
					)
				),
				
				
				'flds' => array(
					'title' => 'Field Types',
					'url' => '#',
					'children'=> array(
						'List' => array(
							'title' => 'List',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'ftypes',
								'action' => 'index',
							),
						),
						'Add' => array(
							'title' => 'Add',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'ftypes',
								'action' => 'add',
							),
						),
					)
				),
				
				'flds' => array(
					'title' => 'Fields',
					'url' => '#',
					'children'=> array(
						'List' => array(
							'title' => 'List',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'flds',
								'action' => 'index',
							),
						),
						'Add' => array(
							'title' => 'Add',
							'url' => array(
								'admin' => true,
								'plugin' => 'project',
								'controller' => 'flds',
								'action' => 'add',
							),
						),
					)
				),
				
				'behaviors' => array(
					'title' => 'Behaviors',
					'url' => '#',
					'children'=> array(
						'opjectbehaviors' => array(
							'title' => 'Object Behaviors',
							'url' => '#',
							'children'=> array(
								'List' => array(
									'title' => 'List',
									'url' => array(
										'admin' => true,
										'plugin' => 'project',
										'controller' => 'pobjectbehaviors',
										'action' => 'index',
									),
								),
								'Add' => array(
									'title' => 'Add',
									'url' => array(
										'admin' => true,
										'plugin' => 'project',
										'controller' => 'pobjectbehaviors',
										'action' => 'add',
									),
								),
								
							)
						),
						'fldbehaviors' => array(
							'title' => 'Field Behaviors',
							'url' => '#',
							'children'=> array(
								'List' => array(
									'title' => 'List',
									'url' => array(
										'admin' => true,
										'plugin' => 'project',
										'controller' => 'fldbehaviors',
										'action' => 'index',
									),
								),
								'Add' => array(
									'title' => 'Add',
									'url' => array(
										'admin' => true,
										'plugin' => 'project',
										'controller' => 'fldbehaviors',
										'action' => 'add',
									),
								),
							)
						),
					)
				),
				
				
		
		
		
		
		'project2' => array(
			'title' => 'Project 2 with a title that won\'t fit in the sidebar',
			'url' => '#',
			'children' => array(
				'project-2-1' => array(
					'title' => 'Project 2-1',
					'url' => '#',
					'children' => array(
						'project-2-1-1' => array(
							'title' => 'Project 2-1-1',
							'url' => '#',
							'children' => array(
								'project-2-1-1-1' => array(
									'title' => 'Project 2-1-1-1',
								),
							),
						),
					),
				),
			),
		),
		'project3' => array(
			'title' => 'Chooser Project',
			'url' => array(
				'admin' => true,
				'plugin' => 'project',
				'controller' => 'project',
				'action' => 'chooser',
			),
		),
		'project4' => array(
			'title' => 'RTE Project',
			'url' => array(
				'admin' => true,
				'plugin' => 'project',
				'controller' => 'project',
				'action' => 'rte_project',
			),
		),
	),
)
);

$Localization = new L10n();
Croogo::mergeConfig('Wysiwyg.actions', array(
	'Project/admin_rte_project' => array(
		array(
			'elements' => 'ProjectBasic',
			'preset' => 'basic',
		),
		array(
			'elements' => 'ProjectStandard',
			'preset' => 'standard',
			'language' => 'ja',
		),
		array(
			'elements' => 'ProjectFull',
			'preset' => 'full',
			'language' => $Localization->map(Configure::read('Site.locale')),
		),
		array(
			'elements' => 'ProjectCustom',
			'toolbar' => array(
				array('Format', 'Bold', 'Italic'),
				array('Copy', 'Paste'),
			),
			'uiColor' => '#ffe79a',
			'language' => 'fr',
		),
	),
));

/**
 * Admin row action
 *
 * When browsing the content list in admin panel (Content > List),
 * an extra link called 'Project' will be placed under 'Actions' column.
 */
Croogo::hookAdminRowAction('Nodes/admin_index', 'Project', 'plugin:project/controller:project/action:index/:id');

/* Row action with link options */
Croogo::hookAdminRowAction('Nodes/admin_index', 'Button with Icon', array(
	'plugin:project/controller:project/action:index/:id' => array(
		'options' => array(
			'icon' => 'key',
			'button' => 'success',
		),
	),
));

/* Row action with icon */
Croogo::hookAdminRowAction('Nodes/admin_index', 'Icon Only', array(
	'plugin:project/controller:project/action:index/:id' => array(
		'title' => false,
		'options' => array(
			'icon' => 'picture',
			'tooltip' => array(
				'data-title' => 'A nice and simple action with tooltip',
				'data-placement' => 'left',
			),
		),
	),
));

/**
 * Admin tab
 *
 * When adding/editing Content (Nodes),
 * an extra tab with title 'Project' will be shown with markup generated from the plugin's admin_tab_node element.
 *
 * Useful for adding form extra form fields if necessary.
 */
 
 
Croogo::hookAdminTab('Nodes/admin_add', 'Project', 'project.admin_tab_node');
Croogo::hookAdminTab('Nodes/admin_edit', 'Project', 'project.admin_tab_node');
