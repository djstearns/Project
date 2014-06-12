<?php
App::uses('ProjectAppController', 'Project.Controller');
/**
 * Flds Controller
 *
 * @property Fld $Fld
 * @property PaginatorComponent $Paginator
 */
class FldsController extends ProjectAppController {

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
		$this->Fld->recursive = 0;
		$this->set('flds', $this->paginate());
	}
    
    
 /**
 * index method
 *
 * @return void
 */ 
          function index() {
            //$this->Fld->recursive = 0;
            $this->set('flds', $this->paginate());
             //check if this is a relationship table
                                     $flddata = $this->Fld->find('all');
                        
           
           
                        
            		$pobjects = $this->Fld->Pobject->find('list');
		$ftypes = $this->Fld->Ftype->find('list');
		$fldbehaviors = $this->Fld->Fldbehavior->find('list');

                            $arr = array();
                            foreach($fldbehaviors as $item => $i){
                                $arr[] = $i;
                            }
                            $fldbehaviorstr = json_encode($arr);
                        		$this->set(compact('flddata', 'pobjects', 'ftypes', 'fldbehaviorstr'));
            
        
	}
  
  
     function deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['Fld'] as $fld_id => $del){
			if($del == 1 ){$arr[] = $fld_id;}
		}
		if($this->Fld->deleteAll(array('Fld.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->Fld->id = $_POST['pk'];
		
		if($this->Fld->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->Fld->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid fld'));
		}
		$options = array('conditions' => array('Fld.' . $this->Fld->primaryKey => $id));
		$this->set('fld', $this->Fld->find('first', $options));
	}



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Fld->create();
			if ($this->Fld->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The fld has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The fld could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$pobjects = $this->Fld->Pobject->find('list');
		$ftypes = $this->Fld->Ftype->find('list');
		$fldbehaviors = $this->Fld->Fldbehavior->find('list');
		$this->set(compact('pobjects', 'ftypes', 'fldbehaviors'));
	}




/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Fld->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid fld'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fld->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The fld has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The fld could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Fld.' . $this->Fld->primaryKey => $id));
			$this->request->data = $this->Fld->find('first', $options);
		}
		$pobjects = $this->Fld->Pobject->find('list');
		$ftypes = $this->Fld->Ftype->find('list');
		$fldbehaviors = $this->Fld->Fldbehavior->find('list');
		$this->set(compact('pobjects', 'ftypes', 'fldbehaviors'));
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
		$this->Fld->id = $id;
		if (!$this->Fld->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid fld'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fld->delete()) {
			$this->Session->setFlash(__d('croogo', 'Fld deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Fld was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_indexold method
 *
 * @return void
 */
	public function admin_indexOLD() {
		$this->Fld->recursive = 0;
		$this->set('flds', $this->paginate());
	}
    
    
 /**
 * admin_index method
 *
 * @return void
 */ 
          function admin_index() {
            //$this->Fld->recursive = 0;
            $this->set('flds', $this->paginate());
             //check if this is a relationship table
                                     $flddata = $this->Fld->find('all');
                        
           
           
                        
            		$pobjects = $this->Fld->Pobject->find('list');
		$ftypes = $this->Fld->Ftype->find('list');
		$fldbehaviors = $this->Fld->Fldbehavior->find('list');

                            $arr = array();
                            foreach($fldbehaviors as $item => $i){
                                $arr[] = $i;
                            }
                            $fldbehaviorstr = json_encode($arr);
                        		$this->set(compact('flddata', 'pobjects', 'ftypes', 'fldbehaviorstr'));
            
        
	}
  
  
     function savehabtmfld(){
  
		$this->autoRender = false;
		$this->Fld->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Fld->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Fld'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Fld->save($this->data)) {
			$response = true;
				
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
    
     function admin_savehabtmfld(){
  
		$this->autoRender = false;
		$this->Fld->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Fld->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Fld'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Fld->save($this->data)) {
			$response = true;
				
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
     function admin_deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['Fld'] as $fld_id => $del){
			if($del == 1 ){$arr[] = $fld_id;}
		}
		if($this->Fld->deleteAll(array('Fld.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function admin_editindexsavefld() {
		$this->autoRender = false;
		$this->Fld->id = $_POST['pk'];
		
		if($this->Fld->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->Fld->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid fld'));
		}
		$options = array('conditions' => array('Fld.' . $this->Fld->primaryKey => $id));
		$this->set('fld', $this->Fld->find('first', $options));
	}



/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Fld->create();
			if ($this->Fld->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The fld has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The fld could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$pobjects = $this->Fld->Pobject->find('list');
		$ftypes = $this->Fld->Ftype->find('list');
		$fldbehaviors = $this->Fld->Fldbehavior->find('list');
		$this->set(compact('pobjects', 'ftypes', 'fldbehaviors'));
	}




/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Fld->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid fld'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fld->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The fld has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The fld could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Fld.' . $this->Fld->primaryKey => $id));
			$this->request->data = $this->Fld->find('first', $options);
		}
		$pobjects = $this->Fld->Pobject->find('list');
		$ftypes = $this->Fld->Ftype->find('list');
		$fldbehaviors = $this->Fld->Fldbehavior->find('list');
		$this->set(compact('pobjects', 'ftypes', 'fldbehaviors'));
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
		$this->Fld->id = $id;
		if (!$this->Fld->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid fld'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fld->delete()) {
			$this->Session->setFlash(__d('croogo', 'Fld deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Fld was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}}
