<?php
App::uses('ProjectAppController', 'Project.Controller');
/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 */
class ProjectsController extends ProjectAppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->unlockedActions = array('editindexsavefld','admin_editindexsavefld','makeplugin');
		
	}
	
	public $ignoretables = array(	
									"acos",
									"aros",
									"aros_acos",
									"blocks",
									"comments",
									"contacts",
									"i18n",
									"languages",
									"links",
									"menus",
									"messages",
									"meta",
									"nodes",
									"nodes_taxonomies",
									"regions",
									"roles",
									"settings",
									"taxonomies",
									"terms",
									"types",
									"types_vocabularies",
									"users",
									"vocabularies");
									
	public $helpers = array('Html', 'Form', 'FileManager.FileManager');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * indexold method
 *
 * @return void
 */
	public function indexOLD() {
		$this->Project->recursive = 0;
		$this->set('projects', $this->paginate());
	}
    
    
 /**
 * index method
 *
 * @return void
 */ 
          function index() {
            //$this->Project->recursive = 0;
            $this->set('projects', $this->paginate());
             //check if this is a relationship table
                                     $projectdata = $this->Project->find('all');
                        
           
           
                        
            		$users = $this->Project->User->find('list');
		$this->set(compact('projectdata', 'users'));
            
        
	}
  
  
     function savehabtmfld(){
  
		$this->autoRender = false;
		$this->Project->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Project->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Project'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Project->save($this->data)) {
			$response = true;
				
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
    
     function admin_savehabtmfld(){
  
		$this->autoRender = false;
		$this->Project->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Project->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Project'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Project->save($this->data)) {
			$response = true;
				
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
     function deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['Project'] as $project_id => $del){
			if($del == 1 ){$arr[] = $project_id;}
		}
		if($this->Project->deleteAll(array('Project.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->Project->id = $_POST['pk'];
		
		if($this->Project->saveField($_POST['name'],$_POST['value'])) {
			$response = true;	
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
  
  
    

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
		$this->set('project', $this->Project->find('first', $options));
	}



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Project->create();
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The project has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The project could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$users = $this->Project->User->find('list');
		$this->set(compact('users'));
	}




/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The project has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The project could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
			$this->request->data = $this->Project->find('first', $options);
		}
		$users = $this->Project->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__d('croogo', 'Project deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Project was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_indexold method
 *
 * @return void
 */
	public function admin_indexOLD() {
		$this->set('projects', $this->paginate());
		
	}
    
    
 /**
 * admin_index method
 *
 * @return void
 */ 
    function admin_index() {
			  
          
            $this->set('projects', $this->paginate());
			 
            //check if this is a relationship table
			
            $projectdata = $this->Project->find('all');
            $users = $this->Project->User->find('list');
			$this->set(compact('projectdata', 'users'));
            
	}
  
     function admin_deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['Project'] as $project_id => $del){
			if($del == 1 ){$arr[] = $project_id;}
		}
		if($this->Project->deleteAll(array('Project.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
    
  
    
    function admin_editindexsavefld() {
		$this->autoRender = false;
		$this->Project->id = $_POST['pk'];
		
		if($this->Project->saveField($_POST['name'],$_POST['value'])) {
			$response = true;	
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
  
  
    

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
		$this->set('project', $this->Project->find('first', $options));
	}



/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Project->create();
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The project has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The project could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$users = $this->Project->User->find('list');
		$this->set(compact('users'));
	}




/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The project has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The project could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
			$this->request->data = $this->Project->find('first', $options);
		}
		$users = $this->Project->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__d('croogo', 'Project deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Project was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function admin_makeplugin($id=null){
		
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid project'));
		}
		
	
		//TODO: check for selected Objects only!!!!
		$projectdata = $this->Project->read(null, $id);
		$lcpluginname = ucfirst(str_replace(' ', '', $projectdata['Project']['name']));
		$pluginname = ucfirst(str_replace(' ', '', $projectdata['Project']['name']));
		
		//create tables (include drop tables) create menu file
		
		$projectToOutput = $this->Project->Pobject->find('all', array('contain'=>array('Fld'), 'conditions'=>array('project_id'=>$id)));
		
		//$projectToOutput = $this->Project->Pobject->find('all', array('conditions'=>array('Pobject.project_id'=>$id)));
		$string = '';
		$menuobjectstr =  '';
		//$menuobjectid = 20;
		//$lft = 13;
		//$rght = 14;
		$PobjectBehaviors = false;
		
		//$proj = $this->Project->read(null, $id);
		//$projecthost = $proj['Project']['host'];
		$adminmenustr = '';
		$schemastring = '';
		$menustr = '';
		$downstr = '';
		$sqlstring = "'";
		$shellstr = ""; 
		
		foreach($projectToOutput as $i => $obj){
			$shellstr .=
			"\$thisshell->dispatchShell('Bake model ".ucfirst($obj['Pobject']['name'])." --plugin ".$pluginname." --theme project');
			\$thisshell->dispatchShell('Bake controller ".ucfirst($obj['Pobject']['name'])." --plugin ".$pluginname." --theme project --admin');
			\$thisshell->dispatchShell('Bake view ".ucfirst($obj['Pobject']['name'])." --plugin ".$pluginname." --theme project');
			";
			
			$sqlstring .= "CREATE TABLE IF NOT EXISTS ".$obj['Pobject']['name']." (";
			$schemastring .= "public $".$obj['Pobject']['name']." = array(";
			$string .= "'".$obj['Pobject']['name']."' => array(";
			$downstr.= "'".$obj['Pobject']['name']."',";
			$schemastring .="'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),";
			$string .="'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),";
			$sqlstring .= "id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
			//admin menu string
			$adminmenustr .=
			"'".$obj['Pobject']['name']."' => array(
					'title' => '".ucfirst($obj['Pobject']['name'])."',
					'url' => '#',
					'children'=> array(
					'List' => array(
							'title' => 'List',
							'url' => array(
								'admin' => true,
								'plugin' => '".strtolower($pluginname)."',
								'controller' => '".$obj['Pobject']['name']."',
								'action' => 'index',
							),
						),
						'Add' => array(
							'title' => 'Add',
							'url' => array(
								'admin' => true,
								'plugin' => '".strtolower($pluginname)."',
								'controller' => '".$obj['Pobject']['name']."',
								'action' => 'add',
							),
						),
					)
				),";
			
			
			
			//OLD CREATE MAIN MENU
			/*
			$menuobjectstr .= "		array(
											'id' => '".$menuobjectid."',
											'parent_id' => '',
											'menu_id' => '3',
											'title' => '".Inflector::variable(Inflector::pluralize($obj['Pobject']['tablename']))."',
											'class' => '',
											'description' => '',
											'link' => 'controller:".Inflector::variable(Inflector::pluralize($obj['Pobject']['tablename']))."/action:index',
											'target' => '',
											'rel' => '',
											'status' => '1',
											'lft' => '".$lft."',
											'rght' => '".$rght."',
											'visibility_roles' => '',
											'params' => '',
											'updated' => '2009-10-06 23:14:21',
											'created' => '2009-08-19 12:23:33'
										),";
			$menuobjectid += 1;
			$lft += 2;
			$rght += 2;
			*/
			//process flds
			foreach($obj['Fld'] as $j => $fld){
				$flddetail = $this->Project->Pobject->Fld->find('first', array('conditions'=>array('Fld.id'=>$fld['id'])));
				//debugger::dump($flddetail['Ftype']['name']);
				if($fld['name'] != 'id'){
					if($fld['ftype_id'] != 4){
						$sqlstring .= $fld['name'].' '.$flddetail['Ftype']['sqltype'].' ('.$fld['length'].'),';
						$schemastring .= "'".$fld['name']."' => array('type'=>'".$flddetail['Ftype']['name']."', 'null' => false, 'default' => NULL, 'length' => ".$fld['length']."),";
						$string .= "'".$fld['name']."' => array('type'=>'".$flddetail['Ftype']['name']."', 'null' => false, 'default' => NULL, 'length' => ".$fld['length']."),";
					}else{
						$sqlstring .= $fld['name'].' '.$flddetail['Ftype']['sqltype'].', ';
						$schemastring .= "'".$fld['name']."' => array('type'=>'".$flddetail['Ftype']['name']."', 'null' => false, 'default' => NULL),";
						$string .= "'".$fld['name']."' => array('type'=>'".$flddetail['Ftype']['name']."', 'null' => false, 'default' => NULL),";
					}
				}
			}
			$sqlstring = rtrim($sqlstring, ",");
			if($PobjectBehaviors == 'tree'){
				"'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
				'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
				'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
				'alias' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
				'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
				'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),";
				
			}
			$sqlstring .= ');';
			$string .= "'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
						'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')";
			$schemastring .= "'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
						'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')";
			$schemastring .= ");";//;
		
			$string .= "),";//;
			
		}
		$sqlstring.="'";
		//create dir
		$this->folder = new Folder;
		$path = realpath(APP) . DS;
		$newpath = $path."Plugin/".$pluginname;
		
		//example dir exists as Template Plugin
		shell_exec("cp -r ".$path."Plugin/Project/webroot/Template/ ".$path."Plugin/".ucfirst($pluginname));
		
		//schema
		$str=file_get_contents($newpath.'/Config/Schema/schema.php');
		$str=str_replace("Example", $pluginname,$str);
		$str=$str.
		"public function before(\$event = array()) {
			return true;
		}
	
		public function after(\$event = array()) {
		}\n".$schemastring.'}';
		file_put_contents($newpath.'/Config/Schema/schema.php', $str);
		
		//rename activation and replace contents
		rename($newpath.'/Config/Activation.php', $newpath.'/Config/'.$pluginname.'Activation.php');
		$str=file_get_contents($newpath.'/Config/'.$pluginname.'Activation.php');
		$str=str_replace("YourPlugin", $pluginname, $str);
		$str=str_replace("Example", $pluginname, $str);
		$str=str_replace("example",$lcpluginname, $str);
		$str=str_replace("sql_create", $sqlstring, $str);
		$str=str_replace("insert_shell_here", $shellstr, $str);
		file_put_contents($newpath.'/Config/'.$pluginname.'Activation.php', $str);
		
		//create migration
		$str=file_get_contents($newpath.'/Config/Migration/Migration.php');
		$str=str_replace("Example", $pluginname,$str);
		$migratestr = 
		"public \$migration = array(
			'up' => array(
				'create_table' => array(".$string."),
			),
			'down' => array(
				'drop_table' => array(".$downstr."
				),
			),
		);}";
		file_put_contents($newpath.'/Config/Migration/Migration.php', $str.$migratestr);
		rename($newpath.'/Config/Migration/Migration.php', $newpath.'/Config/Migration/'.date('Y-m-d').'first'.$pluginname.'migration'.'.php');
		
		//JSON file
		$str=file_get_contents($newpath.'/Config/plugin.json');
		$str=str_replace("Example plugin for demonstrating hook system", $projectdata['Project']['description'], $str);
		$str=str_replace("Example", $pluginname, $str);
		$str=str_replace("Author Name", $this->Auth->user('username'), $str);
		$str=str_replace("author@example.com", $this->Auth->user('email'),$str);
		file_put_contents($newpath.'/Config/plugin.json', $str);
		
		//CONTROLLER
		$str=file_get_contents($newpath.'/Controller/AppController.php');
		$str=str_replace("Example", ucfirst($pluginname), $str);
		$str=str_replace("example", $lcpluginname, $str);
		file_put_contents($newpath.'/Controller/AppController.php', $str);
		rename($newpath.'/Controller/AppController.php', $newpath.'/Controller/'.$pluginname.'AppController.php');
		
		//MODEL
		$str=file_get_contents($newpath.'/Model/AppModel.php');
		$str=str_replace("Example", $pluginname, $str);
		$str=str_replace("example", $lcpluginname, $str);
		file_put_contents($newpath.'/Model/AppModel.php', $str);
		rename($newpath.'/Model/AppModel.php', $newpath.'/Model/'.$pluginname.'AppModel.php');
		
		//EVENTS
		$str=file_get_contents($newpath.'/Config/events.php');
		$str=str_replace("Example", $pluginname, $str);
		$str=str_replace("example", $lcpluginname, $str);
		file_put_contents($newpath.'/Config/events.php', $str);
		
		//create bootstrap file: create menu above, create string for admin menu in field parse above, and create area array for fields with CKeditor.
		//bootstrap file
		
		$str=file_get_contents($newpath.'/Config/bootstrap.php');
		$str=str_replace("Example", $pluginname, $str);
		$str=str_replace("example", $lcpluginname, $str);
		//create admin menu
		$adminmenustr = 
		"CroogoNav::add('".$pluginname."', 
			array(
			'title' => '".$pluginname."',
			'url' => '#',
			'children' => array(
				".$adminmenustr.")));";
		
		
		file_put_contents($newpath.'/Config/bootstrap.php', $str.$adminmenustr);
		
		//create models, controllers, views
	
		
		$this->redirect(array('plugin'=>'extensions', 'controller'=>'extensions_plugins'));
	}
	
}
