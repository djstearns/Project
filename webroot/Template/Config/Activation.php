<?php
/**
 * Example Activation
 *
 * Activation class for Example plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class ExampleActivation {

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
		App::uses('ConnectionManager', 'Model');
		
		$db = ConnectionManager::getDataSource('default');
		$db->rawQuery(sql_create);
		
		App::uses('ShellDispatcher', 'Console');
		App::uses('BakeShell', 'Console/Command');
		App::uses('Shell', 'Console');
		App::uses('AppShell', 'Console/Command');
		App::uses('Model', 'Model');
		
		$thisshell = new Shell();
		$thisshell->initialize();
		$thisshell->dispatchShell('Bake model Kids --plugin Jamiesapp --theme croogo');
		$thisshell->dispatchShell('Bake model Letters --plugin Jamiesapp --theme croogo');
		$thisshell->dispatchShell('Bake controller Kids --plugin Jamiesapp --theme croogo --admin');
		$thisshell->dispatchShell('Bake controller Letters --plugin Jamiesapp --theme croogo --admin');
		$thisshell->dispatchShell('Bake view Kids --plugin Jamiesapp --theme croogo');
		$thisshell->dispatchShell('Bake view Letters --plugin Jamiesapp --theme croogo');
		
		App::uses('CroogoPlugin', 'Extensions.Lib');
		$CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('YourPlugin');
		$controller->Croogo->addAco('Example/Example/admin_index'); // ExampleController::admin_index()
		$controller->Croogo->addAco('Example/Example/index', array('registered', 'public')); // ExampleController::index()

		$this->Link = ClassRegistry::init('Menus.Link');

		// Main menu: add an Example link
		$mainMenu = $this->Link->Menu->findByAlias('main');
		$this->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $mainMenu['Menu']['id'],
			),
		));
		$this->Link->save(array(
			'menu_id' => $mainMenu['Menu']['id'],
			'title' => 'Example',
			'link' => 'plugin:example/controller:example/action:index',
			'status' => 1,
			'class' => 'example',
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
		App::uses('CroogoPlugin', 'Extensions.Lib');
		$CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->unmigrate('YourPlugin');
		// ACL: remove ACOs with permissions
		$controller->Croogo->removeAco('Example'); // ExampleController ACO and it's actions will be removed

		$this->Link = ClassRegistry::init('Menus.Link');

		// Main menu: delete Example link
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
				'Link.link' => 'plugin:example/controller:example/action:index',
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
