<?php
App::uses('AppController', 'Controller');
/**
 * TUsers Controller
 *
 * @property TUser $TUser
 */
class TUsersController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TUser->recursive = 0;
		$this->set('tUsers', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TUser->exists($id)) {
			throw new NotFoundException(__('Invalid t user'));
		}
		$options = array('conditions' => array('TUser.' . $this->TUser->primaryKey => $id));
		$this->set('tUser', $this->TUser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TUser->create();
			
			if ($this->TUser->save($this->request->data)) {
				$this->Session->setFlash(__('The t user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t user could not be saved. Please, try again.'));
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
		if (!$this->TUser->exists($id)) {
			throw new NotFoundException(__('Invalid t user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TUser->save($this->request->data)) {
				$this->Session->setFlash(__('The t user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TUser.' . $this->TUser->primaryKey => $id));
			$this->request->data = $this->TUser->find('first', $options);
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
		$this->TUser->id = $id;
		if (!$this->TUser->exists()) {
			throw new NotFoundException(__('Invalid t user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TUser->delete()) {
			$this->Session->setFlash(__('T user deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('T user was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->TUser->recursive = 0;
		$this->set('tUsers', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->TUser->exists($id)) {
			throw new NotFoundException(__('Invalid t user'));
		}
		$options = array('conditions' => array('TUser.' . $this->TUser->primaryKey => $id));
		$this->set('tUser', $this->TUser->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TUser->create();
			if ($this->TUser->save($this->request->data)) {
				$this->Session->setFlash(__('The t user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->TUser->exists($id)) {
			throw new NotFoundException(__('Invalid t user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TUser->save($this->request->data)) {
				$this->Session->setFlash(__('The t user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The t user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TUser.' . $this->TUser->primaryKey => $id));
			$this->request->data = $this->TUser->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->TUser->id = $id;
		if (!$this->TUser->exists()) {
			throw new NotFoundException(__('Invalid t user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TUser->delete()) {
			$this->Session->setFlash(__('T user deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('T user was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
