<?php
App::uses('AppController', 'Controller');
App::uses('Taxon', 'Model');
/**
 * TApplications Controller
 *
 * @property TApplication $TApplication
 */
class TaxonController extends AppController {

	public $components = array('Paginator','Cookie','Session');

	public function beforeFilter($id = null) {
		parent::beforeFilter();
		$this->Cookie->name = 'session';
		$this->Cookie->key = 'q45678SI232qs*&sXOw!adre@34SAdejfjhv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
		$this->Cookie->httpOnly = true;
		if($this->Session->read('role')=='Administrateur' || $this->Cookie->read('connected')=='Administrateur'){
		}		
		else if($this->params['action']!='not_autorized'){
			$this->redirect(array('action' => 'not_autorized'));
		}
		
	}
	
	//
	public function not_autorized() {
		$this->render('not_autorized');		
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Taxon->recursive = 0;
		/*$this->Paginator->settings = array('Taxon',array(			
			//'conditions' => array('Recipe.title LIKE' => 'a%'),
			'limit' => 10
		);*/
		
		$search=null;
		if(isset($this->request->params['named']['search'])){
			$search=$this->request->params['named']['search'];
			$search=str_replace(" ","% %",$search);
			//$this->Session->setFlash(__(print_r($search,true)));
		}		
		$condi=array();
		if($search!=null)$condi=array("NAME_VALID_WITHOUT_AUTHORITY like '%$search%'");		
		$this->set('Taxon', $this->paginate($condi));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Taxon->exists($id)) {
			throw new NotFoundException(__('Invalid Taxon'));
		}
		$options = array('conditions' => array('Taxon.' . $this->Taxon->primaryKey => $id));
		$this->set('Taxon', $this->Taxon->find('all', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Taxon->create();
			print_r($this->request->data['Additional']);
			$finaladdi=array();
			$addi=$this->request->data['Additional'];
			//print_r(" val :".$this->request->data['Additional']);
			for($i=0;$i<count($this->request->data['Additional']);$i++){				
				if($this->request->data['Additional'][$i]['value']!=""){
				
					$finaladdi+=$this->request->data['Additional'][$i];
				}
			}
			print_r(" addi :".$finaladdi);
			//$this->request->data['Additional']=array();
			
			//print_r("SECOND : ".$this->request->data['Additional']);
			if ($this->Taxon->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('The Taxon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Taxon could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Taxon->exists($id)) {
			throw new NotFoundException(__('Invalid Taxon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$d=new Taxon();
			if ($d->saveAssociated(array('Taxon'=>$this->request->data['Taxon'],'Additional'=>$this->request->data['Additional']))) {
				$this->Session->setFlash(__('The Taxon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Taxon could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Taxon.' . $this->Taxon->primaryKey => $id));
			$this->request->data = $this->Taxon->find('first', $options);
		}		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Taxon->id = $id;
		if (!$this->Taxon->exists()) {
			throw new NotFoundException(__('Invalid Taxon'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Taxon->delete()) {
			$this->Session->setFlash(__('Taxon deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Taxon was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function search($val = null) {
		$val=$this->request['data']['Taxon']['search'];
		//$this->Session->setFlash(__(print_r($this->request['data']['Taxon']['search'],true)));
		$this->redirect(array('action' => 'index/','search'=>$val));
	}
}	
