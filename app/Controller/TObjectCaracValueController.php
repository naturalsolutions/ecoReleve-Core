<?php
App::uses('AppController', 'Controller');
App::uses('Taxon', 'Model');
/**
 * 
 *
 * @property 
 */
class TObjectCaracValueController extends AppController {

	public $components = array('Paginator','Cookie','Session');
	public $notauth=false;	
	
	public function beforeFilter($id = null) {
		parent::beforeFilter();		
		
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index($id=null) {
		if($id==null)
			$id=1132184;
		$conditions=array();
		$conditions+=array("Carac_value_Pk"=>$id);
		$result=$this->TObjectCaracValue->findAllByCarac_valuePk($id);
		print_r($result);
	}
}	
