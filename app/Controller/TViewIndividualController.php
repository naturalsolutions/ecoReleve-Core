<?php
	App::uses('AppController','Controller');
	class TViewIndividualController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);
		
		function index(){
			
		}	

		function detail(){
			$id="";
			if(isset($this->request->params['id']) && $this->request->params['id']!=""){
				$id=$this->request->params['id'];					
			}
			if($id!=""){
				$this->loadModel('TViewIndividual');
				$fields=array('Individual_Obj_PK as ID',		
				'id2@Thes_Age_Precision as Age',
				'id30@TCaracThes_Sex_Precision as Sex',				
				'id34@TCaracThes_Species_Precision as Species',
				'id33@Thes_Origin_Precision as Origin',
				'id59@TCaracThes_Individual_Status as Individual_status',
				'id60@TCaracThes_Monitoring_Status_Precision as Monitoring_status',
				'id61@TCaracThes_Survey_type_Precision as Survey_type',
				'id35@Birth_date as Birth_date',
				'id36@Death_date as Death_date',
				'id37@Comments as Comments',
				'id11@TCaracThes_Breeding_Ring_Color_Precision as Breeding_Color',
				'id12@TCarac_Breeding_Ring_Code as Breeding_code',
				'id10@TCaracThes_Breeding_Ring_Position_Precision as Breeding_Position',
				'id8@TCaracThes_Release_Ring_Color_Precision as Release_Color',
				'id9@TCarac_Release_Ring_Code as Release_Code',
				'id7@TCaracThes_Release_Ring_Position_Precision as Release_Position',
				'id13@TCarac_Chip_Code as Chip_Code',
				'id6@TCarac_Transmitter_Serial_Number as VHF_Serial_Number',
				'id5@TCarac_Transmitter_Frequency as VHF_Frequency',
				'id4@TCaracThes_Transmitter_Model_Precision as VHF_Model',
				'id3@TCaracThes_Transmitter_Shape_Precision as VHF_Shape',
				'id19@TCarac_PTT as Argos_PTT',
				'id22@TCaracThes_PTT_model_Precision as Argos_model',
				'id20@TCaracThes_PTT_manufacturer_Precision as Argos_manufacturer',
				'id14@TCaracThes_Mark_Color_1_Precision as Marking1_Color',
				'id15@TCaracThes_Mark_Position_1_Precision as Marking1_Position',
				'id55@TCarac_Mark_code_1 as Marking1_Code',
				'id16@TCaracThes_Mark_Color_2_Precision as Marking2_Color',
				'id17@TCaracThes_Mark_Position_2_Precision as Marking2_Position',
				'id56@TCarac_Mark_code_2 as Marking2_Code'
				
				);
				$format="json";
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if($this->params['url']['format']=="geojson"){
						$format="geojson";
					}
				}
				
				if($format=="geojson"){
					$this->loadModel('TViewIndividual');
					$this->TViewIndividual->setSource('TProtocol_Summary');
					$result=$this->TViewIndividual->find("all",array(
						'conditions'=> array('Fk_Ind'=>$id)
					));		
				}
				else{
					$iniresult=$this->TViewIndividual->find("all",array(
						'fields'=> $fields,
						'conditions'=> array('Individual_Obj_PK'=>$id)
					));				
					
					$indfield=array('ID','Age','Sex','Species','Origin','Individual_status'
					,'Monitoring_status','Survey_type','Birth_date','Death_date','Comments');
					$ringfield=array('Breeding_Color','Breeding_code','Breeding_Position','Release_Color','Release_Code',
					'Release_Position','Chip_Code');				
					$transmitterfield=array('VHF_Serial_Number','VHF_Frequency','VHF_Model','VHF_Shape'
					,'Argos_PTT','Argos_model','Argos_manufacturer');
					$markingfield=array('Marking1_Color','Marking1_Position','Marking1_Code','Marking2_Color','Marking2_Position','Marking2_Code');
					
					$result=array('Ind'=>array()
					,'Ring'=>array('Breeding'=>array(),'Release'=>array(),'Chip'=>array())
					,'Transmitter'=>array('VHF'=>array(),'Argos'=>array())
					,'Marking'=>array('Marking1'=>array(),'Marking2'=>array()));
					// print_r($iniresult);
					foreach($iniresult[0][0] as $field=>$value){
						// print_r($field);
						if(in_array($field,$indfield))
							$result['Ind']+=array($field=>$value);
						else if(in_array($field,$ringfield)){
							list($part,$fieldpart)=split("_",$field,2);
							$result['Ring'][$part]+=array($fieldpart=>$value);						
						}	
						else if(in_array($field,$transmitterfield)){
							list($part,$fieldpart)=split("_",$field,2);
							$result['Transmitter'][$part]+=array($fieldpart=>$value);
						}
						else if(in_array($field,$markingfield)){
							list($part,$fieldpart)=split("_",$field,2);
							$result['Marking'][$part]+=array($fieldpart=>$value);
						}
					}
				}
				$this->set("result",$result);
			}
			else{
				
			}
			$this->RequestHandler->respondAs('json');
			$this->viewPath .= "/$format";
			$this->layout = 'json';
			$this->layoutPath = 'json';	
		}

			
	}

?>