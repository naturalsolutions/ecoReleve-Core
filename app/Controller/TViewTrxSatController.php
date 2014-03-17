<?php
	App::uses('AppController','Controller');
	class TViewTrxSatController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);

		function detail(){
			$id="";
			$recursive=0;
			$format="json";
			$this->loadModel('TViewTrxSat');
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
				$fields=array('Trx_Sat_Obj_pk as ID',		
				'id19@TCarac_PTT as PTT',
				'id49@TCarac_PTTAssignmentDate as [PTT assignment date]',
				'id41@TCaracThes_Model_Precision as Model',
				'id42@TCaracThes_Company_Precision as  Manufacturer',
				'id1@Thes_Status_Precision as Status',
				'id24@TCaracThes_Txt_Harness_Precision as Harness',
				'id44@TCarac_InitialLivespan as [Initial LifeSpan]',
				'id25@TCaracThes_Txt_Argos_DutyCycle_Precision as [Duty cycle]',
				'id6@TCarac_Transmitter_Serial_Number as [Serial Number]',
				'id43@TCarac_Weight as Weight',
				'id37@Comments as Comments'
				);
				
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if($this->params['url']['format']=="geojson"){
						$format="geojson";
					}
				}
				/*'contain' => array('Comment', 'User' => array('Comment', 'Profile'))*/
				
				if($labelcarac!="")
					$fields=array("Trx_Sat_Obj_PK","id42@TCaracThes_Company_Precision","id41@TCaracThes_Model_Precision",
					"id37@Comments");
				$iniresult=$this->TViewTrxSat->find("first",array(
					'recursive'=>$recursive,
					'fields'=> $fields,
					'conditions'=> array('Trx_Sat_Obj_pk'=>$id)
				));							
				$result=$iniresult;
				//print_r($result);
				//history case
				
				if($labelcarac!=""){	
					//unset($iniresult[0]['TViewTrxSat']);
					$countindval=count($iniresult['TViewTrxSat']);
					$i=0;
					foreach($iniresult['TViewTrxSat'] as $key=>$val){
						if($key=='Trx_Sat_Obj_PK'){
							$iniresult['TViewTrxSat']['Id']=$iniresult['TViewTrxSat']['Trx_Sat_Obj_PK'];								
						}
						else{
							foreach($labelcarac as $name=>$label){
								if(strpos($key,$name)!==false){
									$iniresult['TViewTrxSat'][$label]=$iniresult['TViewTrxSat'][$key];	
								}
							}
						}
						unset($iniresult['TViewTrxSat'][$key]);
						$i++;
						if($i>$countindval)
							break;
					}
					//print_r($iniresult);
					//delete empty
					foreach($iniresult as $type=>$values){
						/*if($type!="TViewTrxSat"){
							if(count($values)==1){
								$iniresult[]=array($type=>$values);
								unset($iniresult[$type]);
							}
							else{
								foreach($values as $val){
									$iniresult[]=array($type=>array($val));
								}
							}
							unset($iniresult[$type]);	
						}
						else{
							$iniresult[]=array($type=>$values);
							unset($iniresult[$type]);
						}	*/
						if(count($values)==0)
							unset($iniresult[$type]);
					}
					
					//order by date historical associated model
					/*$cmp=function ($a, $b) {
						$akeyarr=array_keys($a);
						$akey=$akeyarr[0];
						$bkeyarr=array_keys($b);
						$bkey=$bkeyarr[0];
						if(!isset($a[$akey][0]['begin_date']))
							return -1;
						else if(!isset($b[$bkey][0]['begin_date']))
							return 1;
						else if($a[$akey][0]['begin_date'] == $b[$bkey][0]['begin_date']) {
							return 0;
						}
						return ($a[$akey][0]['begin_date'] < $b[$bkey][0]['begin_date']) ? -1 : 1;
					};
					//uasort($iniresult,$cmp);
					*/
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
				// $result[]= array($result);	
				
				$this->set("result",array($result));
			}
			else{
				
			}
			$this->RequestHandler->respondAs('json');
			// $this->RequestHandler->respondAs('html');
			$this->viewPath .= "/$format";
			$this->layout = 'json';
			$this->layoutPath = 'json';	
			if($carac!="")
				$this->render("SatCarac");
		}			
				
	}

?>