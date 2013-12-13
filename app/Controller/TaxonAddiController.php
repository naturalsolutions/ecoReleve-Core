<?php
App::uses('AppController', 'Controller');
App::uses('TRole', 'Model');
App::uses('TApplication', 'Model');
/**
 * TUsers Controller
 *
 * @property TUser $TUser
 * @property PaginatorComponent $Paginator
 */
class TaxonAddiController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Cookie','Session');
	
	
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TaxonAddi->id = $id;
		if (!$this->TaxonAddi->exists()) {
			throw new NotFoundException(__('Invalid t user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TaxonAddi->delete()) {
			$this->Session->setFlash(__('The TaxonAddi has been deleted.'));
		} else {
			$this->Session->setFlash(__('The TaxonAddi could not be deleted. Please, try again.'));
		}
		return $this->redirect($this->referer());
	}
	
	//
	public function not_autorized() {
		$this->render('not_autorized');		
	}
}
