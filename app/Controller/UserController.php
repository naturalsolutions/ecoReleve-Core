<?php
	include_once '../../lib/Cake/Model/ConnectionManager.php';
	include_once 'AppController.php';
	App::uses('Model', 'Model');
	define("base", "user");
	define("limit",0);
	define("offset",0);
	define("cache_time",3600);
	class UserController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache');
		public $components = array('RequestHandler');
		public $cacheAction = array(
			'listv'  => cache_time			
		);
		function listv(){
			$format="json";
			if(isset($this->params['url']['format']))
				$format = $this->params['url']['format'];
			$model_view = new Model("TUsers","TUsers",base);
			$this->set('model',$model_view);	
			$views = $model_view->find('all',array(			
				'joins' => array(
					array(
						'table' => 'TAutorisations',	
						'alias' => 'TAutorisationsJoin',	
						'type' => 'INNER',
						'conditions' => array(
							'TUse_Pk_ID = TAutorisationsJoin.TAut_FK_TUse_PK_ID'
						)
					),
					 array(
						'table' => 'TApplications',
						'alias' => 'TApplicationsJoin',
						'type' => 'INNER',
						'conditions' => array(
							'TAutorisationsJoin.TAut_FK_TApp_PK_ID = TApplicationsJoin.TApp_PK_ID'
						)
					 ),
					  array(
						'table' => 'TRoles',
						'alias' => 'TRolesJoin',
						'type' => 'INNER',
						'conditions' => array(
							'TAutorisationsJoin.TAut_FK_TRol_PK_ID = TRolesJoin.TRol_PK_ID'
						)
					 )
				),
				'recursive' => 0,
				'conditions' => array(
					'TApplicationsJoin.TApp_Nom' => 'eReleve',
					'NOT' => array('TRolesJoin.TRol_Type' => "Interdit")
				),
				'fields' => array('TUse_Pk_ID','TUse_Nom','TUse_Prenom','TRolesJoin.TRol_Type'),
				'order' => array('TUse_Nom', 'TUse_Prenom DESC')
			));
			$this->set('v',$views);
			// Set response as XML
			$this->RequestHandler->respondAs("json");
			$this->viewPath .= "/$format";
			$this->layout ="json";
			$this->layoutPath =$format;
		}
	}
?>	