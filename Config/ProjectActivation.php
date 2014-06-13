<?php
/**
 * Project Activation
 *
 * Activation class for Project plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class ProjectActivation {

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeActivation(&$controller) {
		return true;
	}

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onActivation(&$controller) {
		// ACL: set ACOs with permissions
		$controller->Croogo->addAco('Project/Project/admin_index'); // ProjectController::admin_index()
		$controller->Croogo->addAco('Project/Project/index', array('registered', 'public')); // ProjectController::index()
		
		//create tables

		
		$db = ConnectionManager::getDataSource('default');
		$sqlstr = "
		INSERT INTO ftypes (id, name, sqltype, extra, created, modified) VALUES
		(1, 'string', 'varchar', NULL, '2013-11-17 00:00:00', '2014-01-09 00:00:00'),
		(2, 'boolean', 'tinyint', NULL, '2013-11-17 00:00:00', '2014-01-09 00:00:00'),
		(4, 'datetime', 'datetime', NULL, '2013-11-17 00:00:00', '2014-01-09 00:00:00'),
		(5, 'integer', 'int', NULL, '2013-11-17 00:00:00', '2013-12-26 00:00:00'),
		(6, 'text', 'text', NULL, '2014-01-09 00:00:00', '2014-01-09 00:00:00');";

		$db->rawQuery($sqlstr);
		
		$this->Link = ClassRegistry::init('Menus.Link');

		// Main menu: add an Project link
		$mainMenu = $this->Link->Menu->findByAlias('main');
		$this->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $mainMenu['Menu']['id'],
			),
		));
		$this->Link->save(array(
			'menu_id' => $mainMenu['Menu']['id'],
			'title' => 'Project',
			'link' => 'plugin:project/controller:project/action:index',
			'status' => 1,
			'class' => 'project',
		));
	}

/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeDeactivation(&$controller) {
		return true;
	}

/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onDeactivation(&$controller) {
		// ACL: remove ACOs with permissions
		$controller->Croogo->removeAco('Project'); // ProjectController ACO and it's actions will be removed

		$this->Link = ClassRegistry::init('Menus.Link');

		// Main menu: delete Project link
		$link = $this->Link->find('first', array(
			'joins' => array(
				array(
					'table' => 'menus',
					'alias' => 'JoinMenu',
					'conditions' => array(
						'JoinMenu.alias' => 'main',
					),
				),
			),
			'conditions' => array(
				'Link.link' => 'plugin:project/controller:project/action:index',
			),
		));
		if (empty($link)) {
			return;
		}
		$this->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $link['Link']['menu_id'],
			),
		));
		if (isset($link['Link']['id'])) {
			$this->Link->delete($link['Link']['id']);
		}
	}
}
