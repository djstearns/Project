<?php
class FtypesController extends AppController {

	var $name = 'Ftypes';
	 public function beforeFilter() {
       parent::beforeFilter();

    }

	function indexOLD() {
		$this->Ftype->recursive = 0;
		$this->set('ftypes', $this->paginate());
	}
    
    function mobileindex() {
		$this->Ftype->recursive = -1;
		$this->autoRender = false;
		$check = $this->Ftype->find('all', array('limit'=>200));
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
		$this->data['Ftype']=$_POST;
		$this->Ftype->create();
		if ($this->Ftype->save($this->data)) {
			$check = array(
			'logged' => false,
			'message' => 'Saved!',
			'id'=>$this->Ftype->getLastInsertId()
			);	
		} else {
			$this->Session->setFlash(__('The Ftype could not be saved. Please, try again.', true));
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
        $this->Ftype->id=$_POST['id'];
		$this->data['Ftype']=$_POST;
		if ($this->Ftype->save($this->data)) {
			$check = array(
			'logged' => false,
			'message' => 'Saved!',
			);	
		} else {
			$this->Session->setFlash(__('The Ftype could not be saved. Please, try again.', true));
		}
		if($check) {
			
			$response = $check;
				
		} else {
			$response = array(
				'logged' => false,
				'message' => 'Invalid Ftype'
			);
		}
		echo json_encode($response);
	}
    
    function mobiledelete($id = null) {
		if (!$id) {
			$response = array(
						'logged' => false,
						'message' => 'Ftype did not exist remotely!'
					);
			
		}
		if ($this->Ftype->delete($id)) {
			$response = array(
						'logged' => false,
						'message' => 'Ftype deleted!'
					);
					
		}else{
			$response = array(
						'logged' => false,
						'id'=>$id,
						'message' => 'Ftype not deleted!'
					);
		}
					
		echo json_encode($response);
	}
    
    function editindexsavefld() {
		$this->autoRender = false;
		$this->Ftype->id = $_POST['pk'];
		
		if($this->Ftype->saveField($_POST['name'],$_POST['value'])) {
			$response = true;	
		} else {
			$response = false;
		}
		echo json_encode($response);
	}
    
        function index() {
		//$this->Ftype->recursive = 0;
		$this->set('ftypes', $this->paginate());
         //check if this is a relationship table
        			   		 $ftypedata = $this->Ftype->find('all');
		        
       
       
		        
        		$this->set(compact('ftypedata'));
        
        
	}
    
     function savehabtmfld(){
  
		$this->autoRender = false;
		$this->Ftype->id = $_POST['pk'];
        $tr = substr($_POST['name'],0,strpos($_POST['name'],'__'));
		$ids = $this->Ftype->$tr->find('list', array('fields'=>array('id'), 'conditions'=>array(str_replace('__','.',$_POST['name'])=>$_POST['value'])));
		$this->data = array('Ftype'=>array('id'=>$_POST['pk']),substr($_POST['name'],0,strpos($_POST['name'],'__'))=>array(substr($_POST['name'],0,strpos($_POST['name'],'__'))=>$ids));
		
		if($this->Ftype->save($this->data)) {
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
		foreach($this->data['Ftype'] as $ftype_id => $del){
			if($del == 1 ){$arr[] = $ftype_id;}
		}
		if($this->Ftype->deleteAll(array('Ftype.id'=>$arr))) {
			$this->Session->setFlash(__('Deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		
		}else{
			$this->Session->setFlash(__('Could not be deleted.', true));
			$this->redirect(array('action' => 'editindex'));
		}

	}
    

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ftype', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ftype', $this->Ftype->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Ftype->create();
			if ($this->Ftype->save($this->data)) {
				$this->Session->setFlash(__('The ftype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ftype could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ftype', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ftype->save($this->data)) {
				$this->Session->setFlash(__('The ftype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ftype could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ftype->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ftype', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ftype->delete($id)) {
			$this->Session->setFlash(__('Ftype deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ftype was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
