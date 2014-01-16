<?php
	App::uses('Model', 'Model');
	App::uses('AppModel', 'Model');
	define("base", "ereleve");
	//include_once '../../lib/Cake/Model/ConnectionManager.php';
	include_once 'AppController.php';	
	define("cache_time",3600);
	class NsmlController extends AppController{		
		var $helpers = array('Xml', 'Text','form','html','Cache');
		public $components = array('RequestHandler');
		var $typereturn;	
		public $cacheAction = array(
			//'nsml_get' => cache_time,
			'fa_list' => 2592000, //1 month
			'region_list' => 2592000,
			'place_list' => 2592000
		);
		
		//return a NSML file from a filtered export view 
		function nsml_get(){
			$this->set("debug","");
			$table=""; 
			$datedep="";
			$datearr="";
			$place="";
			$region="";
			$like="";
			$fieldactivity="";
			$count="no";
			$condition_array=array();
			$typestation=false;
			$exist=1;			
			$date_name="DATE";
			$array_column=array();
			$find=array();
			$model="";
			$limit=0;
			$offset=0;
			
			if(isset($this->params['url']['table']))
				$table=$this->params['url']['table'];
			
			if(isset($this->params['url']['limit'])){
				$limit=$this->params['url']['limit'];
			}

			if(isset($this->params['url']['offset'])){
				$offset=$this->params['url']['offset'];
			}
			
			if($table!=""){
				//try to load the table find to 0 if not
				try{
					$model = new AppModel($table,str_replace(" ","",$table),base);
					$protocolemodel = new AppModel("TProtocole","TProtocole",base);
				}
				catch(Exception $e){
					$this->set("exist",0);	
				}	
				
				//check if the view contain a station
				foreach ($model->schema() as $key=>$val){
					if($key=="LON" || $key=="LAT"){
						$typestation=true;
					}
					if($key=="StaDate"){
						$date_name="StaDate";
					}
					if($key=="lastArgosDate"){
						$date_name="lastArgosDate";
					}	
					array_push($array_column,$key);		
				}			
				$condition_array=array("$date_name IS NOT NULL");
				
				
				//check if is count request or not
				if(isset($this->params['url']['count']))
					$count=$this->params['url']['count'];
				
				//
				if(isset($this->request->params['count']))
					$count=$this->request->params['count'];
				
				//take place parameter for a place filter
				if(isset($this->params['url']['place']) && $this->params['url']['place']!="" && $this->params['url']['place']!="null"){
					$place=$this->params['url']['place'];				
				}
				
				//take region parameter for a region filter
				if(isset($this->params['url']['region']) && $this->params['url']['region']!="" && $this->params['url']['region']!="null"){
					$region=$this->params['url']['region'];				
				}	
				
				if(isset($this->params['url']['fieldactivity']) && $this->params['url']['fieldactivity']!="" && $this->params['url']['fieldactivity']!="null"){
					$fieldactivity=$this->params['url']['fieldactivity'];
				}
				
				//take min-date parameter for a min-date filter
				if(isset($this->params['url']['min-date']) && $this->params['url']['min-date']!="" && $this->params['url']['min-date']!="null"){
					$datedep=$this->params['url']['min-date'];		
				}	
				
				//take max-date parameter for a max-date filter when min date is set because when we have no date only min-date is empty
				if(isset($this->params['url']['max-date']) && $this->params['url']['max-date']!="" && $this->params['url']['max-date']!="null"){	
					$datearr=$this->params['url']['max-date'];
				}
				
				$condition_array=$model->filter_create($condition_array,$place,$region,"",$datedep,$datearr,$fieldactivity,"","",$date_name,false);						
					
				$prototable=$table;	
				if(strpos($table,"TProtocol_")!==false)
					$prototable=substr($table, strlen("TProtocol_"));
				$isprotocole=$protocolemodel->find("all",array("conditions"=>array("Relation"=>$prototable)));
				$arrayjoin=array();
				if($isprotocole){
					$arrayjoin=array('joins' => array(
													array(
														'table' => 'TStations',
														'alias' => 'TStationsJoin',
														'type' => 'INNER',
														'conditions' => array(
															'FK_TSta_ID = TStationsJoin.TSta_PK_ID'
														)
													)
												));
					array_push($array_column,"TStationsJoin.$date_name","TStationsJoin.LON","TStationsJoin.LAT","TStationsJoin.Precision","TStationsJoin.ELE","TStationsJoin.Region","TStationsJoin.Place");							
				}	
				
				if($count=="no"){
					$find = $model->find('all',array(	
													'recursive' => 0,
													'fields' => $array_column
													,'conditions'=>$condition_array
													,'limit'=>$limit
													,'offset'=>intval($offset)
													)+$arrayjoin 
										);
				}		
				else{
					$exist=2;
					$find = $model->find('count',array(	
													'recursive' => 0,
													'fields' => $array_column
													,'conditions'=>$condition_array
													)+$arrayjoin 
										);
				}
			}
			else{
				$exist=0;
			}	
			//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
			//fwrite($fp, print_r(,true));
			$this->set("debug","");					
			$this->set("exist",$exist);					
			$this->set("finds",$find);
			$this->set("model",$model);			
			// Set response as XML
			$this->RequestHandler->respondAs("xml");
			$this->viewPath .= '/xml';
			$this->layoutPath = 'xml';
			$this->layout = 'xml';
		}
		
		//Return a list of expot view  
		function map_views_list(){
			$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
			$conditions=array();
			$debug="";	
			$date_name=array("DATE","StaDate","lastArgosDate");
			//$model->column_exist("V_Qry_VGroups_AllTaxons_EnjilDamStations",$date_name);
			$table = $model->find("all",array('order'=> array("TSMan_Layer_Name asc"))+$conditions);				
			$this->set('date_name',$date_name);
			$this->set('base',base);			
			$this->set('model',$model);
			$this->set('views', $table);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layout = 'xml';
			$this->layoutPath = 'xml';	
		}

		//list of fieldactivity
		function fa_list(){
			$model = new AppModel("TStations","TStations",base);
			$debug="";
			//Cache::clear(); 
			$tables = $model->find("all",array(
							'fields'=>array('FieldActivity_Name'),
							'group'=>array('FieldActivity_Name'))
							);		
			$this->set('FA', $tables);
			$this->set("debug",$debug);					
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layout = 'xml';
			$this->layoutPath = 'xml';
		}	
		
		//list of region
		function region_list(){
			$model = new AppModel("TStations","TStations",base);
			$debug="";
			$tables = $model->find("all",array(
							'fields'=>array('Region'),
							'group'=>array('Region'))
							);				
			$this->set('region', $tables);
			$this->set("debug",$debug);					
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layout = 'xml';
			$this->layoutPath = 'xml';
		}	
		
		//list of place
		function place_list(){
			$model = new AppModel("TStations","TStations",base);
			$debug="";
			$region="";
			$conditions=array();
			if(isset($this->params['url']['region']) && $this->params['url']['region']!=""){
				$region=$this->params['url']['region'];
				$conditions+=array("Region"=>$region);
			}
			
			$tables = $model->find("all",array(
							'fields'=>array('Place'),
							'group'=>array('Place'),
							'conditions'=>$conditions)
							);
							
			$this->set('place', $tables);
			$this->set("debug",$debug);					
			$this->RequestHandler->respondAs('xml');
			$this->viewPath .= '/xml';
			$this->layout = 'xml';
			$this->layoutPath = 'xml';
		}
	}
?>	