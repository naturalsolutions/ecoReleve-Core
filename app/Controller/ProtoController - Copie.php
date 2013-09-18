<?php
	/*Directly use sql request
	$db = $this->getDataSource();
	$db->fetchAll(
    'SELECT * from users where username = ? AND password = ?',
    array('jhon', '12345')
	);*/
	include_once '../../lib/Cake/Model/ConnectionManager.php';
	App::uses('Model', 'Model');
	App::uses('AppModel', 'Model');
	define("base", "default");
	define("limit",0);
	define("offset",0);
	class ProtoController extends AppController{
		var $helpers = array('Xml', 'Text','form','html' );
		public $components = array('RequestHandler');		
		function index(){				
			//$this->loadModel('Test');
     		//$this->TProtocol_Release_Group->read();
			//$query="select top 1000 * from V_Qry_AllIndivs_AllStations";
			$column_array = array("TSta_PK_ID","FieldActivity_Name","Name","DATE");
			//$desc_query="Select top 25 TSta_PK_ID,FieldActivity_Name,Name,DATE from eReleve.dbo.TStations where Name LIKE '%zs%' or TSta_PK_ID LIKE '%zs%' or FieldActivity_Name LIKE '%zs%' or DATE LIKE '%zs%'";
			$desc_proto = new AppModel("TStations","TStations",base);			
			/*$desc_proto->find("all",array('recursive' => 0
														,'limit'=>10
														,'offset'=>0
														,'fields'=>$column_array
														
														,'conditions'=>array("OR"=>array(
																			'TSta_PK_ID LIKE'=>"%zs%",
																			'FieldActivity_Name LIKE'=>"%zs%",
																			'Name LIKE'=>"%zs%",
																			'DATE LIKE'=>"%zs%"
																			)
																		)																		
														)
												);*/
			//$desc=$desc_proto->query($desc_query);	
			//$this->set("n",print_r($desc,true));	
			$this->set("n",$search);
			/*$model_proto->find('all',array('limit'=>30
											,'recursive'=>-1
											,'offset'=>1000
											,'field'=>array('Ind_ID,Taxon,Origin,CurrentStatus')
											));*/
			//$this->paginate['Profile']['contain']=$model_proto->find('all',array('limit'=>30,'offset'=>5000,'field'=>array('Ind_ID,Taxon,Origin,CurrentStatus')));
			//$this->set('n',$this->Test->find("all").toString());
		}
		
		//controller method for the list of protocole creation	service
		function proto_list(){
			$model = new AppModel("TProtocole","TProtocole",base);	
			$conditions=array();
			$debug="";
			//$debug=print_r(array_keys($this->params['url']),true);
			if(isset($this->params['url']['motcle'])){
				$mot=$this->params['url']['motcle'];
				$mot=str_replace(" ","%",$mot);
				$conditions=array("conditions"=>array("Relation LIKE"=>"%$mot%"));
				//$debug=print_r($conditions,true);
			}				
			//$db = ConnectionManager::getDataSource(base);
			//$tables = $db->listSources();	
			$table = $model->find("all",array()+$conditions);	
			$this->set('protos', $table);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layoutPath = 'xml';			
		}
		
		//controller method for the table detail and value service
		function table_get(){	
			$table_name="";			
			$this->set('nom',$table_name);
			$format="xml";
			$limit=limit;
			$offset=offset;
			if(isset($this->params['url']['format']))
				$format=$this->params['url']['format'];
			if(isset($this->params['url']['limit']))
				$limit=intval($this->params['url']['limit']);
			if(isset($this->params['url']['offset']))
				$offset=intval($this->params['url']['offset']);	
			if($format=="xml" || $format=="json"){
				if(isset($this->params['url']['table_name'])){ 
					$table_name = $this->params['url']['table_name'];								
					try{
						$model_proto = new AppModel($table_name,$table_name,base);		
						//$proto = $model_proto->find('all');
						//$proto = $model_proto->find('all',array('limit'=>2000));
						//$proto = $model_proto->find('all',array('limit'=>2000,'fields'=>array('Taxon', 'Precision')));
						$this->set('find',1);							
						$column_array_find = false;	
						//create a table of column name
						$column_array=array();
						foreach ($model_proto->schema() as $key=>$val)
							array_push($column_array,$key);						
						if(isset($this->params['url']['table_column'])){
							$table_name_column = $this->params['url']['table_column'];
							$column_array=split(",",$table_name_column);
							$column_array_find = true;	
							//see if column arg exist in table
							for($i=0;$i<sizeof($column_array);$i++){
								if(!array_key_exists($column_array[$i],$model_proto->getColumnTypes())){
									$column_array_find =false;
									$this->set('find',-2);
								}
							}		
							if($column_array_find)
								$proto = $model_proto->find('all',array('recursive' => 0,'limit'=>$limit,'offset'=>$offset,'fields'=>$column_array));
							else
								$proto = "";	
							$this->set('table',$proto);								
						}
						else	
							$proto = $model_proto->find('all',array('recursive' => 0,'limit'=>$limit,'offset'=>$offset));		
						$this->set("column_find",$column_array_find);
						$this->set("schema",$column_array);
					}
					catch(Exception $e){
						$this->set('find',-1);
					}
					$this->set('table',$proto);	
					$this->set('model',$model_proto);					
				}
				else{
					$this->set('nom',$table_name);
					$this->set('find',0);
				}
				// Set response as format
				$this->RequestHandler->respondAs($format);
				$this->viewPath .= "/$format";
				$this->layoutPath = $format;
			}
			else{
				$this->set('find',-3);
				// Set response as XML
				$this->RequestHandler->respondAs('xml');
				$this->viewPath .= '/xml';
				$this->layoutPath = 'xml';
			}			
		}
		
		//get station for a datatable js
		function station_get(){	
			$find=1;
			$debug="";
			$table_name="TStations"; //if proto name not set
			$Stationjoin=array();
			$Stationjoinstringname="";
			$dot="";
			$Distinct=array();
			$ModelName="AppModel";
			if(isset($this->params['url']['id_proto'])){
				$Distinct= array();
				$id_proto=$this->params['url']['id_proto'];
				$model_list_proto = new AppModel("TProtocole","TProtocole",base);
				$table_name="TProtocol_".$model_list_proto->find('first',array("conditions" => array("TTheEt_PK_ID"=>$id_proto)))['AppModel']['Relation'];
				$Stationjoinstringname="TStationsJoin";
				$dot=".";
				$Stationjoin=array('joins' => array(
						array(
							'table' => 'TStations',	
							'alias' => $Stationjoinstringname,	
							'type' => 'INNER',
							'conditions' => array(
								"FK_TSta_ID = $Stationjoinstringname.TSta_PK_ID"
							)
						)
					)
					
					
					);
				$ModelName=$Stationjoinstringname;	
			}
			$Stationjoinstringnamedot=$Stationjoinstringname.$dot;
			$model_proto = new AppModel($table_name,$table_name,base);
			$this->set("Model",$model_proto);
			$column_array = $Distinct+array($Stationjoinstringnamedot."TSta_PK_ID",$Stationjoinstringnamedot."FieldActivity_Name",$Stationjoinstringnamedot."Name",$Stationjoinstringnamedot."DATE");
			$limit=limit;
			$offset=offset;
			$sEcho="1";
			$total=$model_proto->find("count",array()+$Stationjoin);
			
			//take limit paramater
			if(isset($this->params['url']['iDisplayLength'])){
				$limit=intval($this->params['url']['iDisplayLength']);
			}
			//take offset parameter
			if(isset($this->params['url']['iDisplayStart'])){
				$offset=intval($this->params['url']['iDisplayStart']);	
			}
			//take sEcho parameter
			if(isset($this->params['url']['sEcho'])){
				$sEcho=$this->params['url']['sEcho'];	
			}			
			
			//column sort
			if(isset($this->params['url']['iSortCol_0']) &&  isset($this->params['url']['sSortDir_0'])){
				$index_col=intval($this->params['url']['iSortCol_0']);
				$sort_dir= $this->params['url']['sSortDir_0'];
				$sort_column=$column_array[$index_col];
			}
			
			//take the word for the research and do the research
			if(isset($this->params['url']['sSearch']) && $this->params['url']['sSearch']!=""){
				$search=$this->params['url']['sSearch'];
				$like="LIKE";
				$left_p="%";
				$right_p="%";
				$column_search="";				
				//if we choose to search only in column and also see if it's not a date because of ":"
				if(stripos($search,":")!==false && !preg_match('/(\d+)-(\d+)-(\d+) ((\d+):){1,2}(\d+)/', $search) && !preg_match('/((\d+):){1,2}(\d+)/', $search)){
					$arrayserach=split(":",$search,2);
					$column_search=$arrayserach[0];
					$search=$arrayserach[1];
				}					
				//verify if its a like research or not		
				if(strlen($search)>0 && $search[sizeof($search)-1]=="\"" && $search[strlen($search)-1]=="\""){
					$like="";
					$left_p="";
					$right_p="";
					$search=substr($search,1,-1);
				}
				else{
					$search="%".$search."%";
				}
				$pk_search=$search;
				$pk_condition_arr=array();
				//for primary key check if is a an integer
				if(intval($search)!=0 && !strpos($search,":") && !strpos($search,"-")){
					$pk_condition_arr=["TSta_PK_ID $like" => $pk_search];
				}
				
				$fa_search=$search;
				$n_search=$search;
				$d_search=$search;
				$condition_array = array();
				//if column search fill the variables
				if(in_array($column_search,$column_array)){
					switch($column_search){
						case "TSta_PK_ID":$fa_search="";$n_search="";$d_search="";$condition_array+=array("TSta_PK_ID $like" => $pk_search);break;
						case "FieldActivity_Name":$pk_search="";$n_search="";$d_search="";$condition_array+=array("FieldActivity_Name $like" => $fa_search);break; 
						case "Name":$fa_search="";$pk_search="";$d_search="";$condition_array+=array("Name $like" => $n_search);break; 
						case "DATE":$fa_search="";$n_search="";$pk_search="";$condition_array+=array("CONVERT(VARCHAR, DATE, 120) $like" => $d_search);break; 	
					}
				}
				else{
					$condition_array= array('or'=>array(
														
														"FieldActivity_Name $like" => $fa_search,
														"Name $like" => $n_search,
														"CONVERT(VARCHAR, DATE, 120) $like" => $d_search
														)+$pk_condition_arr
													);
				}
				
				$station = $model_proto->find("all",array('recursive' => 0
														,'limit'=>$limit
														,'offset'=>$offset
														,'fields'=>$column_array
														,'order'=> array("$sort_column $sort_dir")
														,'conditions'=>$condition_array
																																																			
														)+$Stationjoin
												);
											
				//if result find
				if($station){								
					$totaldisplay = $model_proto->find("count",array('recursive' => 0														
														,'fields'=>$column_array
														,'order'=> array("$sort_column $sort_dir")
														,'conditions'=>array('OR'=>$condition_array
																		)+$Stationjoin																																		
														)
												);
				}								
				else
					$totaldisplay=0;
			}	
			//find station with the right parameter without search
			else{
				$station = $model_proto->find("all",array('recursive' => 0
														,'limit'=>$limit
														,'offset'=>$offset
														,'fields'=>$column_array
														,'order'=> array("$sort_column $sort_dir"))+$Stationjoin
												);
				if($station){
					$totaldisplay = $model_proto->find("count",array('recursive' => 0
														,'fields'=>$column_array)+$Stationjoin
												);	
				}								
				else 
					$totaldisplay=0;
		    }
			
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
						
		//controller method for the protocole struct service
		function proto_get(){
			$debug="";
			if(isset($this->params['url']['proto_name']) || isset($this->params['url']['id_proto'])){ 
				$table_name="";
				//get the name of the protocole
				if(isset($this->params['url']['proto_name']))
					$table_name = $this->params['url']['proto_name'];	
				
				$model_list_proto = new AppModel("TProtocole","TProtocole",base);
				$name=str_replace("TProtocol_","",$table_name);
				$id_proto_array=$model_list_proto->find('first',array("conditions" => array("Relation"=>$name)));
				$id_proto="";
				if(isset($id_proto_array['AppModel']["TTheEt_PK_ID"]))
					$id_proto=$id_proto_array['AppModel']["TTheEt_PK_ID"];
				if(isset($this->params['url']['id_proto'])){
					$id_proto=$this->params['url']['id_proto'];					
					$table_name="TProtocol_".$model_list_proto->find('first',array("conditions" => array("TTheEt_PK_ID"=>$id_proto)))['AppModel']['Relation'];
					
				}					
				
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
				$this->set('id_proto',$id_proto);
				$this->set('model',$model_proto);
				$this->set('nom',$table_name);
				
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
		
		//list of map	
		function listmap_view(){
			$model_views = new Model("TMapSelectionManager","TMapSelectionManager",base);	
			$model_views_val=$model_views->find('all');
			$this->set('model_views',$model_views_val);
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