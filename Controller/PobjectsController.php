<?php
App::uses('ProjectAppController', 'Project.Controller');
/**
 * Pobjects Controller
 *
 * @property Pobject $Pobject
 * @property PaginatorComponent $Paginator
 */
class PobjectsController extends ProjectAppController {

public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->unlockedActions = array('editindexsavefld','admin_editindexsavefld','admin_savehabtmfld','savehabtmfld');
		
	}

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
		$this->Pobject->recursive = 0;
		$this->set('pobjects', $this->paginate());
	}
    
    
 /**
 * index method
 *
 * @return void
 */ 
          function index() {
            //$this->Pobject->recursive = 0;
            $this->set('pobjects', $this->paginate());
             //check if this is a relationship table
                                     $pobjectdata = $this->Pobject->find('all');
                        
           
           
                        
            		$projects = $this->Pobject->Project->find('list');
		$pobjectbehaviors = $this->Pobject->Pobjectbehavior->find('list');

                            $arr = array();
                            foreach($pobjectbehaviors as $item => $i){
                                $arr[] = $i;
                            }
                            $pobjectbehaviorstr = json_encode($arr);
                        		$this->set(compact('pobjectdata', 'projects', 'pobjectbehaviorstr'));
            
        
	}
  
  
     function savehabtmfld(){
  
		$this->autoRender = false;
		$this->Pobject->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Pobject->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Pobject'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Pobject->save($this->data)) {
			$response = true;
				
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
    
     function admin_savehabtmfld(){
  
		$this->autoRender = false;
		$this->Pobject->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Pobject->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Pobject'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Pobject->save($this->data)) {
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
		foreach($this->data['Pobject'] as $pobject_id => $del){
			if($del == 1 ){$arr[] = $pobject_id;}
		}
		if($this->Pobject->deleteAll(array('Pobject.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->Pobject->id = $_POST['pk'];
		
		if($this->Pobject->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->Pobject->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobject'));
		}
		$options = array('conditions' => array('Pobject.' . $this->Pobject->primaryKey => $id));
		$this->set('pobject', $this->Pobject->find('first', $options));
	}



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Pobject->create();
			if ($this->Pobject->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobject has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobject could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$projects = $this->Pobject->Project->find('list');
		$pobjectbehaviors = $this->Pobject->Pobjectbehavior->find('list');
		$this->set(compact('projects', 'pobjectbehaviors'));
	}




/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Pobject->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobject'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pobject->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobject has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobject could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Pobject.' . $this->Pobject->primaryKey => $id));
			$this->request->data = $this->Pobject->find('first', $options);
		}
		$projects = $this->Pobject->Project->find('list');
		$pobjectbehaviors = $this->Pobject->Pobjectbehavior->find('list');
		$this->set(compact('projects', 'pobjectbehaviors'));
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
		$this->Pobject->id = $id;
		if (!$this->Pobject->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid pobject'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pobject->delete()) {
			$this->Session->setFlash(__d('croogo', 'Pobject deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Pobject was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_indexold method
 *
 * @return void
 */
	public function admin_indexOLD() {
		$this->Pobject->recursive = 0;
		$this->set('pobjects', $this->paginate());
	}
    
    
 /**
 * admin_index method
 *
 * @return void
 */ 
          function admin_index() {
            //$this->Pobject->recursive = 0;
            $this->set('pobjects', $this->paginate());
             //check if this is a relationship table
                                     $pobjectdata = $this->Pobject->find('all');
                        
           
           
                        
            		$projects = $this->Pobject->Project->find('list');
		$pobjectbehaviors = $this->Pobject->Pobjectbehavior->find('list');

                            $arr = array();
                            foreach($pobjectbehaviors as $item => $i){
                                $arr[] = $i;
                            }
                            $pobjectbehaviorstr = json_encode($arr);
                        		$this->set(compact('pobjectdata', 'projects', 'pobjectbehaviorstr'));
            
        
	}
  
  
    
    
     function admin_deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['Pobject'] as $pobject_id => $del){
			if($del == 1 ){$arr[] = $pobject_id;}
		}
		if($this->Pobject->deleteAll(array('Pobject.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function admin_editindexsavefld() {
		$this->autoRender = false;
		$this->Pobject->id = $_POST['pk'];
		
		if($this->Pobject->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->Pobject->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobject'));
		}
		$options = array('conditions' => array('Pobject.' . $this->Pobject->primaryKey => $id));
		$this->set('pobject', $this->Pobject->find('first', $options));
	}



/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Pobject->create();
			if ($this->Pobject->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobject has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobject could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$projects = $this->Pobject->Project->find('list');
		$pobjectbehaviors = $this->Pobject->Pobjectbehavior->find('list');
		$this->set(compact('projects', 'pobjectbehaviors'));
	}




/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Pobject->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobject'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pobject->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobject has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobject could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Pobject.' . $this->Pobject->primaryKey => $id));
			$this->request->data = $this->Pobject->find('first', $options);
		}
		$projects = $this->Pobject->Project->find('list');
		$pobjectbehaviors = $this->Pobject->Pobjectbehavior->find('list');
		$this->set(compact('projects', 'pobjectbehaviors'));
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
		$this->Pobject->id = $id;
		if (!$this->Pobject->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid pobject'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pobject->delete()) {
			$this->Session->setFlash(__d('croogo', 'Pobject deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Pobject was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}}
