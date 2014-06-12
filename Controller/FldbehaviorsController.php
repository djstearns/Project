<?php
class FldbehaviorsController extends AppController {

	var $name = 'Fldbehaviors';
	 public function beforeFilter() {
       parent::beforeFilter();

    }

	function indexOLD() {
		$this->Fldbehavior->recursive = 0;
		$this->set('fldbehaviors', $this->paginate());
	}
    
    function mobileindex() {
		$this->Fldbehavior->recursive = -1;
		$this->autoRender = false;
		$check = $this->Fldbehavior->find('all', array('limit'=>200));
		$save = array();
		if($check) {
			
			$response = $check;
				
		} else {
			$response = array(
				'logged' => false,
				'message' => 'Invalid user'
			);
		}
		echo json_encode($response);
	}
    
    function mobileadd() {
		$this->autoRender = false;
		$this->data['Fldbehavior']=$_POST;
		$this->Fldbehavior->create();
		if ($this->Fldbehavior->save($this->data)) {
			$check = array(
			'logged' => false,
			'message' => 'Saved!',
			'id'=>$this->Fldbehavior->getLastInsertId()
			);	
		} else {
			$this->Session->setFlash(__('The Fldbehavior could not be saved. Please, try again.', true));
		}
		if($check) {
			
			$response = $check;
				
		} else {
			$response = array(
				'logged' => false,
				'message' => 'Invalid user'
			);
		}
		echo json_encode($response);
	}
    
     function mobilesave() {
		$this->autoRender = false;
        $this->Fldbehavior->id=$_POST['id'];
		$this->data['Fldbehavior']=$_POST;
		if ($this->Fldbehavior->save($this->data)) {
			$check = array(
			'logged' => false,
			'message' => 'Saved!',
			);	
		} else {
			$this->Session->setFlash(__('The Fldbehavior could not be saved. Please, try again.', true));
		}
		if($check) {
			
			$response = $check;
				
		} else {
			$response = array(
				'logged' => false,
				'message' => 'Invalid Fldbehavior'
			);
		}
		echo json_encode($response);
	}
    
    function mobiledelete($id = null) {
		if (!$id) {
			$response = array(
						'logged' => false,
						'message' => 'Fldbehavior did not exist remotely!'
					);
			
		}
		if ($this->Fldbehavior->delete($id)) {
			$response = array(
						'logged' => false,
						'message' => 'Fldbehavior deleted!'
					);
					
		}else{
			$response = array(
						'logged' => false,
						'id'=>$id,
						'message' => 'Fldbehavior not deleted!'
					);
		}
					
		echo json_encode($response);
	}
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->Fldbehavior->id = $_POST['pk'];
		
		if($this->Fldbehavior->saveField($_POST['name'],$_POST['value'])) {
			$response = true;	
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
        function index() {
		//$this->Fldbehavior->recursive = 0;
		$this->set('fldbehaviors', $this->paginate());
         //check if this is a relationship table
        			   		 $fldbehaviordata = $this->Fldbehavior->find('all');
		        
       
       
		        
        		$flds = $this->Fldbehavior->Fld->find('list');

						$arr = array();
						foreach($flds as $item => $i){
							$arr[] = $i;
						}
						$fldstr = json_encode($arr);
							$this->set(compact('fldbehaviordata', 'fldstr'));
        
        
	}
    
     function savehabtmfld(){
  
		$this->autoRender = false;
		$this->Fldbehavior->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Fldbehavior->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Fldbehavior'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Fldbehavior->save($this->data)) {
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
		foreach($this->data['Fldbehavior'] as $fldbehavior_id => $del){
			if($del == 1 ){$arr[] = $fldbehavior_id;}
		}
		if($this->Fldbehavior->deleteAll(array('Fldbehavior.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fldbehavior', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('fldbehavior', $this->Fldbehavior->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Fldbehavior->create();
			if ($this->Fldbehavior->save($this->data)) {
				$this->Session->setFlash(__('The fldbehavior has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fldbehavior could not be saved. Please, try again.', true));
			}
		}
		$flds = $this->Fldbehavior->Fld->find('list');
		$this->set(compact('flds'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid fldbehavior', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Fldbehavior->save($this->data)) {
				$this->Session->setFlash(__('The fldbehavior has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fldbehavior could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Fldbehavior->read(null, $id);
		}
		$flds = $this->Fldbehavior->Fld->find('list');
		$this->set(compact('flds'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fldbehavior', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Fldbehavior->delete($id)) {
			$this->Session->setFlash(__('Fldbehavior deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Fldbehavior was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
