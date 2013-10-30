<?php
	include_once 'AppController.php';
	App::uses('AppModel', 'Model');
	App::uses('User', 'Model');
	define("base", "user");
	define("limit",0);
	define("offset",0);
	define("cache_time",3600);
	class UserController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache');
		public $components = array('RequestHandler');
		public $cacheAction = array(
			//'listv'  => cache_time			
		);
		function listv(){
			$this->loadModel('User');
			$format="json";
			if(isset($this->params['url']['format']))
				$format = $this->params['url']['format'];
			$model_view = new AppModel("TUsers","TUsers",base);
			$model_view->name='User';
			$this->set('model',$model_view);	
			$views = $this->User->find('all',array(			
				'fields' => array('TUse_Pk_ID','TUse_Nom','TUse_Prenom','Roles.TRol_Type'),
				'joins' => array(
					array(
						'table' => 'TAutorisations',	
						'alias' => 'Autorisations',	
						'type' => 'INNER',
						'conditions' => array(
							'TUse_Pk_ID = Autorisations.TAut_FK_TUse_PK_ID'
						)
					),
					 array(
						'table' => 'TApplications',
						'alias' => 'Applications',
						'type' => 'INNER',
						'conditions' => array(
							'Autorisations.TAut_FK_TApp_PK_ID = Applications.TApp_PK_ID'
						)
					 ),
					  array(
						'table' => 'TRoles',
						'alias' => 'Roles',
						'type' => 'INNER',
						'conditions' => array(
							'Autorisations.TAut_FK_TRol_PK_ID = Roles.TRol_PK_ID'
						)
					 )
				),
				'recursive' => 0,
				'conditions' => array(
					'Applications.TApp_Nom' => 'eReleve',
					'NOT' => array('Roles.TRol_Type' => "Interdit")
				),
				'fields' => array('TUse_Pk_ID','TUse_Nom','TUse_Prenom','Roles.TRol_Type'),
				'order' => array('TUse_Nom', 'TUse_Prenom DESC')
			));
			$this->set('v',$views);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/$format";
			$this->layout =$format;
			$this->layoutPath =$format;
		}
	}
?>	