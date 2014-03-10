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

		//detail of an individu (Object part)
		function detail(){
			$id="";
			$recursive=0;
			$carac="";
			$labelcarac="";
			$this->loadModel('TViewIndividual');
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
				/*'contain' => array('Comment', 'User' => array('Comment', 'Profile'))*/
				if($format=="geojson"){
					$this->loadModel('TViewIndividual');
					$this->TViewIndividual->setSource('TProtocol_Summary');
					$this->TViewIndividual->primaryKey="Id";
					$result=$this->TViewIndividual->find("all",array(
						'conditions'=> array('Fk_Ind'=>$id)
					));	
				}
				else{
					if($labelcarac!="")
						$fields=array("Individual_Obj_PK","id30@TCaracThes_Sex_Precision","id33@Thes_Origin_Precision",
						"id34@TCaracThes_Species_Precision","id35@Birth_date","id36@Death_date","id37@Comments");
					$iniresult=$this->TViewIndividual->find("all",array(
						'recursive'=>$recursive,
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
					
					if($labelcarac==""){
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
					else{	
						//unset($iniresult[0]['TViewIndividual']);
						$countindval=count($iniresult[0]['TViewIndividual']);
						$i=0;
						foreach($iniresult[0]['TViewIndividual'] as $key=>$val){
							if($key=='Individual_Obj_PK'){
								$iniresult[0]['TViewIndividual']['Id']=$iniresult[0]['TViewIndividual']['Individual_Obj_PK'];								
							}
							else{
								foreach($labelcarac as $name=>$label){
									if(strpos($key,$name)!==false){
										$iniresult[0]['TViewIndividual'][$label]=$iniresult[0]['TViewIndividual'][$key];	
									}
								}
							}
							unset($iniresult[0]['TViewIndividual'][$key]);
							$i++;
							if($i>$countindval)
								break;
						}
						foreach($iniresult[0] as $type=>$values){
							if(count($values)==0)
								unset($iniresult[0][$type]);
						}
						$result=$iniresult;
					}	
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
				$this->render("IndivCarac");
		}

		//indiv add
		//post
		//data: 'Age={"value_precision":"adult","begin_date":null,"end_date":"null","comments":null}&Sex={"value_precision":"male","begin_date":null,"end_date":"null","comments":null}&Species={"value_precision":"North African Houbara Bustard","begin_date":null,"end_date":"null","comments":null}&Origin={"value_precision":"wild","begin_date":null,"end_date":"null","comments":null}&Individual_status={"value_precision":"Unknown","begin_date":null,"end_date":"null","comments":null}&Monitoring_status={"value_precision":"Lost","begin_date":null,"end_date":"null","comments":null}&Survey_type={"value_precision":"Tracking","begin_date":null,"end_date":"null","comments":null}&Birth_date={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Death_date={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Comments={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Breeding_Color={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Breeding_code={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Breeding_Position={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Release_Color={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Release_code={"value_precision":"W-00277","begin_date":null,"end_date":"null","comments":null}&Release_Position={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Chip_Code={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&VHF_Serial_Number={"value_precision":10144,"begin_date":null,"end_date":"null","comments":null}&VHF_Frequency={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&VHF_Model={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&VHF_Shape={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Argos_PTT={"value_precision":73468,"begin_date":null,"end_date":"null","comments":null}&Argos_model={"value_precision":"GPS solar Microwave 45g","begin_date":null,"end_date":"null","comments":null}&Argos_manufacturer={"value_precision":"Microwave Telemetry","begin_date":null,"end_date":"null","comments":null}&Marking1_Color={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Marking1_Position={"value_precision":null,"begin_date":null,"end_date":"null","comments":null}&Marking1_Code={"value_precision":13456,"begin_date":null,"end_date":"null","comments":null}&Marking2_Color={"value_precision":"blue","begin_date":null,"end_date":"null","comments":null}&Marking2_Position={"value_precision":null,"begin_date":null,"end_date":"null","comments":{"value_precision":null,"begin_date":null,"end_date":"null","comments":null}}&Marking2_Code=null',
		function add(){
			$this->loadModel('Tthesaurus');
			$this->loadModel('TViewIndividual');
			$this->loadModel('TObjCaractype');
			$this->loadModel('TObject');
			$this->loadModel('TObjectCaracValue');
			//get caractype for the creation of carac history
			$caractype=$this->TObjCaractype->find("list",array("fields"=>array("name","Carac_type_Pk","label")));
			
			$current_identresult=$this->TObjectCaracValue->find("first",
				array("fields"=>array("Carac_value_Pk"),
					  "order"=>"Carac_value_Pk desc",
					  "recursive"=>0
				)
			);
			
			//$tobject=$this->TObject->query("SELECT IDENT_CURRENT('TObj_Objects')");
			//$tobject[0][0][""];
			
			//print_r($tobject[0][0][""]);
			$currentdate=date('Y-m-d h:i:s');
			
			$idcarac=$current_identresult['TObjectCaracValue']['Carac_value_Pk'];
			$idcarac++;
			// $this->autoRender=false;
			//check if it's a post request
			if ($this->request->is('post')) {
				//create TObject
				$dataforsave=array("TObject"=>array("Id_object_type"=>1,"Name_object_type"=>"Individual","Creation_date"=>$currentdate));
				$dataforsave["TObject"]['TViewIndividual']=array();
				$indfield=array_keys($this->TViewIndividual->schema());				
				/*$label_val=array("Ind_ID"=>,"Individual_Obj_PK","Ind_Age"=>"id2@Thes_Age_Precision"
				,"Ind_Sex"=>"id30@TCaracThes_Sex_Precision","Ind_Species"=>"id34@TCaracThes_Species_Precision",
				"Origin"=>"id33@Thes_Origin_Precision","Ind_Individual_status"=>"");*/
				$data=$this->request->data;
				//$dataforsave+=array("TViewIndividual"=>array());
				// $dataforsave=array();
				//creation of table for the cakephp save
				foreach($data as $datakey=>$val){					
					//get the json value from field value post to a array
					$carac=json_decode($val,true);
					$val=$carac['value_precision'];
					$datebegin=$carac['begin_date'];
					$dateend=$carac['end_date'];
					$caraccomment=$carac['comments'];
					
					//value null case
					if($val==null || $val=="null" || $val=="")
						$val=null;
						
					//Some manipulation for create a good table for the save	
					$datakey=str_replace(array("VHF","Argos","Marking1","Marking2"),array("Transmitter","PTT","Mark_1","Mark_2"),$datakey);
					$datakeysplit=explode("_",$datakey);
					$nbdatakeysplit=count($datakeysplit);
					
					$nb_part=0;
					//for each field from TViewIndividual we will see the corresponding field from the post data
					foreach($indfield as $fieldname){
						$nb_part=0;
						$thesau=false;
						//search of the right field	
						foreach($datakeysplit as $datakeypart){
							if(stripos($fieldname,$datakeypart)!==false){
								$nb_part++;	
							}			
						}
						//id add in array save
						//$dataforsave['TViewIndividual']+=array("Individual_Obj_PK"=>$id);
						
						
						//if it's the good field table / field post	
						//fill the table							
						if($nb_part==$nbdatakeysplit){
							//TViewIndividual part
							//check if string the field need thesaurus id
							if(in_array($fieldname."_Precision",$indfield)){
								if($val){
									$thesau=true;
									$Thes_result=$this->Tthesaurus->find("first",array(
										'fields'=>array("ID"),
										'order'=>"ID desc",
										'conditions'=>array("topic_en"=>$val)
									));
									$thesid=$Thes_result['Tthesaurus']['ID'];
									$dataforsave["TObject"]['TViewIndividual']=array_merge($dataforsave["TObject"]['TViewIndividual'],array($fieldname=>$thesid));
									$dataforsave["TObject"]['TViewIndividual']=array_merge($dataforsave["TObject"]['TViewIndividual'],array($fieldname."_Precision"=>$val));
								}
								/*else{
									$dataforsave['TViewIndividual']+=array($fieldname=>null);
									$dataforsave['TViewIndividual']+=array($fieldname."_Precision"=>null);
								}	*/
							}	
							else
								$dataforsave["TObject"]['TViewIndividual']=array_merge($dataforsave["TObject"]['TViewIndividual'],array($fieldname=>$val));
							if($val){
								//Tcarac history part	
								foreach($caractype as $caraclabel=>$caracname_id){
									foreach($caracname_id as $caracname=>$caracid){
										//find the good associated model name and fill the table
										if(strpos($fieldname,$caracname)!==false){
											$caraclabel=str_replace(" ","_",$caraclabel);
											//$datebegin
											//$dateend
											//$caraccomment
											//$currentdate
											$arrayassociated=array(/*'Carac_value_Pk'=>$idcarac,*/'creation_date'=>$currentdate,'Fk_carac'=>$caracid,'object_type'=>'Individual');
											if($datebegin==null || $datebegin=="null" || $datebegin==""){
												$bdate=date("Y-m-d",mktime(0,0,0,date('m'),date('d')-1,date('Y')-10));
												$arrayassociated+=array('begin_date'=>$bdate);
											}	
											else
												$arrayassociated+=array('begin_date'=>$datebegin);
											if($dateend==null || $dateend=="null" || $dateend=="")
												$dateend=null;
											else
												$arrayassociated+=array('end_date'=>$dateend);	
											if($caraccomment==null || $caraccomment=="null" || $caraccomment=="")
												$caraccomment=null;
											else
												$arrayassociated+=array('comments'=>$caraccomment);	
											$thesval=null;
												
											if($thesau){
												$thesval=$Thes_result['Tthesaurus']['ID'];
												$arrayassociated+=array('value'=>$thesval,'value_precision'=>$val);	
											}
											else
												$arrayassociated+=array('value'=>$val);
												
											// $dataforsave[$caraclabel]=array();
											$dataforsave["TObject"][$caraclabel]=$arrayassociated;
											// $dataforsave[$caraclabel][]=$arrayassociated;
											// $dataforsave['TViewIndividual'][$caraclabel]=$arrayassociated;
											
											break;
										}
									}	
								}
							}	
							break;	
						}		
					}						
					//}
				}
				print_r($dataforsave);
				$this->TObject->create();
				try{
					$success=$this->TObject->saveMany($dataforsave,array("deep"=>true,"atomic"=>false));
				}
				catch(PDOException $e){
					print_r("Error: " . $e->getMessage());
					$success=false;
				}
				if ($success) {
					print_r("success");
				} 
				else {
					print_r("error");
				}
			}
			else{
				print_r("Not a post");	
			}
			
			// $this->RequestHandler->respondAs('json');
			$this->RequestHandler->respondAs('html');
			$this->viewPath .= "/json";
			// $this->layout = 'json';
			// $this->layoutPath = 'json';	
		}	
	}

?>