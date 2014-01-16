<?php
App::uses('AppController', 'Controller');
App::uses('Docs', 'Model');
/**
 * TApplications Controller
 *
 * @property TApplication $TApplication
 */
class DocsController extends AppController {
	var $helpers = array('Xml', 'Text','form','html','Cache','Json');
	public $components = array('RequestHandler','Cookie','Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if(!$this->Cookie->read('connected')) print_r('no');
		else print_r($this->Cookie->read('connected'));
		$this->Doc->recursive = 0;
		$this->set('Docs', $this->paginate());
	}

	public function beforeFilter($id = null) {
		parent::beforeFilter();
		$this->Cookie->name = 'session';
		$this->Cookie->key = 'q45678SI232qs*&sXOw!adre@34SAdejfjhv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
		$this->Cookie->httpOnly = true;
		
		if($this->Session->read('role')=='Administrateur' || $this->params['action']=='docs_list' || $this->Cookie->read('connected')=='Administrateur'){
		}
		else if($this->params['action']!='not_autorized'){
			$this->redirect(array('action' => 'not_autorized'));
		}
		
	}
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		
		if (!$this->Doc->exists($id)) {
			throw new NotFoundException(__('Invalid Docs'));
		}
		$options = array('conditions' => array('Doc.' . $this->Doc->primaryKey => $id));
		$this->set('Doc', $this->Doc->find('all', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Doc->create();
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The Docs has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Docs could not be saved. Please, try again.'));
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
		if (!$this->Doc->exists($id)) {
			throw new NotFoundException(__('Invalid Docs'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$d=new Docs();
			if ($d->save(array('Docs'=>$this->request->data['Doc']))) {
				$this->Session->setFlash(__('The Docs has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Docs could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Doc.' . $this->Doc->primaryKey => $id));
			$this->request->data = $this->Doc->find('first', $options);
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
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid Docs'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Doc->delete()) {
			$this->Session->setFlash(__('Docs deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Docs was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	//
	public function not_autorized() {
		$this->render('not_autorized');		
	}
	
	public function docs_list(){
		$this->loadModel('Doc');
		$format='json';
		
		$this->set('result',$this->Doc->find("all"));
		
		$this->RequestHandler->respondAs($format);		
		$this->viewPath .= '/'.$format;
		$this->layoutPath = $format;	
		$this->layout= $format;
	}
}	
