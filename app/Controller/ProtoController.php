<?php
	//include_once '../../lib/Cake/Model/ConnectionManager.php';
	//include_once 'AppController.php';
	App::uses('AppController','Controller');
	App::uses('Model', 'Model');
	App::uses('AppModel', 'Model');
	App::uses('ProtocoleTaxon', 'Model');
	App::uses('Value', 'Model');	
	App::uses('CartoModel', 'Model');
	App::uses('Taxon', 'Model');
	App::uses('TUser', 'Model');
	App::uses('Taxon_Name', 'Model');
	App::uses('Taxon_Addi', 'Model');
	App::uses('TaxonFamilyCount', 'Model');
	
	define("basep", "narc_ereleve"); //name of database use
	define("limitp",0);  //sql limit default value
	define("offsetp",0); //sql offset default value
	define("cache_timep",3600);
	App::uses('table1', 'Model');
	App::uses('table2', 'Model');
	App::uses('table3', 'Model');
	class ProtoController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler','Cookie','Session');
		var $typereturn;
		public $notauth=false;	
		public $admin=false;
		public $cacheAction = array(  //set the method(webservice) with a cached result
			//'proto_list' => cache_timep,
			//'station_get' => cache_timep,  
			//'proto_taxon_get' => cache_timep,
			//'proto_get' => cache_timep
		);
		
		public function beforeFilter() {
			$this->Cookie->name = 'session';
			$this->Cookie->key = 'q45678SI232qs*&sXOw!adre@34SAdejfjhv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
			$this->Cookie->httpOnly = true;
			parent::beforeFilter();
			if((!$this->Cookie->read('connected') /* || !$this->Session->read('role')*/) && ($this->params['action']=='station_get2' || $this->params['action']=='import_csv' ||
			$this->params['action']=='column_list' || $this->params['action']=='taxon_get' || $this->params['action']=='taxon_count')){
				$this->notauth=true;				
				//$this->redirect(array('action' => 'not_autorized'));
			}
			else {
				$this->notauth=false;
				if($this->Cookie->read('connected')=='Administrateur')
					$this->admin=true;
			}
			if(isset($_SERVER["HTTP_ORIGIN"])){
				//$_SERVER["HTTP_ORIGIN"];
				$origin=$_SERVER["HTTP_ORIGIN"];
				$this->set('origin',$origin);
			}
			
		}
		
		//
		public function not_autorized() {
			$this->RequestHandler->respondAs('json');
			$this->viewPath .= '/json';
			$this->layout= 'json';
			$this->layoutPath = 'json';	
			$this->render('not_autorized');		
		}
		
		function index(){
			$data=array(
				'table1'=>array("c2"=>"fse","c3"=>"pmoo","c4"=>"aze"),
				'table2'=>array(array("c10"=>"kih","c11"=>"poi")),
				//'table3'=>array(array("c15"=>"sdgj","c16"=>"aznnh"))
			);
			$this->loadModel('Station');
			//$this->table1->create();
			//$this->table1->saveAssociated($data);
			//$arr=$this->table1->find("all");
			$filename=$this->params['form']['datafile']['tmp_name'];
			/*if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
				
				$fileData = fread(fopen($this->params['form']['datafile']['tmp_name'], "r"), 
                                     $this->params['form']['datafile']['size']);
				
				fwrite($fp, print_r($fileData ,true));
			}*/
			$res=$this->Station->importcsv($filename);
			if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');					
				fwrite($fp, print_r($res ,true));
			}
			//$this->loadModel('TaxonName');
			//$this->loadModel('TaxonAddi');
			//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
			//fwrite($fp, print_r($this->Taxon->find('all',array('limit'=>10)),true))/*.'\n'.$this->TaxonAddi->find('first')*/;
			
			//$this->TaxonName->find('first');
			
		}
		
		//controller method for the list of protocole
		function proto_list(){
			$basep=basep;
			$table="TProtocole";
			$test=false;
			$format="xml";
			$this->loadModel('Protocole');
			
		
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
		
			
		
			$model = new AppModel("TProtocole",$table,$basep);	
			$conditions=array();
			$debug="";			
			
			//case with a keyword parameter
			if(isset($this->params['url']['motcle'])){
				$mot=$this->params['url']['motcle'];
				$mot=str_replace(" ","%",$mot);
				$conditions=array("Relation LIKE"=>"%$mot%");
			}	
			
			$table = $this->Protocole->find("all",array("conditions"=>array("Active" => 1)+$conditions));	
			
			$this->set("debug",$debug);
			$this->set('protos', $table);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= '/'.$format;
			$this->layout= $format;
			$this->layoutPath = $format;		
		}
		
		//get station for a datatable js can be filtered by protocoles and other param
		function station_get(){	
			$this->typereturn="DatatableJSON";
			$find=1;
			$debug="";
			$table_name="TStations"; //if proto name not set
			$place="";
			$region="";
			$date="";
			$search="";
			$tsearch="";
			$Stationjoin=array();
			$Stationjoinstringname="";
			$dot="";
			$limit=0;
			$Distinct=array();
			$ModelName="AppModel"; //for the array returned by find
			
			if(isset($this->params['url']['limit'])){
				$limit=$this->params['url']['limit'];
			}
			
			if(isset($this->params['url']['to_carto']) && $this->params['url']['to_carto']!=""){
				if($this->params['url']['to_carto']=="yes"){
					$find=2;
				}
			}
			
			$test=0;
			$basep=basep;
			//verify if it's a test
			if(isset($this->params['url']['test']) && $this->params['url']['test']==1 && $this->params['url']['tabletest']){
				$test=1;
				$basep="test";
				$table_name=$this->params['url']['tabletest'];
				$this->set("test","test");
			}
			
			//if protocole filter join to station
			if(isset($this->params['url']['id_proto']) && $this->params['url']['id_proto']!="" && $test==0){
				$Distinct= array();
				$id_proto=$this->params['url']['id_proto'];
				$model_list_proto = new AppModel("TProtocole","TProtocole",basep);
				$table_name_array=$model_list_proto->find('first',array("conditions" => array("TTheEt_PK_ID"=>$id_proto)));
				if(isset($table_name_array['AppModel']['Relation']))
					$table_name="TProtocol_".$table_name_array['AppModel']['Relation'];
				$Stationjoinstringname="TStationsJoin";
				$dot=".";
				$Stationjoin=array('joins' => array(
						array(
							'table' => 'TStations',	
							'alias' => $Stationjoinstringname,	
							'type' => 'INNER',
							'conditions' => array(
								"FK_TSta_ID = $Stationjoinstringname.TSta_PK_ID"
							),
							'group'=>"$Stationjoinstringname.TSta_PK_ID"
						)
					)
				);
				$ModelName=$Stationjoinstringname;	
			}
			
			
			
			if($table_name!="TProtocol_"&& $table_name!=""){
				$Stationjoinstringnamedot=$Stationjoinstringname.$dot;
				$model_proto = new AppModel('TStation',$table_name,$basep);
				$this->set("Model",$model_proto);
				//array that contain the column return
				$column_array = array($Stationjoinstringnamedot."TSta_PK_ID",$Stationjoinstringnamedot."FieldActivity_Name"
				,$Stationjoinstringnamedot."Name",$Stationjoinstringnamedot."DATE",$Stationjoinstringnamedot."Region",$Stationjoinstringnamedot."Place"
				,$Stationjoinstringnamedot."LAT",$Stationjoinstringnamedot."LON");
				$condition_array = array('LAT IS NOT NULL','LON IS NOT NULL');
				$limit=limitp;
				$offset=offsetp;
				$sEcho="1";
				$total=$model_proto->find("count",array()+$Stationjoin);
				
				//BBOX param if map call
				if(isset($this->params['url']['bbox']) && $this->params['url']['bbox']!=""){
					$bbox=$this->params['url']['bbox'];
					$bbox_array=split(",",$bbox);
					$min_lon=$bbox_array[0];
					$max_lon=$bbox_array[2];
					$min_lat=$bbox_array[1];
					$max_lat=$bbox_array[3];
					$condition_array[] = array("LAT >= $min_lat and LAT <= $max_lat and LON >= $min_lon and LON <= $max_lon");
				}
				
				if(isset($this->params['url']['id_stations']) && $this->params['url']['id_stations']!=""){
					$id_stations=$this->params['url']['id_stations'];
					$id_station_array=split(",",$id_stations);	
					$condition_id_sta="";
					for($i=0;$i<count($id_station_array);$i++){
						$or="or";
						if($i==count($id_station_array)-1)
							$or=" ";
						$condition_id_sta.="TSta_PK_ID = $id_station_array[$i] $or ";
					}					
					$condition_array[] = array($condition_id_sta);
					//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
					//fwrite($fp, print_r($condition_array,true));
				}
				//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
				//fwrite($fp, print_r($condition_array,true));
				
				//take limit paramater for a limit filter
				if(isset($this->params['url']['iDisplayLength']) && $this->params['url']['iDisplayLength']!=""){
					$limit=intval($this->params['url']['iDisplayLength']);
				}
				//take offset parameter for a offset filter
				if(isset($this->params['url']['iDisplayStart']) && $this->params['url']['iDisplayStart']!=""){
					$offset=intval($this->params['url']['iDisplayStart']);	
				}
				//take sEcho parameter (param for the datable js)
				if(isset($this->params['url']['sEcho'])){
					$sEcho=$this->params['url']['sEcho'];	
				}			
				$sort_column=$column_array[0];
				$sort_dir="asc";
				//column sort
				if(isset($this->params['url']['iSortCol_0']) &&  $this->params['url']['sSortDir_0']){
					$index_col=intval($this->params['url']['iSortCol_0']);
					$sort_dir= $this->params['url']['sSortDir_0'];
					$sort_column=$column_array[$index_col];
				}
				//take taxonsearch parameter for a taxon filter
				if(isset($this->params['url']['taxonsearch']) && $this->params['url']['taxonsearch']!=""){
					$tsearch=$this->params['url']['taxonsearch'];
				}
				
				//take place parameter for a place filter
				if(isset($this->params['url']['place']) && $this->params['url']['place']!=""){
					$place=$this->params['url']['place'];					
				}
				
				//take region parameter for a region filter
				if(isset($this->params['url']['region']) && $this->params['url']['region']!=""){
					$region=$this->params['url']['region'];
				}
				//if date filter
				if(isset($this->params['url']['idate']) && $this->params['url']['idate']!=""){
					date_default_timezone_set('UTC');
					$date=$this->params['url']['idate'];	
				}
				
				//take the word for the research and do the research
				if(isset($this->params['url']['sSearch']) && $this->params['url']['sSearch']!=""){
					$search=$this->params['url']['sSearch'];				
				}
				
				//create condition array for the sql request
				$condition_array=$model_proto->filter_create($condition_array,$place,$region,$date,"","","",$search,$tsearch,"",true);				
				//find station with the right parameter without search				
				$station = $model_proto->find("all",array('recursive' => 0
														,'limit'=>$limit
														,'offset'=>$offset
														,'fields'=>$column_array
														,'order'=> array("$sort_column $sort_dir")
														,'conditions'=>$condition_array)+$Stationjoin
												);
				if($station){
					$totaldisplay = $model_proto->find("count",array('recursive' => 0
														,'fields'=>$column_array
														,'conditions'=>$condition_array)+$Stationjoin
												);	
				}								
				else 
					$totaldisplay=0;
				
			}
			else
				$find=-1;
			
			if(isset($this->params['url']['format']) && $this->params['url']['format']=="geojson"){
				$zoom=0;
				if(isset($this->params['url']['zoom'])){
					$zoom=$this->params['url']['zoom'];
				}
				$cluster='no';
				
				if(isset($this->params['url']['cluster']) && $this->params['url']['cluster']=='yes')
					$cluster='yes';
				
					
					if($cluster=="yes"){
						$cartomodel=new CartoModel();
						$station=$cartomodel->cluster($station,20,$zoom);
						
					}	
				
				$this->viewPath .= '/geojson';
			}
			else
				$this->viewPath .= '/json';	
				
			//$this->filedebug($totaldisplay);	
			$this->set("find",$find);			
			$this->set("sEcho",$sEcho);
			$this->set("table",$station);
			$this->set("schema",$column_array);
			$this->set("total",$total);
			$this->set("totaldisplay",$totaldisplay);
			$this->set("ModelName",$ModelName);
			$this->set("debug",$debug); 
			$this->RequestHandler->respondAs('json');
			$this->layoutPath = 'json';	
			$this->layout = 'json';		
		}
		
		function station_get2(){
			if(!$this->notauth){
				$format="json";
				$id_proto="";
				$tsearch="";
				$locality="";
				$area="";
				$fa="";
				$name="";
				$condition_array=array();
				$db="mycoflore";
				$limit="";
				$offset="";
				$bbox="";
				$lon="";
				$lat="";
				$find=1;
				$column_array=array();
				$id_taxon="";
				$options=array();
				$cluster="no";
				$zoom=0;
				
				if(isset($this->params['url']['cluster']) && $this->params['url']['cluster']!=""){
					if($this->params['url']['cluster']=="yes"){
						$cluster="yes";
					}
				}	
		
				//get a list of station id from parameter
				if(isset($this->params['url']['id_stations']) && $this->params['url']['id_stations']!=""){
					$id_stations=$this->params['url']['id_stations'];
					$id_station_array=split(",",$id_stations);	
					$condition_id_sta="";
					for($i=0;$i<count($id_station_array);$i++){
						$or="or";
						if($i==count($id_station_array)-1)
							$or=" ";
						$condition_id_sta.="TSta_PK_ID = $id_station_array[$i] $or ";
					}					
					$condition_array[] = array($condition_id_sta);
					//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
					//fwrite($fp, print_r($condition_array,true));
				}			
					
				if(isset($this->params['url']['zoom']) && $this->params['url']['zoom']!="")
					$zoom=$this->params['url']['zoom'];
				
				//format from request
				if(stripos($this->request->header('Accept'),"application/xml")!==false){
					$format="xml"; 
					$tmp_format="xml";
				}
				else if(stripos($this->request->header('Accept'),"application/json")!==false){
					$tmp_format="json";
					$format="json";
				}	
				 
				
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					$tmp_format=$this->params['url']['format'];
					if($tmp_format=="json"){
						$format="json";
					}
					else if($tmp_format=="datatablejs"){
						$column_array = $column_array = array("Area","Locality"
						,'CONVERT(varchar(255), DATE, 103) as DATE',"FieldWorker1");
					}
					else if($tmp_format=="xml"){
						$format="xml";
					}
					else if($tmp_format=="test"){
						$format="test";
					}
				}				
				
				if(isset($this->params['url']['id_proto']) && $this->params['url']['id_proto']!=""){
					$id_proto=$this->params['url']['id_proto'];
				}
				
				if(isset($this->params['url']['id_taxon']) && $this->params['url']['id_taxon']!=""){
					$id_taxon="and TProtocol_Inventory.Id_Taxon='".$this->params['url']['id_taxon']."'";
					$options['joins'] = array(
						array('table' => 'TProtocol_Inventory',
							'alias' => 'TProtocol_Inventory',
							'type' => 'INNER',
							'conditions' => array(
								"TSta_PK_ID = TProtocol_Inventory.FK_TSta_ID $id_taxon" 
							)
						)
					);					
				}
				
				$tsearch="";
				if(isset($this->params['url']['taxonsearch']) && $this->params['url']['taxonsearch']!=""){
					$tsearch=$this->params['url']['taxonsearch'];
				}
				
				$locality="";
				if(isset($this->params['url']['locality']) && $this->params['url']['locality']!=""){
					$locality=$this->params['url']['locality'];
				}
				
				$area="";
				if(isset($this->params['url']['area']) && $this->params['url']['area']!=""){
					$area=$this->params['url']['area'];
				}
				
				$lat="";
				if(isset($this->params['url']['lat']) && $this->params['url']['lat']!=""){
					$lat=$this->params['url']['lat'];
				}
				
				$lon="";
				if(isset($this->params['url']['lon']) && $this->params['url']['lon']!=""){
					$lon=$this->params['url']['lon'];
				}
				
				$name="";
				if(isset($this->params['url']['name']) && $this->params['url']['name']!=""){
					$name=$this->params['url']['name'];
				}
				
				$fa="";
				if(isset($this->params['url']['field_activity']) && $this->params['url']['field_activity']!=""){
					$fa=$this->params['url']['field_activity'];
				}
				
				$idate="";
				if(isset($this->params['url']['idate']) && $this->params['url']['idate']!=""){
					$idate=$this->params['url']['idate'];
				}
				
				if(isset($this->params['url']['limit']) && $this->params['url']['limit']!=""){
					$limit=$this->params['url']['limit'];
				}
				
				if(isset($this->params['url']['offset']) && $this->params['url']['offset']!=""){
					$offset=intval($this->params['url']['offset']);
				}
				
				
				
				/*_____DATATABLE_JS___*/
				if(isset($tmp_format) && $tmp_format=="datatablejs"){
					$sEcho=1;
					//take limit paramater for a limit filter
					if(isset($this->params['url']['iDisplayLength']) && $this->params['url']['iDisplayLength']!=""){
						$limit=intval($this->params['url']['iDisplayLength']);
					}
					//take offset parameter for a offset filter
					if(isset($this->params['url']['iDisplayStart']) && $this->params['url']['iDisplayStart']!=""){
						$offset=intval($this->params['url']['iDisplayStart']);	
					}
					//take sEcho parameter (param for the datable js)
					if(isset($this->params['url']['sEcho'])){
						$sEcho=$this->params['url']['sEcho'];	
						
					}	
					$this->set("sEcho",$sEcho);	
					$sort_column=$column_array[0];
					$sort_dir="asc";
					//column sort
					if(isset($this->params['url']['iSortCol_0']) &&  $this->params['url']['sSortDir_0']){
						$index_col=intval($this->params['url']['iSortCol_0']);
						$sort_dir= $this->params['url']['sSortDir_0'];
						$sort_column=$column_array[$index_col];
					}
				}
				/*______________________*/
				
				//BBOX param if map call
				if(isset($this->params['url']['bbox']) && $this->params['url']['bbox']!=""){
					$bbox=$this->params['url']['bbox'];
					$bbox_array=split(",",$bbox);
					$min_lon=$bbox_array[0];
					$max_lon=$bbox_array[2];
					$min_lat=$bbox_array[1];
					$max_lat=$bbox_array[3];
					$condition_array[] = array("LAT >= $min_lat and LAT <= $max_lat and LON >= $min_lon and LON <= $max_lon");
				}
				
				$this->loadModel('Station');
				//$this->loadModel('TProtocolInventory');
				$condition_array=$this->Station->station_filter($db,$condition_array,$locality,$area,$name,$fa,$lat,$lon,$idate,true);
				
				if(isset($tmp_format) && $tmp_format=="datatablejs"){
					$total=$this->Station->find('count');
					$this->set('total',$total);
					
					$count=$this->Station->find('count',array(
						'limit'=>$limit,
						'offset'=>$offset,
						'conditions'=>$condition_array
					)+$options);
					
					$this->set('totaldisplay',$count);		
				}
							
				//$this->Station->Behaviors->attach('Containable');
				
				//$options['conditions'] = array('TProtocol_Inventory.Id_Taxon' => $id_taxon);
				//$this->Station->hasMany['StationProtocoles']['conditions']['StationProtocoles.PK']=2;
				$result=$this->Station->find('all',array(
					'contain'=>array('SationProtocoles'=>array('conditions'=>array('Id_Taxon'=>"5440"))),
					'recursive'=>1,
					'limit'=>$limit,
					'offset'=>$offset,
					'fields'=>$column_array,
					'conditions'=>$condition_array
					
					
				)+$options);
				
							
				$this->set("debug","");
				$this->set("find",1);
				$this->set("result",$result);
				$this->set("schema",$column_array);
				/*
				if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
					$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
					fwrite($fp, print_r($result ,true));
				}*/
				if($format!="test"){
					if(isset($tmp_format) && $tmp_format=="datatablejs"){ //datatatable view
						$this->viewPath .= '/'."datatablejs";
						$format="json";
					}	
					else if(isset($tmp_format) && $tmp_format=="geojson"){ //geojson view
						$this->viewPath .= '/'."geojson";
						$format="json";
						if($cluster=="yes"){
							$cartomodel=new CartoModel();
							$result=$cartomodel->cluster($result,20,$zoom);
						}	
					}
					else                                                   //json or xml view   			
						$this->viewPath .= '/'.$format;				
					$this->RequestHandler->respondAs($format);							
					$this->layoutPath = $format;
					$this->layout= $format;	
				}
				else{
					$this->RequestHandler->respondAs("html");
					$this->viewPath .= '/'."json";
				}	
			}
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');	
			}		
		}
		
		function import_csv(){
			if($this->admin){
				$this->loadModel('Station');
				$format="json";
				$find=1;
				$res=array();
				$user=$this->Session->read('user');
				$iduser=$user['User']['TUse_Pk_ID'];
				if(isset($this->params['form']['datafile']['tmp_name'])
				&& $this->params['form']['datafile']['tmp_name']!=""){	
					$filename=$this->params['form']['datafile']['tmp_name'];
					$res=$this->Station->importcsv2($filename,$iduser);
					//print_r($res);
					$count_success = count($res['messages']);
					$count_error = count($res['errors']);
					$count_warning = count($res['warning']);
					$this->set('result',$res);
					$this->set('nb_success',$count_success);
					$this->set('nb_error',$count_error);
					$this->set('nb_warning',$count_warning);
				}
				else{
					$find=-1;
					$this->set('message','Aucun fichier');
				}
				$this->set("find",$find);
				$this->set("result",$res);
				/*if(isset($this->params['url']['format']) && $this->params['url']['format']=='text')
					$this->viewPath .= '/text';		
				else	
					$this->viewPath .= '/'.$format;	*/
				$this->viewPath .= '/text';				
				$this->RequestHandler->respondAs($format);							
				$this->layoutPath = $format;
				$this->layout= $format;	
			}	
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');	
			}		
		}	
		
		//controller method for the getting taxon from protocole service 
		function proto_taxon_get(){
			$debug="";
			$find=1;
			$table_name="TProtocole";
			$basep=basep;
			$test=false;
			$taxons=array();
			$format="xml";
			$this->loadModel('Protocole');
			$this->loadModel('ProtocoleTaxon');
			//format from request
			if(stripos($this->request->header('Accept'),"application/xml")!==false){
				$format="xml"; 
				$tmp_format="xml";
			}
			else if(stripos($this->request->header('Accept'),"application/json")!==false){
				$tmp_format="json";
				$format="json";
			}	
				
			
			if(isset($this->params['url']['format']) && $this->params['url']['format']!="")
				$format=$this->params['url']['format'];
			
			
			
			if(isset($this->params['url']['id_proto']) ){
				$id_proto = $this->params['url']['id_proto'];
				
				//get the name of table from the id				
				$pk_id_name="TTheEt_PK_ID";
				
				$table_name_array=$this->Protocole->find('first',array("conditions" => array($pk_id_name=>$id_proto)));
				if(isset($table_name_array['Protocole']['Relation'])){
					$table_name="TProtocol_".$table_name_array['Protocole']['Relation'];					
				}	
				else
					$find=-1;
				
				
				//Get detail after finding the protocole name 	
				if($find!=-1){	
					$array_conditions=array();
					if(isset($this->params['url']['search']) && isset($this->params['url']['search'])!=""){
						$search=$this->params['url']['search'];
						$array_conditions+=array('Name_Taxon LIKE'=>'%'.$search.'%');	
					}				
					//finding taxon from table
					try{					
						//$model_proto = new ProtocoleTaxon($table_name,$table_name);	
						$this->ProtocoleTaxon->setSource($table_name);
						//check if the table have taxon field
						/*if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
							$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
							fwrite($fp, print_r($table_name ,true));	
						}*/
						$taxon_find=false;
						//foreach ($model_proto->schema() as $key=>$val){
						foreach ($this->ProtocoleTaxon->schema() as $key=>$val){
							if($key=="Name_Taxon")
								$taxon_find=true;							
						}
						
						if($taxon_find){
							//$taxons=$model_proto->find('all',array(
							$taxons=$this->ProtocoleTaxon->find('all',array(
								'fields'=>array('Name_Taxon'),
								'group'=>array('Name_Taxon'),
								'conditions'=>$array_conditions
							));	
						}	
						else
							$find=-2;//no taxon in table
					}						
					catch(Exception $e){
						$this->set('find',-1); //table not exist
					}	
				}
					
			}			
			else
				$find=0;	
			$this->set("taxons",$taxons);		
			$this->set("table_name",$table_name);	
			$this->set("debug",$debug);
			$this->set("find",$find);
			// Set response as XML
			
			$this->RequestHandler->respondAs($format);		
			$this->viewPath .= '/'.$format;
			$this->layoutPath = $format;	
			$this->layout= $format;
		}
		
		//controller method for the protocole struct service
		function proto_get(){
			//xdebug_start_code_coverage();
			$debug="";
			$find=1;
			$test=false;	
			$this->loadModel('AppModel');	
			$this->loadModel('Protocole');			
			
			if(isset($this->params['url']['proto_name']) || isset($this->params['url']['id_proto']) || isset($this->request->params['id_proto'])){ 
				$table_name="";
				$id_proto="";
				$pk_id_name="";
				$model_list_proto = $this->Protocole;//new AppModel("TProtocole","TProtocole",basep);
				
				foreach ($model_list_proto->schema() as $key=>$val){
					if($key=="TTheEt_PK_ID"){
						$pk_id_name="TTheEt_PK_ID";
					}
					if($key=="ttheEt_PK_ID"){
						$pk_id_name="ttheEt_PK_ID";
					}	
							
				}
				
				//get id from the name of the protocole
				if(isset($this->params['url']['proto_name'])){
					$table_name = $this->params['url']['proto_name'];	
					$name=str_replace("TProtocol_","",$table_name);
					$id_proto_array=$model_list_proto->find('first',array("conditions" => array("Relation"=>$name)));
					if(isset($id_proto_array['AppModel']["TTheEt_PK_ID"]))
						$id_proto=$id_proto_array['AppModel']["TTheEt_PK_ID"];
					else if(isset($id_proto_array['AppModel']["ttheEt_PK_ID"])){
						$id_proto=$id_proto_array['AppModel']["ttheEt_PK_ID"];	
					}	
				}	
				
				//get id from param
				if(isset($this->params['url']['id_proto'])){
					$id_proto=$this->params['url']['id_proto'];						
				}

				//get id from request param (case with this kind of url : proto/get/"id")
				if(isset($this->request->params['id_proto'])){
					$id_proto= $this->request->params['id_proto'];
				}	
				
				if($id_proto!=""){					
					$table_name_array=$model_list_proto->find('first',array("conditions" => array($pk_id_name=>$id_proto)));
					if(isset($table_name_array['Protocole']['Relation']))
						$table_name="TProtocol_".$table_name_array['Protocole']['Relation'];					
					else{
						$find=-1;
						$this->set('find',-1);
					}					
				}
				
				if($find!=-1){	
					//description view that contain the field type (if list contain also items)
					//$desc_query="SELECT t,c,cd,td From V_Qry_Column_Descr where t='dbo.$table_name'";
					
					
						//$desc_proto = new AppModel("V_Qry_Column_Descr","V_Qry_Column_Descr",basep);
						$desc=$this->get_description_col($table_name);
						
						//$desc=$this->simply_table($desc_proto->query($desc_query));
						//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
						//fwrite($fp, print_r($desc,true));
						$this->set('desc',$desc);					
						/*if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
							$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
							fwrite($fp, "mockres\n".print_r($desc ,true));
						}*/
					//		
					//create model from protocol and get table descr on the view for keyword protocol	
					try{					
						//$model_proto = new AppModel($table_name,$table_name,basep);
						$this->AppModel->setSource($table_name);
						$model_proto=$this->AppModel;
						/*if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
							$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
							fwrite($fp, print_r($desc ,true));
						}	*/
						$this->set('find',1); //table find
						//just for take one column name
						$keycolarr=array_keys($model_proto->schema());
						$keycol=$keycolarr[0];						
						$table_desc= $desc[$keycol]['td'];
						$this->set("table_desc",$table_desc);
						$this->set('model',$model_proto);
					}
					catch(Exception $e){
						$this->set('find',-1); //table not find
					}
										
					
					$this->set('nom',$table_name);
					$this->set('id_proto',$id_proto);
				}				
			}
			else{
				$this->set('nom',"");
				$this->set('find',0);
			}		
			
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layoutPath = 'xml';
			$this->layout = 'xml';
			//var_dump(xdebug_get_code_coverage());
		}
		
		//method that return description of column of a table
		function get_description_col($table_name){
			$desc_query= "SELECT [table] as t,  [column] as c, CONVERT(nchar(40),column_desc)as cd, CONVERT(nchar(40),table_desc)as td
				FROM (SELECT     u.name + '.' + t.name AS [table], td.value AS table_desc, c.name AS [column], cd.value AS column_desc
					FROM          sys.sysobjects AS t INNER JOIN
								  sys.sysusers AS u ON u.uid = t.uid LEFT OUTER JOIN
								  sys.extended_properties AS td ON td.major_id = t.id AND td.minor_id = 0 AND td.name = 'MS_Description' INNER JOIN
								  sys.syscolumns AS c ON c.id = t.id LEFT OUTER JOIN
								  sys.extended_properties AS cd ON cd.major_id = c.id AND cd.minor_id = c.colid AND cd.name = 'MS_Description'
					WHERE      (t.type = 'u')) AS derivedtbl_1 where  [table]='dbo.$table_name'";
		
			$desc_proto=new AppModel("TProtocole","TProtocole");
			$desc=$this->simply_table($desc_proto->query($desc_query));
			return $desc;
		}
		
		//column value list from a table webservice
		function column_list(){
			if(!$this->notauth){	
				$table_name="";
				$column_name="";
				$array_conditions=array();
				$total="";
				$format="json";
				$offset=0;
				$limit=0;
				$find=1;

				if(isset($this->params['url']['table_name'])){
					$table_name=$this->params['url']['table_name'];
				}

				if(isset($this->request->params['table_name'])){
					$table_name=$this->request->params['table_name'];
				}

				if(isset($this->params['url']['column_name'])){
					$column_name=$this->params['url']['column_name'];
				}

				if(isset($this->request->params['column_name'])){
					$column_name=$this->request->params['column_name'];
				}

				$column_name2="";
				if(isset($this->params['url']['column_name2'])){
					$column_name2=$this->params['url']['column_name2'];
				}

				if(isset($this->request->params['column_name2'])){
					$column_name2=$this->request->params['column_name2'];
				}			

				if(isset($this->params['url']['limit'])){
					$limit=$this->params['url']['limit'];
				}

				if(isset($this->params['url']['offset'])){
					$offset=$this->params['url']['offset'];
				}

				//format from request
					
				if(stripos($this->request->header('Accept'),"application/xml")!==false){
					$format="xml"; 
				}
				else if(stripos($this->request->header('Accept'),"application/json")!==false){
					$format="json";
				}
				//format from param
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
						/*$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
						fwrite($fp, print_r("$format" ,true));*/
					}
					if(stripos($this->params['url']['format'],"xml")!== false )
						$format="xml";
					else if(stripos($this->params['url']['format'],"json")!== false)	
						$format="json";
					else if(stripos($this->params['url']['format'],"test")!== false)	
						$format="test";	
				}			

				$fields=array();
				if(isset($this->params['url']['fields']) && $this->params['url']['fields']!=""){
					$fields=split(",",$this->params['url']['fields']);
				}

				if(isset($this->request->params['fields']) && $this->request->params['fields']!=""){
					$fields=split(",",$this->request->params['fields']);
				}

				$join_column=array();
				if(isset($this->params['url']['join_column']) && $this->params['url']['join_column']!=""){
					$join_column=split(",",$this->params['url']['join_column']);
				}

				if(isset($this->request->params['join_column']) && $this->request->params['join_column']!=""){
					$join_column=split(",",$this->request->params['join_column']);
				}

				$table_join="";
				if(isset($this->params['url']['table_join']) && $this->params['url']['table_join']!=""){
					$table_join=$this->params['url']['table_join'];
				}

				if(isset($this->request->params['table_join']) && $this->request->params['table_join']!=""){
					$table_join=$this->request->params['table_join'];
				}

				$pk_join="";
				if(isset($this->params['url']['pk']) && $this->params['url']['pk']!=""){
					$pk_join=$this->params['url']['pk'];
				}

				if(isset($this->request->params['pk']) && $this->request->params['pk']!=""){
					$pk_join=$this->request->params['pk'];
				}

				$fk_join="";
				if(isset($this->params['url']['fk']) && $this->params['url']['fk']!=""){
					$fk_join=$this->params['url']['fk'];
				}

				if(isset($this->request->params['fk']) && $this->request->params['fk']!=""){
					$fk_join=$this->request->params['fk'];
				}

				$options=array();
				if($table_join!="" && $join_column!=""){
					$options['joins'] = array(
						array('table' => $table_join,
							'alias' => $table_join.'Join',
							'type' => 'INNER',
							'conditions' => array(
								"$fk_join = $pk_join"
							)
						)
					);
				}

				if($column_name!="" && $table_name!=""){
					$field_array=array($column_name);
					if($table_name=="TTaxa_name"){
						//$field_array=array("ID_NAME",$column_name,"FK_Taxon");
						$field_array=array($column_name);
					}
					
					if(isset($this->params['url']['filter'])){
						$filter=str_replace(" ","% ",$this->params['url']['filter'])."%";
						/*if($column_name2!="")
							$array_conditions += array(array("or",array("$column_name LIKE"=>$filter,"$column_name2 LIKE"=>$filter)));
						else*/	
							$array_conditions += array("$column_name LIKE"=>$filter);
					}				

					$model=new Value($table_name,$table_name,"mycoflore");
					$count=false;
					//check if it's a count request
					if(isset($this->params['url']['count']) && $this->params['url']['count']!=""){
						$count=true;
					}
					
					if(isset($this->request->params['count']))
						$count=true;
					
					if(count($fields)!=0){
						$field_array=$fields;
					}
					if(count($fields)>1 && ($table_name=="TTaxa_name" || $table_name=="TTaxa")){
						$rankname="RANK";
						if($table_name=="TTaxa_name")
							$rankname="TTaxaJoin.RANK";
						$array_conditions[]=array("($rankname = 'ES' or $rankname  = 'SSES' or $rankname  = 'VAR' or $rankname  = 'FO' or $rankname  = 'SSFO')");
					}
					if($count){
						
					}				
					else if($table_name=="TTaxa_name"){
						//$limit=10;
						$this->loadModel('TaxonName');
						if(count($fields)!=0 && count($join_column)!=0){
							$field_array=array_merge($fields,$join_column);
							
						}
						$model_result=$this->TaxonName->find("all",array(
										'fields'=>$field_array,
										'order'=>"$column_name asc",
										'group'=>$field_array,
										'conditions'=>$array_conditions,
										'limit'=>$limit,
										'offset'=>intval($offset)
										)+$options);
						$nb="";		
						//$dbo = $this->TaxonName->getDatasource();
						//$logs = $dbo->getLog();
						//$lastLog = end($logs['log']);
						//print_r($lastLog);
						/*if(count($fields)!=0 && count($join_column)!=0){
							$dbo = $this->TaxonName->getDatasource();
							$logs = $dbo->getLog();
							$lastLog = end($logs['log']);
							print_r(" table ");
							print_r($lastLog);
							
						}	*/										
						/*$nb=$this->TaxonName->find("count",array(
										'fields'=>$field_array,
										'group'=>$field_array,
										'conditions'=>$array_conditions)
										);	*/		
						
					}
					else{				
						$model_result=$model->find("all",array(
										'fields'=>$field_array+$fields,
										'order'=>"$column_name asc",
										'group'=>$field_array,
										'conditions'=>$array_conditions,
										'limit'=>$limit,
										'offset'=>intval($offset))+$options
										);
						
						$nb=$model->find("count",array(
										'fields'=>$field_array,
										'group'=>$field_array,
										'conditions'=>$array_conditions)+$options
										);	
					}	
					
					/*
					$total=$model->find("count",array(
									'fields'=>array($column_name),
									'group'=>array($column_name))								
									);		*/
									
					//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
					//fwrite($fp, print_r($model_result,true));				
					$this->set("find",$find);
					$this->set("nb",$nb);
					$this->set("total",$total);
					$this->set("table_name",$table_name);
					$this->set("column_name",$column_name);
					$this->set("result",$model_result);				
				}
				else{
					$this->set("find",-1);
					if($column_name=="" && $table_name==""){
						$this->set("message","Column name and table name parameter missing");					
					}
					else if($table_name==""){
						$this->set("message","table name parameter missing");					
					}
					else if($column_name==""){
						$this->set("message","Column name parameter missing");					
					}
				}
								
				// Set response as XML
				$this->RequestHandler->respondAs($format);
				$this->viewPath .= "/".$format;
				$this->layoutPath =$format;
				$this->layout = $format;
				if(($table_name=="TTaxa_name" && $column_name=="NAME_WITHOUT_AUTHORITY") || ($table_name=="TTaxa" && $column_name=="NAME_VERN_FR")){
					$this->set("verna",false);	
					if(count($fields)>1)
							$this->set("table",true);
					//print_r("ici");
					if($table_name=="TTaxa" && $column_name=="NAME_VERN_FR"){
						$this->set("verna",true);
						
					}	
					$this->render('taxon_name_list');		
				}		
			}
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');	
			}	
		}
		
		//taxon get webservice
		function taxon_get(){
			if(!$this->notauth){
				$model_taxon = new AppModel("TTaxa","TTaxa","mycoflore");
				$condition_array=array();
				$KINGDOM="";
				$NAME_VALID="";
				$NAME_WITHOUT_AUTHORITY="";
				$NAME_WITH_AUTHORITY="";
				$id_taxon="";
				$ID_NAME="";
				$ID_HIGHER_TAXON="";
				$AUTHORITY="";
				$NOM_VERN_FR="";
				$NOM_VERN_ENG="";
				$PHYLUM="";
				$CLASS="";
				$ORDER="";
				$FAMILY="";
				$RANK="";
				$TAXREF_CD_NOM="";
				$TAXREF_CD_TAXSUP="";
				$TAXREF_CD_REF="";
				$join=array();
				$format="json";
				$this->loadModel('Taxon');
				$limit=0;
				$offset=0;
				
				//get id from param
				if(isset($this->params['url']['id_taxon'])){
					$id_taxon=$this->params['url']['id_taxon'];						
				}
				
				//format from request
					
				if(stripos($this->request->header('Accept'),"application/xml")!==false){
					$format="xml"; 
				}
				else if(stripos($this->request->header('Accept'),"application/json")!==false){
					$format="json";
				}
				
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if(stripos($this->params['url']['format'],"xml")!== false )
						$format="xml";
					else if(stripos($this->params['url']['format'],"json")!== false)	
						$format="json";
					else if(stripos($this->params['url']['format'],"test")!== false)	
						$format="test";	
				}
				
				if(isset($this->params['url']['limit'])){
					$limit=$this->params['url']['limit'];
				}
				
				if(isset($this->params['url']['offset'])){
					$offset=$this->params['url']['offset'];
				}
				
				//get id from request param (case with this kind of url : proto/get/"id")
				if(isset($this->request->params['id_taxon']) && $this->request->params['id_taxon']!="[0-9]+"){
					$id_taxon= $this->request->params['id_taxon'];
				}

				//get kingdom param
				if(isset($this->params['url']['KINGDOM'])){
					$KINGDOM= $this->params['url']['KINGDOM'];
				}	
				
				//get name_valid param
				if(isset($this->params['url']['NAME_VALID'])){
					$NAME_VALID= $this->params['url']['NAME_VALID'];
				}
				
				//get name_id param
				if(isset($this->params['url']['ID_NAME'])){
					$ID_NAME= $this->params['url']['ID_NAME'];
				}
				
				//get name_without_authority param
				if(isset($this->params['url']['NAME_WITHOUT_AUTHORITY'])){
					$NAME_WITHOUT_AUTHORITY= $this->params['url']['Name_without_Authority'];
				}
				
				//get ID_HIGHER_TAXON param
				if(isset($this->params['url']['ID_HIGHER_TAXON'])){
					$ID_HIGHER_TAXON= $this->params['url']['ID_HIGHER_TAXON'];
				}
				
				//get NOM_VERN_FR param
				if(isset($this->params['url']['NOM_VERN_FR'])){
					$NOM_VERN_FR= $this->params['url']['NOM_VERN_FR'];
				}
							
				//get AUTHORITY param
				if(isset($this->params['url']['AUTHORITY'])){
					$AUTHORITY= $this->params['url']['AUTHORITY'];
				}
				
				//get NOM_VERN_ENG param
				if(isset($this->params['url']['NOM_VERN_ENG'])){
					$NOM_VERN_ENG= $this->params['url']['NOM_VERN_ENG'];
				}
				
				//get PHYLUM param
				if(isset($this->params['url']['PHYLUM'])){
					$PHYLUM= $this->params['url']['PHYLUM'];
				}
				
				//get CLASS param
				if(isset($this->params['url']['CLASS'])){
					$CLASS= $this->params['url']['CLASS'];
				}
				
				//get ORDER param
				if(isset($this->params['url']['ORDER'])){
					$ORDER= $this->params['url']['ORDER'];
				}
				
				//get FAMILY param
				if(isset($this->params['url']['FAMILY'])){
					$FAMILY= $this->params['url']['FAMILY'];
				}
				
				//get RANK param
				if(isset($this->params['url']['RANK'])){
					$RANK= $this->params['url']['RANK'];
				}
				
				//get TAXREF_CD_NOM param
				if(isset($this->params['url']['TAXREF_CD_NOM'])){
					$TAXREF_CD_NOM= $this->params['url']['TAXREF_CD_NOM'];
				}
				
				//get TAXREF_CD_NOM param
				if(isset($this->params['url']['TAXREF_CD_TAXSUP'])){
					$TAXREF_CD_TAXSUP= $this->params['url']['TAXREF_CD_TAXSUP'];
				}
				
				//get TAXREF_CD_REF param
				if(isset($this->params['url']['TAXREF_CD_REF'])){
					$TAXREF_CD_REF= $this->params['url']['TAXREF_CD_REF'];
				}
				
				$array_conditions=$model_taxon->taxon_filter($condition_array,$id_taxon,$ID_HIGHER_TAXON,$ID_NAME
				,$NAME_WITH_AUTHORITY,$AUTHORITY,$NAME_WITHOUT_AUTHORITY,$NAME_VALID,$NOM_VERN_FR,$NOM_VERN_ENG,$NOM_VERN_FR
				,$KINGDOM,$PHYLUM,$CLASS,$ORDER,$FAMILY,$RANK,$TAXREF_CD_NOM,$TAXREF_CD_TAXSUP,$TAXREF_CD_REF
				,true);
				
				//$this->Taxon->hasMany['Synonymous']['conditions']['Synonymous.']=2;
				
				$hierarchie=$this->Taxon->query("EXECUTE sp_hierarchie $id_taxon");
				
				$taxons=$this->Taxon->find("all",array(
					'contain' => array(
						'Synonymous'=> array(
							'conditions'=> array('Synonymous.FK_Taxon'=>'17286')
						)
					),
					'fields'=>array(),
					'conditions'=>$array_conditions,
					'order'=>array("NAME_VALID_WITHOUT_AUTHORITY asc"),
					'limit'=>$limit,
					'offset'=>intval($offset)
					
				));
				
				$nb_taxons="";
				/*$nb_taxons=$this->Taxon->find("count",array(
					'conditions'=>$array_conditions,
					'limit'=>$limit,
					'offset'=>intval($offset)
				));*/
				
							
				if(!($taxons && (count($taxons)>0)))
					$taxons=array();
				else{
					$taxons['hierarchie']=$hierarchie;
				}
				if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
					$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
					fwrite($fp, print_r($taxons ,true));
				}
				
				$this->set("taxons",$taxons);
				$this->set("nb",$nb_taxons);
				
				if($format!="test"){
					//$this->RequestHandler->setContent('json', 'text/x-json');
					// Set response as XML
					$this->RequestHandler->respondAs($format);
					$this->viewPath .= "/".$format;
					$this->layoutPath = $format;
					$this->layout=$format;
				}	
				else{
					// Set response as XML
					$this->RequestHandler->respondAs("html");
					$this->viewPath .= "/"."json";
					//$this->layoutPath = $format;
					//$this->layout=$format;
				}
			}
			else{
				$this->RequestHandler->respondAs('json');
				$this->viewPath .= '/json';
				$this->layout= 'json';
				$this->layoutPath = 'json';	
				$this->render('not_autorized');	
			}		
		}
		
		//
		function taxon_count(){
			$format='json';
			$this->loadModel('TaxonFamilyCount');
			$find_field=false;
			$field="";
			
			if(isset($this->params['url']['field']) && $this->params['url']['field']!=""){
				$field= $this->params['url']['field'];
			}
			if($field!="")
				foreach ($this->TaxonFamilyCount->schema() as $key=>$val){
					//check if the field exist with insensitive case
					if(stripos($key,$field)!==false){
						$field=$key;
						$find_field=true;
						break;
					}											
				}
			
			$options['joins'] = array(
				array('table' => 'TProtocol_Inventory',
					'alias' => 'TProtocol_Inventory',
					'type' => 'INNER',
					'conditions' => array(
						"TaxonFamilyCount.ID_TAXON = TProtocol_Inventory.Id_Taxon"
					)
				)
			);	
					
			if($find_field){
				$familycount=$this->TaxonFamilyCount->find('all',array(
					'fields'=>array("$field",'COUNT(*) as nb'),
					'group'=>"[$field]"
				)+$options);
				if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
					$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');			
					fwrite($fp, print_r($familycount ,true));
				}							
				$this->set('result',$familycount);			
			}
			else
				$this->set('result',"Nom de champs manquant ou mal ecrit. param: field='nom_champ'");
			$this->set('field',$field);	
			if($format!="test"){
				//$this->RequestHandler->setContent('json', 'text/x-json');
				// Set response as XML
				$this->RequestHandler->respondAs($format);
				$this->viewPath .= "/".$format;
				$this->layoutPath = $format;
				$this->layout=$format;
			}	
			else{
				// Set response as XML
				$this->RequestHandler->respondAs("html");
				$this->viewPath .= "/"."json";
				//$this->layoutPath = $format;
				//$this->layout=$format;
			}
		}
		
		//create a simplified table of this return by find->query
		function simply_table($table){
			$sTable = array();
			//$this->filedebug(print_r($table,true));
			for($i=0;$i<sizeof($table);$i++){
				$j=0;
				foreach($table[$i][0] as $key=>$val){
					if($j!=0){	
						if($j==1){	
							$tablename=$val;
							$sTable+=array($tablename=>array());
						}
						else
							$sTable[$tablename]+=array($key=>$val);
					}					
					$j++;
				}				
			}
			return $sTable;
		}	
		
		//for a possible insertion of value
		function insert_value($model,$data){
			$this->loadModel($model);
			/*$this->$model->save(Array
			(
				[$modele] => Array
				(
					[nomduchamp1] => 'valeur'
					[nomduchamp2] => 'valeur'
				)
			));*/
			
			/*
				$this->Post->set('title', 'Nouveau titre pour l\'article');
				$this->Post->save();
			*/
		}
		
		//for a possible table creation
		function proto_create(){
			/*$query = "CREATE TABLE customer 
						  (First_Name char(50), 
						  Last_Name char(50), 
						  Address char(50) default 'Unknown', 
						  City char(50) default 'Mumbai', 
						  Country char(25), 
						  Birth_Date date)";*/
			//$query = "Drop TABLE customer";			  
			$db = ConnectionManager::getDataSource(basep);
			
			if($db->rawQuery($query))
				$this->set("query_result","true");
			else
				$this->set("query_result","false");
			// Set response as XML
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layoutPath = 'xml';
		}
		
		
	}
?>