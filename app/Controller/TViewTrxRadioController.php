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
				$fields=array('Trx_Radio_Obj_PK',		
				'id5@TCarac_Transmitter_Frequency',
				'id41@TCaracThes_Model_Precision ',
				'id42@TCaracThes_Company_Precision',
				'id6@TCarac_Transmitter_Serial_Number',
				'id43@TCarac_Weight',
				'id44@TCarac_InitialLivespan',
				'id40@TCaracThes_Shape_Precision',
				'id46@TCaracThes_BatteryType_Precision',
				'id1@Thes_Status_Precision',
				'id24@TCaracThes_Txt_Harness_Precision',
				'id57@TCarac_UpdatedLifeSpan',
				'id58@TCarac_Date_UpdatedLifeSpan',
				'id37@Comments'
				);
				$fields=$this->caraclabel($fields);
				
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
					
					//delete empty
					foreach($iniresult as $type=>$values){
						if($type!="TViewTrxRadio"){
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
						}
						if(count($values)==0)
							unset($iniresult[$type]);
					}
					
					//order by date historical associated model
					/*$cmp=function($a,$b){
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
					uasort($iniresult,$cmp);*/
					
					$result=$iniresult;
				}				
				//check if equipped or not
				else if(count($result)>0){					
					// print_r($result);
					if(isset($result[0]['Serial Number']) && $result[0]['Serial Number']!='' && $result[0]['Serial Number']!=null){
						$equiped=$this->TViewIndividual->find("first",						
							array("fields" => array("id6@TCarac_Transmitter_Serial_Number","id9@TCarac_Release_Ring_Code"),
								  "recursive"=>0,
								  "conditions"=>array("id6@TCarac_Transmitter_Serial_Number"=>$result[0]['Serial Number'])					
							)
						);
					}
					else
						$equiped=array();
					if(count($equiped)>0){
						$equi="Equipped on Individual";
						if($equiped['TViewIndividual']['id9@TCarac_Release_Ring_Code']!="")
							$equi.= " ".$equiped['TViewIndividual']['id9@TCarac_Release_Ring_Code'];
					}
					else{
						$equi="Not equipped";
					}
					$idarr=array('ID'=>$result[0]['ID']);
					$result[0]=array_merge(array("Equipped"=>$equi),$result[0]);
					unset($result[0]['ID']);					
					$result[0]=array_merge($idarr,$result[0]);
					$result['TViewTrxRadio']=$result[0];					
					unset($result[0]);
					
					//edit boutton val
					foreach($result['TViewTrxRadio'] as $key=>$val){
						$editb=$this->editbouton("TViewTrxRadio","Trx_Radio_Obj_PK",$fields,"TViewTrxRadio_".$key,$val);
						$result['TViewTrxRadio'][$key]=array($val,$editb);
					}
			
				}	
				// print_r($result);	
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
				$this->render("radioCarac");
		}	
	
	}

?>