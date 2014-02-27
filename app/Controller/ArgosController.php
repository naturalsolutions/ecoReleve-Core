<?php
	App::uses('AppController','Controller');
	class ArgosController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result		
			//'proto_list' => cache_time
		);
		
		public function beforeFilter() {
			
		}
		
		function index(){
			
		}	
		
		//Return a list of theme view  
		function argos_stat(){
			$this->loadModel('Argos');
			//$this->MapSelectionManager->setSource("TThemeEtude");
			//$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
			
			//format from request
			if(stripos($this->request->header('Accept'),"application/xml")!==false)
				$format="xml"; 
			else if(stripos($this->request->header('Accept'),"application/json")!==false)
				$format="json";	
			
			//format return from param
			if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
				$tmp_format=$this->params['url']['format'];
				if($tmp_format=="json"){
					$format="json";
				}
				else if($tmp_format=="xml"){
					$format="xml";
				}
				else if($tmp_format=="test"){
					$format="test";
				}
			}
			
			$conditions=array();
			$debug="";
				
			$table = $this->Argos->find("all",array(
					'fields'=>array('TProt_PK_ID','Caption'),	
					'order'=> array("DATE desc"),
					'limit'=>7
					'group'=>array('Caption','TProt_PK_ID')
				)+$conditions
			);				
			
			//$this->set('date_name',$date_name);
			$this->set('model',$this->Argos);
			$this->set('Argos', $table);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;	
		}
		
	}

?>