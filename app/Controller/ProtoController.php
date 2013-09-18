<?php
	include_once '../../lib/Cake/Model/ConnectionManager.php';
	include_once 'AppController.php';
	App::uses('Model', 'Model');
	App::uses('AppModel', 'Model');
	define("base", "narc_ereleve"); //name of database use
	define("limit",0);  //sql limit default value
	define("offset",0); //sql offset default value
	define("cache_time",3600);
	//
	class ProtoController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache');
		public $components = array('RequestHandler');
		var $typereturn;			
		public $cacheAction = array(  //set the method(webservice) with a cached result
			'proto_list' => cache_time,
			'station_get' => cache_time,  
			'proto_taxon_get' => cache_time,
			'proto_get' => cache_time
		);
		
		//controller method for the list of protocole
		function proto_list(){
			$model = new AppModel("TProtocole","TProtocole",base);	
			$conditions=array();
			$debug="";
			//case with a keyword parameter
			if(isset($this->params['url']['motcle'])){
				$mot=$this->params['url']['motcle'];
				$mot=str_replace(" ","%",$mot);
				$conditions=array(  "Relation LIKE"=>"%$mot%");
			}			
			$table = $model->find("all",array("conditions"=>array("Active" => 1)+$conditions));	
			$this->set('protos', $table);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layout='xml';
			$this->layoutPath = 'xml';		
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
			
			if(isset($this->params['url']['to_carto']) && $this->params['url']['to_carto']!=""){
				if($this->params['url']['to_carto']=="yes"){
					$find=2;
				}
			}
			
			//if protocole filter join to station
			if(isset($this->params['url']['id_proto']) && $this->params['url']['id_proto']!=""){
				$Distinct= array();
				$id_proto=$this->params['url']['id_proto'];
				$model_list_proto = new AppModel("TProtocole","TProtocole",base);
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
				$model_proto = new AppModel($table_name,$table_name,base);
				$this->set("Model",$model_proto);
				//array that contain the column return
				$column_array = array($Stationjoinstringnamedot."TSta_PK_ID",$Stationjoinstringnamedot."FieldActivity_Name"
				,$Stationjoinstringnamedot."Name",$Stationjoinstringnamedot."DATE",$Stationjoinstringnamedot."Region",$Stationjoinstringnamedot."Place"
				,$Stationjoinstringnamedot."LAT",$Stationjoinstringnamedot."LON");
				$condition_array = array('LAT IS NOT NULL');
				$limit=limit;
				$offset=offset;
				$sEcho="1";
				$total=$model_proto->find("count",array()+$Stationjoin);
				
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
				}
				
				//take the word for the research and do the research
				if(isset($this->params['url']['sSearch']) && $this->params['url']['sSearch']!=""){
					$search=$this->params['url']['sSearch'];				
				}
				
				//create condition array for the sql request
				$condition_array=$model_proto->filter_create($condition_array,$place,$region,$date,"","","",$search,$tsearch);				
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
			$this->viewPath .= '/json';
			$this->layoutPath = 'json';											
		}
		
		//controller method for the getting taxon from protocole service 
		function proto_taxon_get(){
			$debug="";
			$find=1;
			$table_name="";
			if(isset($this->params['url']['id_proto'])){
				$id_proto = $this->params['url']['id_proto'];
				//get the name of table from the id
				$model_list_proto = new AppModel("TProtocole","TProtocole",base);
				$pk_id_name="TTheEt_PK_ID";
				if(isset($id_proto_array['AppModel']["TTheEt_PK_ID"]))
					$id_proto=$id_proto_array['AppModel']["TTheEt_PK_ID"];
				else if(isset($id_proto_array['AppModel']["ttheEt_PK_ID"])){
					$id_proto=$id_proto_array['AppModel']["ttheEt_PK_ID"];	
					$pk_id_name="ttheEt_PK_ID";
				}
				$table_name_array=$model_list_proto->find('first',array("conditions" => array($pk_id_name=>$id_proto)));
				if(isset($table_name_array['AppModel']['Relation']))
					$table_name="TProtocol_".$table_name_array['AppModel']['Relation'];
				else
					$find=-1;
				if($find!=-1){	
					$array_conditions=array();
					if(isset($this->params['url']['search']) && isset($this->params['url']['search'])!=""){
						$search=$this->params['url']['search'];
						$array_conditions+=array('Name_Taxon LIKE'=>'%'.$search.'%');	
					}				
					//finding taxon from table
					try{					
						$model_proto = new AppModel($table_name,$table_name,base);	
						//check if the table have taxon field
						$taxon_find=false;
						foreach ($model_proto->schema() as $key=>$val){
							if($key=="Name_Taxon")
								$taxon_find=true;							
						}
						if($taxon_find){
							$taxons=$model_proto->find('all',array(
								'fields'=>array('Name_Taxon'),
								'group'=>array('Name_Taxon'),
								'conditions'=>$array_conditions
							));
							$this->set("taxons",$taxons);	
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
			$this->set("table_name",$table_name);	
			$this->set("debug",$debug);
			$this->set("find",$find);
			// Set response as XML
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layoutPath = 'xml';	
		}
		
		//controller method for the protocole struct service
		function proto_get(){
			$debug="";
			$find=1;
			if(isset($this->params['url']['proto_name']) || isset($this->params['url']['id_proto'])){ 
				$table_name="";
				//get the name of the protocole
				if(isset($this->params['url']['proto_name']))
					$table_name = $this->params['url']['proto_name'];	
				
				$model_list_proto = new AppModel("TProtocole","TProtocole",base);
				$name=str_replace("TProtocol_","",$table_name);
				$id_proto_array=$model_list_proto->find('first',array("conditions" => array("Relation"=>$name)));
				$id_proto="";
				$pk_id_name="TTheEt_PK_ID";
				if(isset($id_proto_array['AppModel']["TTheEt_PK_ID"]))
					$id_proto=$id_proto_array['AppModel']["TTheEt_PK_ID"];
				else if(isset($id_proto_array['AppModel']["ttheEt_PK_ID"])){
					$id_proto=$id_proto_array['AppModel']["ttheEt_PK_ID"];	
					$pk_id_name="ttheEt_PK_ID";
				}	
				if(isset($this->params['url']['id_proto'])){
					$id_proto=$this->params['url']['id_proto'];					
					$table_name_array=$model_list_proto->find('first',array("conditions" => array($pk_id_name=>$id_proto)));
					if(isset($table_name_array['AppModel']['Relation']))
						$table_name="TProtocol_".$table_name_array['AppModel']['Relation'];					
					else{
						$find=-1;
						$this->set('find',-1);
					}
				}	
				if($find!=-1){	
					//description view that contain the field type (if list contain also items)
					$desc_query="SELECT t,c,cd,td From V_Qry_Column_Descr where t='dbo.$table_name'";
					try{
						$desc_proto = new AppModel("V_Qry_Column_Descr","V_Qry_Column_Descr",base);	
						$desc=$this->simply_table($desc_proto->query($desc_query));
						$this->set('desc',$desc);					
					}
					catch(Exception $e){
						$this->set('find',-3); //View not create
					}
					//		
					//create model from protocol and get table descr on the view for keyword protocol	
					try{					
						$model_proto = new Model($table_name,$table_name,base);		
						$this->set('find',1); //table find
						//just for take one column name
						$keycol=array_keys($model_proto->schema())[0];						
						$table_desc= $desc[$keycol]['td'];
						$this->set("table_desc",$table_desc);
					}
					catch(Exception $e){
						$this->set('find',-1); //table not find
					}
					try{
						$model_thesaurus = new Model("Tthesaurus","Tthesaurus",base);					
						$this->set('model_T',$model_thesaurus);
					}
					catch(Exception $e){
						$this->set('find',-2); //table not defined
					}					
					$this->set('model',$model_proto);
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
							$sTable+=[$tablename=>[]];
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
			$db = ConnectionManager::getDataSource(base);
			
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