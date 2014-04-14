<?php
App::uses('AppController', 'Controller');
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
	
	public function edit(){
		$format="json";
		$this->loadModel('TObjType');
		$this->loadModel('TObjectCaracValue');
		$v=null;
		$vp=null;
		date_default_timezone_set('Europe/Paris');
		print_r($this->request->data);
		$object_type=$this->request->data['object_type'];
		$object_id=$this->request->data['object_id'];
		$value=$this->request->data['value'];
		$carac_type=$this->request->data['carac_type'];
		$id_carac=$this->request->data['id_carac'];
		$begin_date=$this->request->data['begin_date'];
		$end_date=$this->request->data['end_date'];
		$comment=$this->request->data['comments'];

		
		
		if($carac_type=="t"){
			$i=strrpos($value,";");
			$vp=trim(substr($value, 0,$i)); 
			$v=trim(substr($value, $i+1,-1)); 
			print_r($v." ".$vp);
		}
		else
			$v=$value;		
		
		if($begin_date=="" || $begin_date=="null" || $begin_date==null){
			$begin_date=date("Ymd H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("d"), date("Y")));	
		}
		
		//date format
		$begin_date = new DateTime($begin_date);
		$begin_date = date_format($begin_date,'Ymd H:i:s');
		if($end_date!="" && $begin_date!="null" && $begin_date!=null){
			$end_date = new DateTime($end_date);
			$end_date = date_format($end_date,'Ymd H:i:s');
		}
		if($carac_type=="d"){
			$v=new DateTime($v);
			$v=date_format($v,'Ymd H:i:s');
		}
		$savearray=array("Fk_carac"=>$id_carac,"fk_object"=>$object_id,"value"=>$v,"value_precision"=>$vp,"begin_date"=>$begin_date,"end_date"=>$end_date,
		"comments"=>$comment,"object_type"=>$object_type);
		
		$this->TObjectCaracValue->save($savearray);
		
		$this->set("result",array());
		$this->RequestHandler->respondAs($format);		
		$this->viewPath .= '/'.$format;
		$this->layoutPath = $format;	
		$this->layout = $format;
	}
}	
