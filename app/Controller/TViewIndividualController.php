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

		function compare($a, $b) {
			if ($a[0]['begin_date'] == $b[0]['begin_date']) {
				return 0;
			}
			return ($a[0]['begin_date'] < $b[0]['begin_date']) ? -1 : 1;
		}	
		
		//detail of an individu (Object part)
		function detail(){
			$id="";
			$recursive=0;
			$carac="";
			$labelcarac="";
			$conditions=array();
			$this->loadModel('TViewIndividual');
			if(isset($this->request->params['id']) && $this->request->params['id']!=""){
				$id=$this->request->params['id'];					
			}
			
			if(isset($this->request->params['count']) && $this->request->params['count']!=""){
				$count=$this->request->params['count'];					
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
			$fields=array('Individual_Obj_PK',		
				'id2@Thes_Age_Precision',
				'id30@TCaracThes_Sex_Precision',				
				'id34@TCaracThes_Species_Precision',
				'id33@Thes_Origin_Precision',
				'id59@TCaracThes_Individual_Status',
				'id60@TCaracThes_Monitoring_Status_Precision',
				'id61@TCaracThes_Survey_type_Precision',
				'id35@Birth_date',
				'id36@Death_date',
				'id37@Comments',
				'id11@TCaracThes_Breeding_Ring_Color_Precision',
				'id12@TCarac_Breeding_Ring_Code',
				'id10@TCaracThes_Breeding_Ring_Position_Precision',
				'id8@TCaracThes_Release_Ring_Color_Precision',
				'id9@TCarac_Release_Ring_Code',
				'id7@TCaracThes_Release_Ring_Position_Precision',
				'id13@TCarac_Chip_Code',
				'id6@TCarac_Transmitter_Serial_Number',
				'id5@TCarac_Transmitter_Frequency',
				'id4@TCaracThes_Transmitter_Model_Precision',
				'id3@TCaracThes_Transmitter_Shape_Precision',
				'id19@TCarac_PTT',
				'id22@TCaracThes_PTT_model_Precision',
				'id20@TCaracThes_PTT_manufacturer_Precision',
				'id14@TCaracThes_Mark_Color_1_Precision',
				'id15@TCaracThes_Mark_Position_1_Precision',
				'id55@TCarac_Mark_code_1',
				'id16@TCaracThes_Mark_Color_2_Precision',
				'id17@TCaracThes_Mark_Position_2_Precision',
				'id56@TCarac_Mark_code_2'				
			);
			$fields=$this->caraclabel($fields);
			
			$fields_matching=array('ID'=>'ID',		
				'Age'=>'Age',
				'Sex'=>'Sex',				
				'Species'=>'Species',
				'Origin'=>'Origin',
				'Individual_status'=>'Individual status',
				'Monitoring_status'=>'Monitoring status',
				'Survey_type'=>'Survey type',
				'Birth_date'=>'Birth date',
				'Death_date'=>'Death date',
				'Comments'=>'Comments',
				'Breeding_Color'=>'Breeding ring color',
				'Breeding_code'=>'Breeding ring code',
				'Breeding_Position'=>'Breeding ring position',
				'Release_Color'=>'Release ring color',
				'Release_Code'=>'Release ring code',
				'Release_Position'=>'Release ring position',
				'Chip_Code'=>'Chip code',
				'VHF_Serial_Number'=>'Serial number',
				'VHF_Frequency'=>'Frequency',
				'VHF_Model'=>'Tansmitter model',
				'VHF_Shape'=>'Tansmitter shape',
				'Argos_PTT'=>'PTT',
				'Argos_model'=>'PTT model',
				'Argos_manufacturer'=>'PTT manufacturer',
				'Marking1_Color'=>'Mark color 1',
				'Marking1_Position'=>'Mark position 1',
				'Marking1_Code'=>'Mark code 1',
				'Marking2_Color'=>'Mark color 2',
				'Marking2_Position'=>'Mark position 2',
				'Marking2_Code'=>'Mark code 2'				
			);
			// print_r($fields);
			if($id!=""){				
				
				$format="json";
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if($this->params['url']['format']=="geojson"){
						$format="geojson";
					}
				}
				
				if(isset($this->params['url']['id_protocole']) && $this->params['url']['id_protocole']!=""){
					$id_protocole=intval($this->params['url']['id_protocole']);	
					$conditions+=array("StationType"=>$id_protocole);
				}
				
				if(isset($this->params['url']['date_depart']) && $this->params['url']['date_depart']!=""){
					$date_depart=$this->params['url']['date_depart'];	
					$conditions+=array("CONVERT(char(10),[DATE],126) >="=>$date_depart);
				}
				
				if(isset($this->params['url']['date_fin']) && $this->params['url']['date_fin']!=""){
					$date_fin=$this->params['url']['date_fin'];	
					$conditions+=array("CONVERT(char(10),[DATE],126) <="=>$date_fin);
				}
				
				/*'contain' => array('Comment', 'User' => array('Comment', 'Profile'))*/
				if($format=="geojson"){
					$conditions+=array('Fk_Ind'=>$id);
					$conditions[]=array('LAT is not null and LON is not null');
					$this->TViewIndividual->setSource('TProtocol_Summary');
					$this->TViewIndividual->primaryKey="Id";
					$result=$this->TViewIndividual->find("all",array(
						'recursive'=>0,
						'conditions'=> $conditions,
						'order'=>array("DATE asc")
					));	
					
					$minlat=1000;
					$minlon=1000;
					$maxlat=-1000;
					$maxlon=-1000;
					//bbox creation
					foreach($result as $s){
						$thislat=$s['TViewIndividual']['LAT'];
						$thislon=$s['TViewIndividual']['LON'];
						if($thislat>$maxlat)
							$maxlat=$thislat;
						if($thislon>$maxlon)
							$maxlon=$thislon;
						if($thislat<$minlat)
							$minlat=$thislat;
						if($thislon<$minlon)
							$minlon=$thislon;			
					}
					$this->set('maxlat',floatval($maxlat));
					$this->set('maxlon',floatval($maxlon));
					$this->set('minlat',floatval($minlat));
					$this->set('minlon',floatval($minlon));	
					
				}
				else{
					if($labelcarac!="")
						$fields=array("Individual_Obj_PK","id30@TCaracThes_Sex_Precision","id33@Thes_Origin_Precision",
						"id34@TCaracThes_Species_Precision","id35@Birth_date","id36@Death_date","id59@TCaracThes_Individual_Status",
						"id60@TCaracThes_Monitoring_Status_Precision","id61@TCaracThes_Survey_type_Precision","id37@Comments");
					$iniresult=$this->TViewIndividual->find("all",array(
						'recursive'=>$recursive,
						'fields'=> $fields,
						'conditions'=> array('Individual_Obj_PK'=>$id)
					));							
					$indfield=array('ID','Age','Sex','Species','Origin','Individual status'
					,'Monitoring status','Survey type','Birth date','Death date','Comments');
					$ringfield=array('Breeding ring color','Breeding ring code','Breeding ring position','Release ring color','Release ring code',
					'Release ring position','Chip code');				
					$transmitterfield=array('Serial number','VHF_Frequency','Tansmitter model','Tansmitter shape'
					,'PTT','PTT model','PTT manufacturer');
					$markingfield=array('Mark color 1','Mark position 1','Mark code 1','Mark color 2','Mark position 2','Mark code 2');
					
					//not history case
					if($labelcarac==""){
						$result=array('Ind'=>array()
						,'Ring'=>array('Breeding'=>array(),'Release'=>array(),'Chip'=>array())
						,'Transmitter'=>array('VHF'=>array(),'Argos'=>array())
						,'Marking'=>array('Marking1'=>array(),'Marking2'=>array()));
						// print_r($iniresult);
						foreach($iniresult[0][0] as $field=>$value){
							// print_r($field);
							if(in_array($field,$indfield)){
								$editb=$this->editbouton("TViewIndividual","Individual_Obj_PK",$fields,"TViewIndividual_".$field,$value);
								$result['Ind']+=array($field=>array($value,$editb));
							}	
							else if(in_array($field,$ringfield)){
								
								list($part,$fieldpart)=split("_",array_search($field,$fields_matching),2);
								$editb=$this->editbouton("TViewIndividual","Individual_Obj_PK",$fields,$part."_".$fieldpart,$value);								
								$result['Ring'][$part]+=array($fieldpart=>array($value,$editb));						
							}	
							else if(in_array($field,$transmitterfield)){
								list($part,$fieldpart)=split("_",array_search($field,$fields_matching),2);
								$editb=$this->editbouton("TViewIndividual","Individual_Obj_PK",$fields,$part."_".$fieldpart,$value);
								$result['Transmitter'][$part]+=array($fieldpart=>array($value,$editb));
							}
							else if(in_array($field,$markingfield)){
								list($part,$fieldpart)=split("_",array_search($field,$fields_matching),2);
								$editb=$this->editbouton("TViewIndividual","Individual_Obj_PK",$fields,$part."_".$fieldpart,$value);
								$result['Marking'][$part]+=array($fieldpart=>array($value,$editb));
							}
							
							//___________edit here________
						}
					}
					//history case
					else{	
						//unset($iniresult[0]['TViewIndividual']);
						$countindval=count($iniresult[0]['TViewIndividual']);
						$i=0;
						//giving a right label 
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
						
						
						//delete empty
						foreach($iniresult[0] as $type=>$values){
							if($type!="TViewIndividual"){
								if(count($values)==1){
									$iniresult[]=array($type=>$values);
									unset($iniresult[0][$type]);
								}
								else{
									foreach($values as $val){
										$iniresult[]=array($type=>array($val));
									}
									unset($iniresult[0][$type]);
								}
								if(count($values)==0)
									unset($iniresult[0][$type]);	
							}	
								
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
						uasort($iniresult,$cmp);
						*/
						$result=array($iniresult);
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
		
		function getproto(){
			$format='json';
			$recursive=0;
			$this->loadModel('TProtocolSummary');
			$id="";
			$conditions=array();
			// $this->TViewIndividual->setSource('TProtocol_Summary');
			// $this->TViewIndividual->primaryKey="Id";
			$options['joins'] = array(
				array('table' => 'TProtocole',
					'alias' => 'TProtocole',
					'type' => 'INNER',
					'conditions' => array(
						"TProtocole.TTheEt_PK_ID  = StationType" 
					)
				)
			);
			if(isset($this->request->params['id']) && $this->request->params['id']!=""){
				$id=$this->request->params['id'];					
			}			
			
			if(isset($this->params['url']['date_depart']) && $this->params['url']['date_depart']!=""){
					$date_depart=$this->params['url']['date_depart'];	
					$conditions+=array("CONVERT(char(10),[DATE],126) >="=>$date_depart);
				}
				
			if(isset($this->params['url']['date_fin']) && $this->params['url']['date_fin']!=""){
				$date_fin=$this->params['url']['date_fin'];	
				$conditions+=array("CONVERT(char(10),[DATE],126) <="=>$date_fin);
			}
			
			if($id!=""){
				$conditions+=array('Fk_Ind'=>$id);
				$result=$this->TProtocolSummary->find("all",array(
					'recursive'=>$recursive,
					'fields'=> array("TProtocole.Caption as protocole","count(*) as nb","StationType as id"),
					'conditions'=> $conditions,
					'group'=>array("TProtocole.Caption,StationType")
				)+$options);
				$resultnbtotal=$this->TProtocolSummary->find("count",array(
					'recursive'=>$recursive,
					'fields'=> array("StationType as id"),
					'conditions'=> $conditions,
				));
				$result=array_merge(array(array(array("protocole"=>"All protocols","nb"=>$resultnbtotal,"id"=>""))),$result);
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