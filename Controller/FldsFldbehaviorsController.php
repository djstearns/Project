<?php
App::uses('ProjectAppController', 'Project.Controller');
/**
 * FldsFldbehaviors Controller
 *
 * @property FldsFldbehavior $FldsFldbehavior
 * @property PaginatorComponent $Paginator
 */
class FldsFldbehaviorsController extends ProjectAppController {

public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->unlockedActions = array('editindexsavefld','admin_editindexsavefld');
		
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
		$this->FldsFldbehavior->recursive = 0;
		$this->set('fldsFldbehaviors', $this->paginate());
	}
    
    
 /**
 * index method
 *
 * @return void
 */ 
          function index() {
            //$this->FldsFldbehavior->recursive = 0;
            $this->set('fldsFldbehaviors', $this->paginate());
             //check if this is a relationship table
                                    $FldsFldbehaviordata = $this->FldsFldbehavior->find('all');
                              
           
           
                        
            		$flds = $this->FldsFldbehavior->Fld->find('list');
		$fldbehaviors = $this->FldsFldbehavior->Fldbehavior->find('list');
		$this->set(compact('FldsFldbehaviordata', 'flds', 'fldbehaviors'));
            
        
	}
  
  
  
  
  
    
    
     function deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['FldsFldbehavior'] as $fldsFldbehavior_id => $del){
			if($del == 1 ){$arr[] = $fldsFldbehavior_id;}
		}
		if($this->FldsFldbehavior->deleteAll(array('FldsFldbehavior.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->FldsFldbehavior->id = $_POST['pk'];
		
		if($this->FldsFldbehavior->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->FldsFldbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid flds fldbehavior'));
		}
		$options = array('conditions' => array('FldsFldbehavior.' . $this->FldsFldbehavior->primaryKey => $id));
		$this->set('fldsFldbehavior', $this->FldsFldbehavior->find('first', $options));
	}



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FldsFldbehavior->create();
			if ($this->FldsFldbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$flds = $this->FldsFldbehavior->Fld->find('list');
		$fldbehaviors = $this->FldsFldbehavior->Fldbehavior->find('list');
		$this->set(compact('flds', 'fldbehaviors'));
	}




/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FldsFldbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid flds fldbehavior'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->FldsFldbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('FldsFldbehavior.' . $this->FldsFldbehavior->primaryKey => $id));
			$this->request->data = $this->FldsFldbehavior->find('first', $options);
		}
		$flds = $this->FldsFldbehavior->Fld->find('list');
		$fldbehaviors = $this->FldsFldbehavior->Fldbehavior->find('list');
		$this->set(compact('flds', 'fldbehaviors'));
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
		$this->FldsFldbehavior->id = $id;
		if (!$this->FldsFldbehavior->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid flds fldbehavior'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FldsFldbehavior->delete()) {
			$this->Session->setFlash(__d('croogo', 'Flds fldbehavior deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Flds fldbehavior was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_indexold method
 *
 * @return void
 */
	public function admin_indexOLD() {
		$this->FldsFldbehavior->recursive = 0;
		$this->set('fldsFldbehaviors', $this->paginate());
	}
    
    
 /**
 * admin_index method
 *
 * @return void
 */ 
          function admin_index() {
            //$this->FldsFldbehavior->recursive = 0;
            $this->set('fldsFldbehaviors', $this->paginate());
             //check if this is a relationship table
                                    $FldsFldbehaviordata = $this->FldsFldbehavior->find('all');
                              
           
           
                        
            		$flds = $this->FldsFldbehavior->Fld->find('list');
		$fldbehaviors = $this->FldsFldbehavior->Fldbehavior->find('list');
		$this->set(compact('FldsFldbehaviordata', 'flds', 'fldbehaviors'));
            
        
	}
  
  
  
  
  
    
    
     function admin_deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['FldsFldbehavior'] as $fldsFldbehavior_id => $del){
			if($del == 1 ){$arr[] = $fldsFldbehavior_id;}
		}
		if($this->FldsFldbehavior->deleteAll(array('FldsFldbehavior.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function admin_editindexsavefld() {
		$this->autoRender = false;
		$this->FldsFldbehavior->id = $_POST['pk'];
		
		if($this->FldsFldbehavior->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->FldsFldbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid flds fldbehavior'));
		}
		$options = array('conditions' => array('FldsFldbehavior.' . $this->FldsFldbehavior->primaryKey => $id));
		$this->set('fldsFldbehavior', $this->FldsFldbehavior->find('first', $options));
	}



/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->FldsFldbehavior->create();
			if ($this->FldsFldbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$flds = $this->FldsFldbehavior->Fld->find('list');
		$fldbehaviors = $this->FldsFldbehavior->Fldbehavior->find('list');
		$this->set(compact('flds', 'fldbehaviors'));
	}




/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->FldsFldbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid flds fldbehavior'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->FldsFldbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The flds fldbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('FldsFldbehavior.' . $this->FldsFldbehavior->primaryKey => $id));
			$this->request->data = $this->FldsFldbehavior->find('first', $options);
		}
		$flds = $this->FldsFldbehavior->Fld->find('list');
		$fldbehaviors = $this->FldsFldbehavior->Fldbehavior->find('list');
		$this->set(compact('flds', 'fldbehaviors'));
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
		$this->FldsFldbehavior->id = $id;
		if (!$this->FldsFldbehavior->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid flds fldbehavior'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FldsFldbehavior->delete()) {
			$this->Session->setFlash(__d('croogo', 'Flds fldbehavior deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Flds fldbehavior was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}}
