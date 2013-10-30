<?php
App::uses('AppController', 'Controller');
/**
 * TApplications Controller
 *
 * @property TApplication $TApplication
 */
class TApplicationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TApplication->recursive = 0;
		$this->set('tApplications', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TApplication->exists($id)) {
			throw new NotFoundException(__('Invalid t application'));
		}
		$options = array('conditions' => array('TApplication.' . $this->TApplication->primaryKey => $id));
		$this->set('tApplication', $this->TApplication->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TApplication->create();
			if ($this->TApplication->save($this->request->data)) {
				$this->Session->setFlash(__('The t application has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t application could not be saved. Please, try again.'));
			}
		}
		$users = $this->TApplication->User->find('list');
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
		if (!$this->TApplication->exists($id)) {
			throw new NotFoundException(__('Invalid t application'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TApplication->save($this->request->data)) {
				$this->Session->setFlash(__('The t application has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t application could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TApplication.' . $this->TApplication->primaryKey => $id));
			$this->request->data = $this->TApplication->find('first', $options);
		}
		$users = $this->TApplication->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TApplication->id = $id;
		if (!$this->TApplication->exists()) {
			throw new NotFoundException(__('Invalid t application'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TApplication->delete()) {
			$this->Session->setFlash(__('T application deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('T application was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->TApplication->recursive = 0;
		$this->set('tApplications', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->TApplication->exists($id)) {
			throw new NotFoundException(__('Invalid t application'));
		}
		$options = array('conditions' => array('TApplication.' . $this->TApplication->primaryKey => $id));
		$this->set('tApplication', $this->TApplication->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TApplication->create();
			if ($this->TApplication->save($this->request->data)) {
				$this->Session->setFlash(__('The t application has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t application could not be saved. Please, try again.'));
			}
		}
		$users = $this->TApplication->User->find('list');
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
		if (!$this->TApplication->exists($id)) {
			throw new NotFoundException(__('Invalid t application'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TApplication->save($this->request->data)) {
				$this->Session->setFlash(__('The t application has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t application could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TApplication.' . $this->TApplication->primaryKey => $id));
			$this->request->data = $this->TApplication->find('first', $options);
		}
		$users = $this->TApplication->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->TApplication->id = $id;
		if (!$this->TApplication->exists()) {
			throw new NotFoundException(__('Invalid t application'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TApplication->delete()) {
			$this->Session->setFlash(__('T application deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('T application was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
