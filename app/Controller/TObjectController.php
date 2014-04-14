<?php
App::uses('AppController', 'Controller');
/**
 * 
 *
 * @property 
 */
class TObjectController extends AppController {

	public $components = array('Paginator','Cookie','Session');
	public $notauth=false;	
	public $currentarraycarac=array();
	
	public function beforeFilter($id = null) {
		parent::beforeFilter();		
		
	}	
	
	
/**
 * index method
 *
 * @return void
 */
		
	public function add(){
		$format="json";
		$this->loadModel('TObject');
		$this->loadModel('TObjType');
		$this->loadModel('TObjectCaracValue');
		$v=null;
		$vp=null;
		$object_type="";
		if(isset($this->params['url']['object_type']) && $this->params['url']['object_type']!=""){
			$object_type=$this->params['url']['object_type'];
		}
		
		$object_id=null;
		$value=null;
		$carac_type=null;
		$id_carac=null;
		$begin_date=null;
		$end_date=null;
		$comment=null;

		date_default_timezone_set('Europe/Paris');
		//get id_type_object of the new TObject
		$object_type=str_replace("-","_",$object_type);
		$id_obj_type_array=$this->TObjType->find("first",array(
			"recursive"=>0,
			"fields"=>array("Obj_Type_Pk"),
			"conditions"=>array("name"=>$object_type)
		));					
		$id_obj_type=$id_obj_type_array['TObjType']['Obj_Type_Pk'];
		
		//add new TObject
		$this->TObject->save(array("Id_object_type"=>$id_obj_type,"Name_object_type"=>$object_type));

		//get id the created TObject
		$tobjarr=$this->TObject->find("first",array(
			"fields"=>array("Object_Pk"),
			"order"=>array("Object_Pk desc")	
		));
		$object_id=$tobjarr['TObject']['Object_Pk'];
		
		//add carac value of the new TObject	
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
		
		$savearray=array("Fk_carac"=>"54","fk_object"=>$object_id,"value"=>$id_obj_type,"value_precision"=>$object_type,"begin_date"=>$begin_date,
		"comments"=>$comment,"object_type"=>$object_type);
		$this->currentarraycarac=$savearray;
			
		$this->TObjectCaracValue->save($this->currentarraycarac);
		
		//use stored procedure because of a bug on iis
		// $this->TObject->query("sp_create_carac 54, '$object_id', '$id_obj_type', '$object_type', '$begin_date', null, null, '$object_type'");
		
		$this->set("result",array("object_id"=>$object_id));
		// $this->RequestHandler->respondAs("html");		
		$this->RequestHandler->respondAs($format);		
		$this->viewPath .= '/'.$format;
		$this->layoutPath = $format;	
		$this->layout = $format;
	}
	
	function delete(){
		$this->loadModel('TObjectCaracValue');
		$format="json";
		$id_object="";
		$message="";
		if(isset($this->params['url']['id_object']) && $this->params['url']['id_object']!=""){
			$id_object=$this->params['url']['id_object'];
		}
		
		if(isset($this->request->params['id_object']) && $this->request->params['id_object']!=""){
			$id_object=$this->request->params['id_object'];					
		}
		
		if($id_object!=""){
			if($this->TObjectCaracValue->deleteAll(array('fk_object' => $id_object), false))
				$message="success";
			else
				$message="error";
		}
		else
			$message="missing id_object parameter";
		
		$this->set("result",array("message"=>$message));
		$this->RequestHandler->respondAs($format);		
		$this->viewPath .= '/'.$format;
		$this->layoutPath = $format;	
		$this->layout = $format;
	}
}	
