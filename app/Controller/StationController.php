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
	
	define("base", "narc_ereleve"); //name of database use
	define("limit",100);  //sql limit default value
	define("offset",0); //sql offset default value
	define("cache_time",3600);
	
	class StationController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler','Cookie','Session');
		var $typereturn;
		public $notauth=false;		
		public $admin=false;
		public $cacheAction = array(  //set the method(webservice) with a cached result
			//'proto_list' => cache_time,
			//'station_get' => cache_time,  
			//'proto_taxon_get' => cache_time,
			//'proto_get' => cache_time
		);
		
		public function beforeFilter() {
			ini_set ("max_input_time","300");
			ini_set ("memory_limit","2280M");
			//ini_set ("memory_limit",-1);
			ini_set ("max_execution_time","300");
			$this->Cookie->name = 'session';
			$this->Cookie->key = 'q45678SI232qs*&sXOw!adre@34SAdejfjhv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
			$this->Cookie->httpOnly = true;
			parent::beforeFilter();
			if((!$this->Cookie->read('connected') /* || !$this->Session->read('role')*/) && ($this->params['action']=='station_get2' || $this->params['action']=='import_csv' ||
			$this->params['action']=='column_list')){
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
			$Distinct=array();
			$ModelName="AppModel"; //for the array returned by find
			$totaldisplay=0;
			$areautocomplete=false;
			$localityautocomplete=false;
			
			
			if(isset($this->params['url']['to_carto']) && $this->params['url']['to_carto']!=""){
				if($this->params['url']['to_carto']=="yes"){
					$find=2;
				}
			}
			
			$test=0;
			$base=base;
			
			$currentdate=null;
			if(isset($this->params['url']['currentdate']) && $this->params['url']['currentdate']!=""){
				$currentdate=$this->params['url']['currentdate'];
			}			
			
			//if protocole filter join to station
			if(isset($this->params['url']['id_proto']) && $this->params['url']['id_proto']!=""){
				$Distinct= array();
				$id_proto=$this->params['url']['id_proto'];
				$model_list_proto = new AppModel("TProtocole","TProtocole");
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
				$model_proto = new AppModel('TStation',$table_name);
				$this->set("Model",$model_proto);
				//array that contain the column return
				$column_array = array($Stationjoinstringnamedot."TSta_PK_ID as ID",$Stationjoinstringnamedot."FieldActivity_Name as [FieldActivity Name]"
				,$Stationjoinstringnamedot."Name as Name",$Stationjoinstringnamedot."DATE as DATE",$Stationjoinstringnamedot."Area as Area",$Stationjoinstringnamedot."Locality as Locality"
				,$Stationjoinstringnamedot."LAT as LAT",$Stationjoinstringnamedot."LON as LON");
				$column_arraygroup=array("TSta_PK_ID","FieldActivity_Name","Name","DATE","Area","Locality","LAT","LON");
				//label case
				$value_label_array=array();
				foreach($column_array as $f){
					$f_split=explode(" as ",$f);					
					if(count($f_split)>1){
						$value_label_array=array_merge($value_label_array,array(trim($f_split[1])=>trim($f_split[0])));
					}
				}
				
				$condition_array = array('LAT IS NOT NULL','LON IS NOT NULL');
				$limit=limit;
				$offset=offset;
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
				
				if(isset($this->params['url']['filters']) && count($this->params['url']['filters'])>0){
					$filters=$this->params['url']['filters'];
					//$condition_array[];
					foreach($filters as $f){						
						if($f){
							list($col,$val)=split(":",$f,2);
							if(isset($value_label_array[trim($col)]))
								$col=$value_label_array[$col];
							if(strpos($col,'DATE')!==false){
								
								//equal date search with DATE:[DATE]
								if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val)){
									$condition_array[]=array("CONVERT(char(10),[DATE],126)='$val'");
								}
								//search with real date format		
								else if(strpos($val, ":")!==false){
									list($typedatesearch,$date)=split(":",$val,2);
									//equal date search with DATE:exact:[DATE]
									if($typedatesearch=="exact"){
										if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
											$condition_array[]=array("CONVERT(char(10),[DATE],126)='$date'");
										}	
									}
									//before date search with DATE:before:[DATE]
									else if($typedatesearch=="before"){
										if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
											$condition_array[]=array("CONVERT(char(10),[DATE],126)<'$date'");
										}	
									}
									//after date search with DATE:after:[DATE]
									else if($typedatesearch=="after"){
										if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
											$condition_array[]=array("CONVERT(char(10),[DATE],126)>'$date'");
										}	
									}
								}
								//search with known predefined date
								else{
									$m=date("m");
									$d=date("d");
									$y=date("Y");
									//if($currentdate)
										//list($y,$m,$d)=explode("-",$currentdate);	
									
									if($val=="today"){
										$today = date("Y-m-d",mktime(0,0,0,$m,$d,$y));
										$condition_array[]=array("CONVERT(char(10),[DATE],126)='$today'");
									}
									else if($val=="yesterday"){
										$yesterday = date("Y-m-d",mktime(0,0,0,$m,$d-1,$y));
										$condition_array[]=array("CONVERT(char(10),[DATE],126)='$yesterday'");
									}
									else if($val=="lastweek"){
										$lastweek=date("Y-m-d",mktime(0,0,0,$m,$d-7,$y));
										$weekreq="CONVERT(char(10),DATE,120) >= CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, cast('$lastweek' as date))/7, 0), 120) and
					CONVERT(char(10),DATE,120) <= CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, cast('$lastweek' as date))/7, 6),120)";
										$condition_array[]=array($weekreq);
									}
									else if($val=="lastmonth"){
										$lastmonth = date("Y-m",mktime(0,0,0,$m-1,$d,$y));
										$condition_array[]=array("CONVERT(char(7), DATE, 120)='$lastmonth'");
									}
									else if($val=="lastyear"){
										$lastyear = date("Y",mktime(0,0,0,$m,$d,$y-1));
										$condition_array[]=array("CONVERT(char(4), DATE, 120)='$lastyear'");
									}
								}	
							}
							else {
								//No date search
								if(strpos($val, ":")!==false){
									list($typesearch,$search)=split(":",$val,2);
									//exact search
									if($typesearch=="exact"){
										$condition_array+=array($col=>$search);
									}
									//begin search
									else if($typesearch=="begin"){
										$condition_array+=array($col.' like'=>$search.'%');
									}
									//end search
									else if($typesearch=="end"){
										$condition_array+=array($col.' like'=>'%'.$search);
									}
									//contain search
									else if($typesearch=="contain"){
										$condition_array+=array($col.' like'=>'%'.$search.'%');
									}
								}
								else{
									$condition_array+=array($col.' like'=>$val.'%');
								}	
							}	
						}
					}
					
				}				
				
				//take limit paramater for a limit filter
				if(isset($this->params['url']['iDisplayLength']) && $this->params['url']['iDisplayLength']!=""){
					$limit=intval($this->params['url']['iDisplayLength']);
				}
				if(isset($this->params['url']['limit']) && $this->params['url']['limit']!=""){
					$limit=intval($this->params['url']['limit']);
				}
				
				//take offset parameter for a offset filter
				if(isset($this->params['url']['iDisplayStart']) && $this->params['url']['iDisplayStart']!=""){
					$offset=intval($this->params['url']['iDisplayStart']);	
				}
				
				if(isset($this->params['url']['offset']) && $this->params['url']['offset']!=""){
					$offset=intval($this->params['url']['offset']);
				}
				
				if(isset($this->params['url']['skip']) && $this->params['url']['skip']!=""){
					$offset=intval($this->params['url']['skip']);
				}
				//take sEcho parameter (param for the datable js)
				if(isset($this->params['url']['sEcho'])){
					$sEcho=$this->params['url']['sEcho'];	
				}		
				
				
				$firstcsplit=explode(" as ",$column_array[0]);
				if(isset($firstcsplit[1]) && isset($value_label_array[trim($firstcsplit[1])]))
					$sort_column=$value_label_array[trim($firstcsplit[1])];
				else 
					$sort_column=$column_array[0];
					
				$sort_dir="asc";
				
				//column sort
				if(isset($this->params['url']['iSortCol_0']) &&  $this->params['url']['sSortDir_0']){
					$index_col=intval($this->params['url']['iSortCol_0']);
					$sort_dir= $this->params['url']['sSortDir_0'];
					
					if(isset($value_label_array[$this->params['url']['sortColumn']]))
						$sort_column=$value_label_array[$column_array[$index_col]];
					else
						$sort_column=$column_array[$index_col];
				}
				
				if(isset($this->params['url']['sortColumn']) &&  $this->params['url']['sortColumn']!=""){
				
					if(isset($this->params['url']['sortOrder']) && $this->params['url']['sortOrder']!="")
						$sort_dir= $this->params['url']['sortOrder'];
					
					if(isset($value_label_array[$this->params['url']['sortColumn']]))
						$sort_column=$value_label_array[$this->params['url']['sortColumn']];
					else	
						$sort_column=$this->params['url']['sortColumn'];
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
				
				if(isset($this->request->params['localityautocomplete']) && $this->request->params['localityautocomplete']!=""){
					$localityautocomplete=true;					
				}	
				
				if(isset($this->request->params['areautocomplete']) && $this->request->params['areautocomplete']!=""){
					$areautocomplete=true;					
				}	
				
				$count=false;
				if(isset($this->request->params['count']))
					$count=true;
				
				//not count
				if(!$count){
					//create condition array for the sql request
					$condition_array=$model_proto->filter_create($condition_array,$place,$region,$date,"","","",$search,$tsearch,"",true,$currentdate);				
					//print_r($condition_array);
					//find station with the right parameter without search				
					;
					if(!$areautocomplete && !$localityautocomplete){
						$station = $model_proto->find("all",array('recursive' => 0
																,'limit'=>$limit
																,'offset'=>$offset
																,'fields'=>$column_array
																,'order'=> array("$sort_column $sort_dir")
																,'conditions'=>$condition_array
																,'group'=>$column_arraygroup)+$Stationjoin
														);
						
						if($station){
							$totaldisplay = $model_proto->find("count",array('recursive' => 0
																,'fields'=>$column_array
																,'conditions'=>$condition_array
																,'group'=>$column_arraygroup)+$Stationjoin
														);	
														
						}								
						else 
							$totaldisplay=0;
					}
					else if($areautocomplete){
						$station = $model_proto->find("all",array('recursive' => 0
																,'fields'=>array('TStationsJoin.Area')
																,'order'=> array("TStationsJoin.Area asc")
																,'conditions'=>$condition_array
																,'group'=>array('TStationsJoin.Area'))+$Stationjoin
																
														);
						$this->set("result",$station);								
					}
					else if($localityautocomplete){
						$station = $model_proto->find("all",array('recursive' => 0
								,'fields'=>array('TStationsJoin.Locality')
								,'order'=> array("TStationsJoin.Locality asc")
								,'conditions'=>$condition_array
								,'group'=>array('TStationsJoin.Locality'))+$Stationjoin								
						);
						$this->set("result",$station);	
					}	
					$this->set("table",$station);
					$this->set("schema",$column_array);
					$this->set("total",$total);
					$this->set("totaldisplay",$totaldisplay);	
				}
				//count
				else{					
					$condition_array=$model_proto->filter_create($condition_array,$place,$region,$date,"","","",$search,$tsearch,"",true,$currentdate);
					//print_r($condition_array);
					$totaldisplay = $model_proto->find("count",array('recursive' => 0
															,'conditions'=>$condition_array)+$Stationjoin
													);
					$this->set("nb",$totaldisplay);	
					$find=2;								
				}
			}
			else
				$find=-1;
			
			if(isset($this->params['url']['format']) && $this->params['url']['format']=="geojson" && !$count && !$areautocomplete && !$localityautocomplete){
				$zoom=0;
				if(isset($this->params['url']['zoom'])){
					$zoom=$this->params['url']['zoom'];
				}
				$cluster='no';
				$minlat=1000;
				$minlon=1000;
				$maxlat=-1000;
				$maxlon=-1000;
				
				//bbox creation
				foreach($station as $s){
					$thislat=$s[0]['LAT'];
					$thislon=$s[0]['LON'];
					if($thislat>$maxlat)
						$maxlat=$thislat;
					else if($thislon>$maxlon)
						$maxlon=$thislon;
					else if($thislat<$minlat)
						$minlat=$thislat;
					else if($thislon<$minlon)
						$minlon=$thislon;			
				}
				$this->set('maxlat',$maxlat);
				$this->set('maxlon',$maxlon);
				$this->set('minlat',$minlat);
				$this->set('minlon',$minlon);
				if(isset($this->params['url']['cluster']) && $this->params['url']['cluster']=='yes')
					$cluster='yes';				
					
					if($cluster=="yes"){
						$cartomodel=new CartoModel();
						$station=$cartomodel->cluster($station,20,$zoom);
						$this->set("table",$station);
					}
					
				$this->viewPath .= '/geojson';
			}
			else
				$this->viewPath .= '/json';	
			//$this->filedebug($totaldisplay);	
			$this->set("find",$find);			
			$this->set("sEcho",$sEcho);			
			$this->set("ModelName",$ModelName);
			$this->set("debug",$debug); 
			//print_r($condition_array);
			// $this->RequestHandler->respondAs('html');
			$this->RequestHandler->respondAs('json');
			$this->layoutPath = 'json';	
			$this->layout = 'json';	
			if($areautocomplete || $localityautocomplete){
				$this->render('autocomplete');
			}	
		}
		
		function station_get2(){
			if(true/*!$this->notauth*/){
				$format="json";
				$id_proto="";
				$tsearch="";
				$locality="";
				$area="";
				$fa="";
				$name="";
				$condition_array=array();
				$db="default";
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
				 
				
				if((isset($this->params['url']['format']) && $this->params['url']['format']!="") || isset($this->request->params['format'])){
					if(isset($this->request->params['format']))
						$tmp_format=$this->request->params['format'];
					else
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
				$count=false;
				if(isset($this->request->params['count']))
					$count=true;
				
				if(!$count){				
					$result=$this->Station->find('all',array(
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
				}
				else{
					$result=$this->Station->find('count',array(
						'conditions'=>$condition_array					
					)+$options);
					$this->set("find",2);
					$this->set("result",$result);
				}		
				
							
				
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
				$viewpath='/text';
				$find=1;
				$res=array();
				$user=$this->Session->read('user');
				$iduser=$user['User']['TUse_Pk_ID'];
				
				if(isset($this->params['url']['format']) && $this->params['url']['format']!=""){
					if($this->params['url']['format']=='json')
						$viewpath='/json';
				}
				
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
				$this->viewPath .= "$viewpath";				
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

		function number_by_month(){
			$this->loadModel('Station');
			//$this->Station->useDbConfig = 'ereleve';
			$find=1;
			$date="";
			if(isset($this->params['url']['date']) && $this->params['url']['date']!=""){
				$date=$this->params['url']['date'];
				if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)){
					$find=-1;
				}
			}
			if($find==1){
				$fields=array();
				$conditions=array();
				$y=date('Y');
				$m=date('m');
				$d=1;
				if($date!="")
					list($y,$m,$d2)=split("-",$date);
				
				//$last12month=$this->last12month($y,$m,$d);
				$mkmonthlast = mktime(0, 0, 0, $m-11, 1, $y);
				$datemonthlast = date("Y-m-d",$mkmonthlast);
				$mkmonthfirst = mktime(0, 0, 0, $m, 31, $y);
				$datemonthfirst = date("Y-m-d",$mkmonthfirst);
				$nbbym=array();
				$monthyear=array();
				for($i=0;$i<12;$i++){
					$month12 = date("F",mktime(0, 0, 0, $m-$i, 1, $y))." ".date("Y",mktime(0, 0, 0, $m-$i, 1, $y));
					$nbbym+=array($month12=>null);
					$monthyear+=array(date("F",mktime(0, 0, 0, $m-$i, 1, $y)) => date("Y",mktime(0, 0, 0, $m-$i, 1, $y)));
					//print_r($nbbym);
				}
				//print_r(date("F",mktime(0, 0, 0, 01, 1, $y)));
				
				$query="Select count(*) as nb,CONVERT(CHAR(4), DATE, 100) as month,month(DATE) as nummonth FROM      TStations 
				WHERE CONVERT(varchar(255), DATE, 21) <= '$datemonthfirst' and 
				CONVERT(varchar(255), DATE, 21) >= '$datemonthlast'
				GROUP BY  month(DATE),CONVERT(CHAR(4), DATE, 100)";
				
				//print_r($query);
				/*foreach($last12month as $month=>$date){
					$begin=$this->begin_month($date);
					$end=$this->end_month($date);
					$fields[]="sum(case when (CONVERT(varchar(255), DATE, 21) >= '$begin' and CONVERT(varchar(255), DATE, 21) <= '$end') then 1 end) as $month";
				}*/
				$fields=implode(",",$fields);
				//$query="Select $fields from TStations";
				$queryresult=$this->Station->query($query);
				//print_r($queryresult);
				$i=0;	
				foreach($queryresult as $r){					
					$cmonth=date("F",mktime(0, 0, 0, $r[0]['nummonth'], 1, $y))." ".$monthyear[date("F",mktime(0, 0, 0, $r[0]['nummonth'], 1, $y))];;
					$nbbym[$cmonth]=$r[0]['nb'];
				}	
				$nbbym=array(array($nbbym));
				$this->set('result',$nbbym);
			}
			$this->set('find',$find);
			
			$this->RequestHandler->respondAs('json');
			$this->viewPath .= '/json';
			$this->layout= 'json';
			$this->layoutPath = 'json';	
		}	
		
	}
?>