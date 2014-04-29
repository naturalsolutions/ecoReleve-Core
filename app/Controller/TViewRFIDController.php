<?php
	App::uses('AppController','Controller');
	class TViewRFIDController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);

		function detail(){
			$id="";
			$recursive=0;
			$format="json";
			$this->loadModel('TViewRFID');
			$this->loadModel('TViewIndividual');
			$this->loadModel('ObjCaracList');
			$this->loadModel('TObjCaractype');
			$labelcarac="";
			$carac="";
			$editval="";
			$edit=false;
			if(isset($this->request->params['id']) && $this->request->params['id']!=""){
				$id=$this->request->params['id'];					
			}
			
			//get field label name from app
			if(isset($this->params['url']['editable']) && $this->params['url']['editable']!=""){
				$editval=$this->params['url']['editable'];
			}
			
			//get field label name content from app
			if(isset($this->params['url']['content']) && $this->params['url']['content']!="" && $this->params['url']['content']!="null"){
				$content=$this->params['url']['content'];
			}
						
			if(isset($this->request->params['carac']) && $this->request->params['carac']!=""){
				$carac=$this->request->params['carac'];	
				$recursive=1;
				$labelcarac=$this->TObjCaractype->find("list",array(
					'fields'=>array('name','label')			
				));
				
				$func=function ($val){
					return str_replace(" ","_",$val).".*";
				};								
				$labelcaracwspace=array_map($func,$labelcarac);	
				//print_r($labelcarac);
			}
			
			$fields=array('RFID_Obj_pk',		
				'id65@TCarac_rfid_Serial_Number',
				'id41@TCaracThes_Model_Precision',
				'id42@TCaracThes_Company_Precision',				
				'id37@Comments'
			);
			$fields=$this->caraclabel($fields);
			if($editval!=""){
				$editval=str_replace("TViewRFID_","",$editval);
				$fieldname="";
				$ltype="";
				$id_carac="";
				//find field sql name from var field
				foreach($fields as $field){
					list($v,$l)=explode(" as ",$field);
					if($editval==$l){
						$fieldname=$v;
					}
				}
				$fieldname=preg_replace(array('/id(\d+)@/','/_Precision/'),array("",""),$fieldname);
				//find id_type from editval (label of carac)
				if($fieldname!="RFID_Obj_pk"){
					$id_carac_array=$this->TObjCaractype->find("all",array(
						"fields" => array("Carac_type_Pk"),
						"conditions" => array("name"=>trim($fieldname))
					));
					$id_carac=$id_carac_array[0]['TObjCaractype']['Carac_type_Pk'];
					
					//getting the type and contant value of the carac
					$objcaraclist=$this->ObjCaracList->find('first',array(
						"fields"=> array("value_type","Constant"),
						"conditions"=>array("fk_Carac_type"=>$id_carac)
					));
					$value_type=$objcaraclist['ObjCaracList']['value_type'];
					$constant=$objcaraclist['ObjCaracList']['Constant'];
					
					//check if we can edit this carac
					if($constant==0 || ($constant==1 && !isset($content))){
						$edit=true;
					}				
					
					switch($value_type){
						case "thesaurus":
							$ltype="t";
							break;
						case "function":
							$edit=false;
							break;
						case "int":	
							$ltype="i";
							break;
						case "float":
							$ltype="f";
							break;
						case "datetime":
							$ltype="d";
							break;
						default:
							$ltype="v";
							break;	
					}
				}
				else
					$edit=false;
					
				$typeandid=$ltype.$id_carac;
				$result=array("edit"=>$edit,"typeandid"=>$typeandid);
				$this->set('result',$result);
			}
			else if($id!=""){									
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if($this->params['url']['format']=="geojson"){
						$format="geojson";
					}
				}
				/*'contain' => array('Comment', 'User' => array('Comment', 'Profile'))*/
				
				if($labelcarac!="")
					$fields=array("RFID_Obj_pk","id65@TCarac_rfid_Serial_Number","id41@TCaracThes_Model_Precision",
					"id42@TCaracThes_Company_Precision","id37@Comments");
				$iniresult=$this->TViewRFID->find("first",array(
					'recursive'=>$recursive,
					'fields'=> $fields,
					'conditions'=> array('RFID_Obj_pk'=>$id)
				));							
				$result=$iniresult;
				//print_r($result);
				//history case
				
				if($labelcarac!=""){						
					//unset($iniresult[0]['TViewTrxSat']);
					$countindval=count($iniresult['TViewRFID']);
					$i=0;
					foreach($iniresult['TViewRFID'] as $key=>$val){
						if($key=='RFID_Obj_pk'){							
							$iniresult['TViewRFID']['Id']=$iniresult['TViewRFID']['RFID_Obj_pk'];								
						}
						else{
							foreach($labelcarac as $name=>$label){
								if(strpos($key,$name)!==false){
									$iniresult['TViewRFID'][$label]=$iniresult['TViewRFID'][$key];	
								}
							}
						}
						unset($iniresult['TViewRFID'][$key]);
						$i++;
						if($i>$countindval)
							break;
					}
					//print_r($iniresult);
					//delete empty
					foreach($iniresult as $type=>$values){
						if($type!="TViewRFID"){
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
				else{
					$result['TViewRFID']=$result[0];
					unset($result[0]);
					foreach($result['TViewRFID'] as $key=>$val){
						$editb=$this->editbouton("TViewRFID","RFID_Obj_pk",$fields,"TViewRFID_".$key,$val);
						$result['TViewRFID'][$key]=array($val,$editb);
					}
				}
				//check if equipped or not
				/*else if(count($result)>0){
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
				}	*/
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