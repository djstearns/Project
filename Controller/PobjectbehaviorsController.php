<?php
App::uses('ProjectAppController', 'Project.Controller');
/**
 * Pobjectbehaviors Controller
 *
 * @property Pobjectbehavior $Pobjectbehavior
 * @property PaginatorComponent $Paginator
 */
class PobjectbehaviorsController extends ProjectAppController {

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
		$this->Pobjectbehavior->recursive = 0;
		$this->set('pobjectbehaviors', $this->paginate());
	}
    
    
 /**
 * index method
 *
 * @return void
 */ 
          function index() {
            //$this->Pobjectbehavior->recursive = 0;
            $this->set('pobjectbehaviors', $this->paginate());
             //check if this is a relationship table
                                     $pobjectbehaviordata = $this->Pobjectbehavior->find('all');
                        
           
           
                        
            		$pobjects = $this->Pobjectbehavior->Pobject->find('list');

                            $arr = array();
                            foreach($pobjects as $item => $i){
                                $arr[] = $i;
                            }
                            $pobjectstr = json_encode($arr);
                        		$this->set(compact('pobjectbehaviordata', 'pobjectstr'));
            
        
	}
  
  
    
     function deleteall() {
		$this->autoRender = false;
        
  		$this->autoRender = false;
		$arr = array();
		foreach($this->data['Pobjectbehavior'] as $pobjectbehavior_id => $del){
			if($del == 1 ){$arr[] = $pobjectbehavior_id;}
		}
		if($this->Pobjectbehavior->deleteAll(array('Pobjectbehavior.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->Pobjectbehavior->id = $_POST['pk'];
		
		if($this->Pobjectbehavior->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->Pobjectbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobjectbehavior'));
		}
		$options = array('conditions' => array('Pobjectbehavior.' . $this->Pobjectbehavior->primaryKey => $id));
		$this->set('pobjectbehavior', $this->Pobjectbehavior->find('first', $options));
	}



/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Pobjectbehavior->create();
			if ($this->Pobjectbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$pobjects = $this->Pobjectbehavior->Pobject->find('list');
		$this->set(compact('pobjects'));
	}




/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Pobjectbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobjectbehavior'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pobjectbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Pobjectbehavior.' . $this->Pobjectbehavior->primaryKey => $id));
			$this->request->data = $this->Pobjectbehavior->find('first', $options);
		}
		$pobjects = $this->Pobjectbehavior->Pobject->find('list');
		$this->set(compact('pobjects'));
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
		$this->Pobjectbehavior->id = $id;
		if (!$this->Pobjectbehavior->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid pobjectbehavior'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pobjectbehavior->delete()) {
			$this->Session->setFlash(__d('croogo', 'Pobjectbehavior deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Pobjectbehavior was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_indexold method
 *
 * @return void
 */
	public function admin_indexOLD() {
		$this->Pobjectbehavior->recursive = 0;
		$this->set('pobjectbehaviors', $this->paginate());
	}
    
    
 /**
 * admin_index method
 *
 * @return void
 */ 
          function admin_index() {
            //$this->Pobjectbehavior->recursive = 0;
            $this->set('pobjectbehaviors', $this->paginate());
             //check if this is a relationship table
                                     $pobjectbehaviordata = $this->Pobjectbehavior->find('all');
                        
           
           
                        
            		$pobjects = $this->Pobjectbehavior->Pobject->find('list');

                            $arr = array();
                            foreach($pobjects as $item => $i){
                                $arr[] = $i;
                            }
                            $pobjectstr = json_encode($arr);
                        		$this->set(compact('pobjectbehaviordata', 'pobjectstr'));
            
        
	}
  
  
     function savehabtmfld(){
  
		$this->autoRender = false;
		$this->Pobjectbehavior->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Pobjectbehavior->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Pobjectbehavior'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Pobjectbehavior->save($this->data)) {
			$response = true;
				
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
    
     function admin_savehabtmfld(){
  
		$this->autoRender = false;
		$this->Pobjectbehavior->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Pobjectbehavior->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Pobjectbehavior'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Pobjectbehavior->save($this->data)) {
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
		foreach($this->data['Pobjectbehavior'] as $pobjectbehavior_id => $del){
			if($del == 1 ){$arr[] = $pobjectbehavior_id;}
		}
		if($this->Pobjectbehavior->deleteAll(array('Pobjectbehavior.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    
  
  
    
    function admin_editindexsavefld() {
		$this->autoRender = false;
		$this->Pobjectbehavior->id = $_POST['pk'];
		
		if($this->Pobjectbehavior->saveField($_POST['name'],$_POST['value'])) {
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
		if (!$this->Pobjectbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobjectbehavior'));
		}
		$options = array('conditions' => array('Pobjectbehavior.' . $this->Pobjectbehavior->primaryKey => $id));
		$this->set('pobjectbehavior', $this->Pobjectbehavior->find('first', $options));
	}



/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Pobjectbehavior->create();
			if ($this->Pobjectbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$pobjects = $this->Pobjectbehavior->Pobject->find('list');
		$this->set(compact('pobjects'));
	}




/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Pobjectbehavior->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid pobjectbehavior'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pobjectbehavior->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The pobjectbehavior could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Pobjectbehavior.' . $this->Pobjectbehavior->primaryKey => $id));
			$this->request->data = $this->Pobjectbehavior->find('first', $options);
		}
		$pobjects = $this->Pobjectbehavior->Pobject->find('list');
		$this->set(compact('pobjects'));
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
		$this->Pobjectbehavior->id = $id;
		if (!$this->Pobjectbehavior->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid pobjectbehavior'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pobjectbehavior->delete()) {
			$this->Session->setFlash(__d('croogo', 'Pobjectbehavior deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Pobjectbehavior was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}}
