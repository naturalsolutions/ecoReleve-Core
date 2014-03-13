<?php
	App::uses('AppController','Controller');
	class TViewTrxRadioController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);
		
		function detail(){
			$id="";
			$recursive=0;
			$format="json";
			$this->loadModel('TViewTrxRadio');
			$this->loadModel('TViewIndividual');
			$labelcarac="";
			$carac="";
			if(isset($this->request->params['id']) && $this->request->params['id']!=""){
				$id=$this->request->params['id'];					
			}
			if(isset($this->request->params['carac']) && $this->request->params['carac']!=""){
				$carac=$this->request->params['carac'];	
				$recursive=1;
				$this->loadModel('TObjCaractype');
				$labelcarac=$this->TObjCaractype->find("list",array(
					'fields'=>array('name','label')			
				));
				
				$func=function ($val){
					return str_replace(" ","_",$val).".*";
				};								
				$labelcaracwspace=array_map($func,$labelcarac);	
				//print_r($labelcarac);
			}
			
			if($id!=""){				
				$fields=array('Trx_Radio_Obj_PK as ID',		
				'id5@TCarac_Transmitter_Frequency as Frequency',
				'id41@TCaracThes_Model_Precision as Model',
				'id42@TCaracThes_Company_Precision as Manufacturer',
				'id6@TCarac_Transmitter_Serial_Number as [Serial Number]',
				'id43@TCarac_Weight as Weight',
				'id44@TCarac_InitialLivespan as [Initial LifeSpan]',
				'id40@TCaracThes_Shape_Precision as Shape',
				'id46@TCaracThes_BatteryType_Precision as [Battery Type]',
				'id1@Thes_Status_Precision as Status',
				'id24@TCaracThes_Txt_Harness_Precision as Harness',
				'id57@TCarac_UpdatedLifeSpan as UpdatedLS',
				'id58@TCarac_Date_UpdatedLifeSpan as UpdatedLS',
				'id37@Comments as Comments'
				);
				
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if($this->params['url']['format']=="geojson"){
						$format="geojson";
					}
				}
				/*'contain' => array('Comment', 'User' => array('Comment', 'Profile'))*/
				
				if($labelcarac!="")
					$fields=array("Trx_Radio_Obj_PK","id43@TCarac_Weight","id42@TCaracThes_Company",
					"id40@TCaracThes_Shape");
				$iniresult=$this->TViewTrxRadio->find("first",array(
					'recursive'=>$recursive,
					'fields'=> $fields,
					'conditions'=> array('Trx_Radio_Obj_PK'=>$id)
				));							
				$result=$iniresult;
				//history case
				if($labelcarac!=""){	
					//unset($iniresult[0]['TViewTrxRadio']);
					$countindval=count($iniresult['TViewTrxRadio']);
					$i=0;
					foreach($iniresult['TViewTrxRadio'] as $key=>$val){
						if($key=='Trx_Radio_Obj_PK'){
							$iniresult['TViewTrxRadio']['Id']=$iniresult['TViewTrxRadio']['Trx_Radio_Obj_PK'];								
						}
						else{
							foreach($labelcarac as $name=>$label){
								if(strpos($key,$name)!==false){
									$iniresult['TViewTrxRadio'][$label]=$iniresult['TViewTrxRadio'][$key];	
								}
							}
						}
						unset($iniresult['TViewTrxRadio'][$key]);
						$i++;
						if($i>$countindval)
							break;
					}
					foreach($iniresult as $type=>$values){
						if(count($values)==0)
							unset($iniresult[$type]);
					}
					$result=$iniresult;
				}
				//check if equipped or not
				else if(count($result)>0){
					// print_r($result);
					$equiped=$this->TViewIndividual->find("first",
					array("fields" => array("id6@TCarac_Transmitter_Serial_Number","id9@TCarac_Release_Ring_Code"),
						  "recursive"=>0,
						  "conditions"=>array("id6@TCarac_Transmitter_Serial_Number"=>$result[0]['Serial Number'])					
					)
					);
					if(count($equiped)>0){
						$equi="Equipped on Individual";
						if($equiped['TViewIndividual']['id9@TCarac_Release_Ring_Code']!="")
							$equi.= " ".$equiped['TViewIndividual']['id9@TCarac_Release_Ring_Code'];
					}
					else{
						$equi="Not equipped";
					}
					$result[0]=array_merge(array("Equipped"=>$equi),$result[0]);
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
			if($carac!="")
				$this->render("radioCarac");
		}	
	
	}

?>