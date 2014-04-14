<?php
	App::uses('AppController','Controller');
	class ThesaurusController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);
		
		function index(){
			
		}	

		function getthesaurus(){
			$format='json';
			$recursive=0;
			$this->loadModel('Tthesaurus');
			$this->loadModel('TObjCaracList');
			$this->loadModel('TObjType');
			$id="";
			$conditions=array("Id_Parent <>"=>1);
			$limit=0;
			$skip=0;
			$object_type="";
			// $this->TViewIndividual->setSource('TProtocol_Summary');
			// $this->TViewIndividual->primaryKey="Id";
			
			if(isset($this->request->params['id']) && $this->request->params['id']!=""){
				$id=$this->request->params['id'];					
			}	
			
			if(isset($this->params['url']['id_type']) && $this->params['url']['id_type']!=""){
				$id_type=$this->params['url']['id_type'];
			}
			
			if(isset($this->request->params['hierarchy']) && $this->request->params['hierarchy']!=""){
				$hierarchy=$this->request->params['hierarchy'];		
				$conditions+=array('hierarchy like'=>$hierarchy);		
			}	
			
			$count=false;
			if(isset($this->request->params['count']) && $this->request->params['count']!=""){
				$count=true;					
			}			
			
			if(isset($this->params['url']['searcheng']) && $this->params['url']['searcheng']!=""){
				$search=str_replace(" ","% ",$this->params['url']['searcheng'])."%";
				$conditions+=array('topic_en like'=>$search);
			}
			
			if(isset($this->params['url']['searchfr']) && $this->params['url']['searchfr']!=""){
				$search=str_replace(" ","% ",$this->params['url']['searchfr'])."%";
				$conditions+=array('topic_fr like'=>$search);
			}
			
			if(isset($this->params['url']['limit']) && $this->params['url']['limit']!=""){
				$limit=intval($this->params['url']['limit']);
			}
			
			
			if(isset($this->params['url']['skip']) && $this->params['url']['skip']!=""){
				$skip=intval($this->params['url']['skip']);
			}
			
			if(isset($this->params['url']['object_type']) && $this->params['url']['object_type']!=""){
				$object_type=$this->params['url']['object_type'];
			}
			
			if($id!="" || isset($id_type)){
				//get id_type and hierarchie from param
				if($id!="")
					$conditions+=array('Id_Type'=>$id);
				//get id_type and hierarchie from TObjCaracList	
				if(isset($id_type)){
					$object_type=str_replace("-","_",$object_type);	
					$id_obj_array=$this->TObjType->find("first",array(
						"fields"=>array("Obj_Type_Pk"),
						"conditions"=>array("name"=>$object_type)
					));					
					$id_obj=$id_obj_array['TObjType']['Obj_Type_Pk'];
					
					$cond_id_obj=array("fk_Carac_type"=>$id_type,"fk_Object_type"=>$id_obj);
										
					$caraclist=$this->TObjCaracList->find("first",array(
						"fields"=>array("value_precision"),
						"conditions"=>$cond_id_obj
					));
					$conditions+=array($caraclist['TObjCaracList']['value_precision']);
				}				
				if(!$count){					
					$result=$this->Tthesaurus->find("all",array(
						'recursive'=>$recursive,
						'fields'=> array("ID","topic_fr","definition_fr","topic_en","definition_en"),
						'conditions'=> $conditions,
						'limit'=>$limit,
						'offset'=>$skip,
						'order'=>array("topic_en asc")
					));
				}
				else{
					$result=$this->Tthesaurus->find("count",array(
						'recursive'=>$recursive,
						'fields'=> array("topic_fr","definition_fr","topic_en","definition_en"),
						'conditions'=> $conditions
					));
					$result=array("nb"=>$result);
				}	
				$this->set("result",$result);
			}
			else{
			
			}
			
			$this->RequestHandler->respondAs('json');
			// $this->RequestHandler->respondAs('html');
			$this->viewPath .= "/$format";
			$this->layout = 'json';
			$this->layoutPath = 'json';	
		}
		
		
	}

?>