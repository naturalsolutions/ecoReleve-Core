<?php
	App::uses('AppController','Controller');
	class SensorController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result		
			//'proto_list' => cache_time
		);
		
		public function beforeFilter() {
			
		}
		
		function index(){
			
		}	
		
		//Return stat from argos 
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
			
			$m=date("m");
			$d=date("d");
			$y=date("Y");
			$today = date("Y-m-d",mktime(0,0,0,$m,$d,$y));	
			
			$result = $this->Argos->find("all",array(
					'fields'=>array("CONVERT(char(10),date,120) as date","nbArgos","nbGPS","nbPTT"),
					'limit'=>7
				)+$conditions
			);	
			
			
			$resultfinal=array('label'=>array(),'nbArgos'=>array(),'nbGPS'=>array(),'nbPTT'=>array());	
			for($i=0;$i<7;$i++){
				$exist=false;
				$today = date("Y-m-d",mktime(0,0,0,$m,$d-$i,$y));
				array_push($resultfinal['label'],$today);
				for($j=0;$j<count($result);$j++){
					if(is_array($result) && count($result)>0 && $result[$j][0]['date']==$today){
						array_push($resultfinal['nbArgos'],$result[$j]['Argos']['nbArgos']);
						array_push($resultfinal['nbGPS'],$result[$j]['Argos']['nbGPS']);
						array_push($resultfinal['nbPTT'],$result[$j]['Argos']['nbPTT']);
						$exist=true;
						break;
					}
				}
				if(!$exist){
					array_push($resultfinal['nbArgos'],0);
					array_push($resultfinal['nbGPS'],0);
					array_push($resultfinal['nbPTT'],0);
				}
			}
		
			
			
			
			
			//$this->set('date_name',$date_name);
			$this->set('model',$this->Argos);
			$this->set('result', $resultfinal);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;	
		}
		
		//Return stat from sensor 
		function log_stat(){
			//$this->MapSelectionManager->setSource("TThemeEtude");
			//$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
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
			
			$m=date("m");
			$d=date("d");
			$y=date("Y");
			
			$resultfinal=array('label'=>array(),'nbArgos'=>array(),'nbGPS'=>array());	
			
			
			// Pas la meilleure solution en terme de performance -> 14 requêtes en tout.
			// Données Argos
			$this->loadModel('SensorArgos');
			for($i=1;$i<8;$i++){
			
				$today = date("Y-m-d",mktime(0,0,0,$m,$d-$i,$y));
				
				array_push($resultfinal['label'], $today);
			
				$argos_result = $this->SensorArgos->find("all", array(
					'fields'=>array('convert(char(10), date, 120) as locDate', 'count(*) as nb'),
					'conditions'=>array('convert(char(10), date, 120) = '=>$today),
					'group'=>array('convert(char(10), date, 120)')
				));
				
				if ( is_array($argos_result) && count($argos_result) == 1)
					array_push($resultfinal['nbArgos'], $argos_result[0][0]['nb']);
				else
					array_push($resultfinal['nbArgos'], 0);
			}
			
			// Données GPS
			$this->loadModel('SensorGps');
			for($i=1;$i<8;$i++){
				$today = date("Y-m-d",mktime(0,0,0,$m,$d-$i,$y));
			
				$gps_result = $this->SensorGps->find("all", array(
					'fields'=>array('convert(char(10), date, 120) as locDate', 'count(*) as nb'),
					'conditions'=>array('convert(char(10), date, 120) = '=>$today),
					'group'=>array('convert(char(10), date, 120)')
				));
				
				if ( is_array($gps_result) && count($gps_result) == 1)
					array_push($resultfinal['nbGPS'], $gps_result[0][0]['nb']);
				else
					array_push($resultfinal['nbGPS'], 0);
			}
			
			$this->set("result",$resultfinal);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;
		}	
		
		function RFID_import(){
			$this->loadModel('RFID');
			$message="";
			$id_rfid="";
			$filetype="";
			if(isset($this->params['form']['datafile']['tmp_name'])	&& $this->params['form']['datafile']['tmp_name']!=""){	
				$filename=$this->params['form']['datafile']['tmp_name'];
				
				//get rfid id
				if(isset($this->params['data']['id_rfid']) && $this->params['data']['id_rfid']!=""){
					$id_rfid=$this->params['data']['id_rfid'];
				}
				
				//get rfid filetype
				if(isset($this->params['data']['filetype']) && $this->params['data']['filetype']!=""){
					$filetype=$this->params['data']['filetype'];
				}
				
				//begin import
				$result=$this->RFID->import_txt($filename,$id_rfid);
				
				$message=$result;
			}	
			else{
				$message=array("message"=>"No file");
				
			}
			$this->set('message',$message);
			$this->RequestHandler->respondAs("json");
			// $this->RequestHandler->respondAs("html");
			$this->viewPath .= "/"."json";
			$this->layout = "json";
			$this->layoutPath = "json";
		}
	}

?>