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
class TUsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
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
		
		
		//print_r($this->params['action']);
		/*if ($this->params['action']=='login') {
			$this->Security->blackHoleCallback = 'forceSSL';
			$this->Security->requireSecure();
		}*/
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TUser->recursive = 0;
		//print_r($this->Session->read('role'));
		$this->set('tUsers', $this->Paginator->paginate());
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
		$options = array('recursive'=>-1,
						'fields' => array('*','Autorisation.TAut_PK_ID','Applications.TApp_Nom','Roles.TRol_Type'),
						'conditions' => array('TUser.' . $this->TUser->primaryKey => $id),
						'joins' => array(
							array('table' => 'TAutorisations',
								'alias' => 'Autorisation',
								'type' => 'inner',
								'conditions' => array(
									'TUse_Pk_ID = Autorisation.TAut_FK_TUse_PK_ID'
								)
							),
							array('table' => 'TApplications',
								'alias' => 'Applications',
								'type' => 'inner',
								'conditions' => array(
									'TApp_PK_ID = Autorisation.TAut_FK_TApp_PK_ID'
								)
							),
							array('table' => 'TRoles',
								'alias' => 'Roles',
								'type' => 'inner',
								'conditions' => array(
									'TRol_PK_ID = Autorisation.TAut_FK_TRol_PK_ID'
								)
							)
						)	
		);
		$this->set('tUser', $this->TUser->find('all', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		//Role
		$this->Role=new TRole();
		$roles=$this->Role->find('all',array(
			'fields'=>array('TRol_PK_ID','TRol_Type'),
			'group'=>array('TRol_PK_ID','TRol_Type')
		));
		$formroles=array();
		foreach($roles as $r){
			//print_r($r);
			$formroles=array_merge($formroles,array($r['TRole']['TRol_Type']=>$r['TRole']['TRol_Type']));
			//$formrole+=array($r['TRole']['TRol_PK_ID']=>$r['TRole']['TRol_Type']);			
		}
		$this->set('roles',$formroles);
		
		//Application
		$this->Application=new TApplication();
		$app=$this->Application->find('all',array(
			'fields'=>array('TApp_Nom'),
			'group'=>array('TApp_Nom')
		));
		$formapp=array();
		foreach($app as $a){
			
			$formapp=array_merge($formapp,array($a['TApplication']['TApp_Nom']=>$a['TApplication']['TApp_Nom']));
			//$formrole+=array($r['TRole']['TRol_PK_ID']=>$r['TRole']['TRol_Type']);			
		}
		$this->set('apps',$formapp);
		
		if ($this->request->is('post')) {
			$this->TUser->create();
			
			//get id_role from the selected role
			$role=$this->request->data['TUser']['Role'];
			$r=$this->Role->find('first',array(
				'fields'=>array('TRol_PK_ID','TRol_Type'),
				'group'=>array('TRol_PK_ID','TRol_Type'),
				'conditions'=>array('TRol_Type'=>$role)
			));
			$idrole=$r['TRole']['TRol_PK_ID'];
			
			//get id app from the selected app
			$app=$this->request->data['TUser']['Application'];
			$a=$this->Application->find('first',array(
				'fields'=>array('TApp_PK_ID','TApp_Nom'),
				'group'=>array('TApp_PK_ID','TApp_Nom'),
				'conditions'=>array('TApp_Nom'=>$app)
			));
			$idapp=	$a['TApplication']['TApp_PK_ID'];	
			$tautori=array('Autorisations'=>array());
			$tautori['Autorisations'][]=array('TAut_FK_TRol_PK_ID'=>$idrole,'TAut_FK_TApp_PK_ID'=>$idapp);
			$this->request->data=array_merge($this->request->data,$tautori);
			//print_r($this->request->data);
			
			//Save model			
			if ($this->TUser->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('The t user has been saved.'));
				return $this->redirect(array('action' => 'index'));
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
		
		$options = array('recursive'=>-1,
			'fields' => array('*','Autorisation.TAut_PK_ID','Applications.TApp_Nom','Roles.TRol_Type'),
			'conditions' => array('TUser.' . $this->TUser->primaryKey => $id),
			'joins' => array(
				array('table' => 'TAutorisations',
					'alias' => 'Autorisation',
					'type' => 'inner',
					'conditions' => array(
						'TUse_Pk_ID = Autorisation.TAut_FK_TUse_PK_ID'
					)
				),
				array('table' => 'TApplications',
					'alias' => 'Applications',
					'type' => 'inner',
					'conditions' => array(
						'TApp_PK_ID = Autorisation.TAut_FK_TApp_PK_ID'
					)
				),
				array('table' => 'TRoles',
					'alias' => 'Roles',
					'type' => 'inner',
					'conditions' => array(
						'TRol_PK_ID = Autorisation.TAut_FK_TRol_PK_ID'
					)
				)
			)	
		);
		
		//Role
		$this->Role=new TRole();
		$roles=$this->Role->find('all',array(
			'fields'=>array('TRol_PK_ID','TRol_Type'),
			'group'=>array('TRol_PK_ID','TRol_Type')
		));
		$formroles=array();
		foreach($roles as $r){
			//print_r($r);
			$formroles=array_merge($formroles,array($r['TRole']['TRol_Type']=>$r['TRole']['TRol_Type']));
			//$formrole+=array($r['TRole']['TRol_PK_ID']=>$r['TRole']['TRol_Type']);			
		}
		$this->set('roles',$formroles);
		//print_r($this->TUser);
		//Application
		$this->Application=new TApplication();
		$app=$this->Application->find('all',array(
			'fields'=>array('TApp_Nom'),
			'group'=>array('TApp_Nom')
		));
		$formapp=array();
		foreach($app as $a){			
			$formapp=array_merge($formapp,array($a['TApplication']['TApp_Nom']=>$a['TApplication']['TApp_Nom']));
			//$formrole+=array($r['TRole']['TRol_PK_ID']=>$r['TRole']['TRol_Type']);			
		}
		$this->set('apps',$formapp);
		
		if ($this->request->is('put')) {
			//print_r($this->request->data);
			//get id_role from the selected role
			$role=$this->request->data['TUser']['Role'];
			$r=$this->Role->find('first',array(
				'fields'=>array('TRol_PK_ID','TRol_Type'),
				'group'=>array('TRol_PK_ID','TRol_Type'),
				'conditions'=>array('TRol_Type'=>$role)
			));
			$idrole=$r['TRole']['TRol_PK_ID'];
			
			//get id app from the selected app
			$app=$this->request->data['TUser']['Application'];
			$a=$this->Application->find('first',array(
				'fields'=>array('TApp_PK_ID','TApp_Nom'),
				'group'=>array('TApp_PK_ID','TApp_Nom'),
				'conditions'=>array('TApp_Nom'=>$app)
			));
			$idapp=$a['TApplication']['TApp_PK_ID'];			
			$idautori=$this->request->data['TUser']['id_auth'];
			$tautori['Autorisations'][]=array('TAut_FK_TRol_PK_ID'=>$idrole,'TAut_FK_TApp_PK_ID'=>$idapp,'TAut_PK_ID'=>$idautori);
			$this->request->data=array_merge($this->request->data,$tautori);
			//print_r($idrole);
			//save model
			if ($this->TUser->saveAssociated($this->request->data)) { //saveAssociated
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			//$options = array('conditions' => array('TUser.' . $this->TUser->primaryKey => $id));
			$this->request->data = $this->TUser->find('first', $options);
			$this->set('date',$this->request->data['TUser']['TUse_DateCreation']);
			$this->set('app',$this->request->data['Applications']['TApp_Nom']);
			$this->set('role',$this->request->data['Roles']['TRol_Type']);
			$this->set('id_auth',$this->request->data['Autorisation']['TAut_PK_ID']);
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
			$this->Session->setFlash(__('The t user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The t user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	//
	public function not_autorized() {
		$this->render('not_autorized');		
	}
}
