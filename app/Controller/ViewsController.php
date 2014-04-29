<?php
	App::uses('AppController','Controller');
	class ViewsController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);
		public $gpx_name ="data";
		
		public function beforeFilter() {
			ini_set ("max_input_time","300");
			ini_set ("memory_limit","2280M");
			//ini_set ("memory_limit",-1);
			ini_set ("max_execution_time","300");
		}
		
		function index(){
			
		}	
		
		//Return a list of theme view  
		function themes_list(){
			$this->loadModel('MapSelectionManager');
			$this->MapSelectionManager->setSource("TThemeEtude");
			//$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
			$import=false;
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
			
			if(isset($this->params['url']['import']) && $this->params['url']['import']!=""){
				$import=true;
			}
			
			$conditions=array();
			$debug="";
	
			//join for select themes with view
			$options['joins'] = array(
				array('table' => 'TMapSelectionManager',
					'alias' => 'TMapSelectionManager',
					'type' => 'INNER',
					'conditions' => array(
						"TMapSelectionManager.TSMan_FK_Theme  = TProt_PK_ID" 
					)
				)
			);	
			if($import)
				$options=array();
			//$date_name=array("DATE","StaDate","lastArgosDate");
			//$model->column_exist("V_Qry_VGroups_AllTaxons_EnjilDamStations",$date_name);
			//$table = $model->find("all",array('order'=> array("TSMan_Layer_Name asc"))+$conditions);				
			$table = $this->MapSelectionManager->find("all",array(
				'fields'=>array('TProt_PK_ID','Caption'),	
				'order'=> array("Caption asc"),
				'group'=>array('Caption','TProt_PK_ID'),
				'conditions'=>array("Actif"=>true)
				)+$options
			);
			if(!$import)
				$table=array_merge($table,array(array("MapSelectionManager"=>array("TProt_PK_ID"=>"null","Caption"=>"Others"))));	
			//$this->set('date_name',$date_name);
			$this->set('model',$this->MapSelectionManager);
			$this->set('views', $table);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;	
		}
		
		//Return a list of expot view  
		function views_list(){
			$conditions=array();
			$this->loadModel('MapSelectionManager');
			$options=array();
			//$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
			
			//format from request
			if(stripos($this->request->header('Accept'),"application/xml")!==false)
				$format="xml"; 
			else if(stripos($this->request->header('Accept'),"application/json")!==false)
				$format="json";	
			
			if(isset($this->params['url']['id_theme']) && $this->params['url']['id_theme']!=""){
				$id_theme=$this->params['url']['id_theme'];
				if($id_theme=="null"){
					$options['joins'] = array(
					array('table' => 'TThemeEtude',
							'alias' => 'TThemeEtude',
							'type' => 'left',
							'conditions' => array(
								"TSMan_FK_Theme  = TThemeEtude.TProt_PK_ID" 
							)
						)
					);
					$conditions+=array('conditions'=>array("Caption is null"));
				}	
				else
					$conditions+=array('conditions'=>array("TSMan_FK_Theme"=>$id_theme));
			}
			
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
			
			
			$debug="";	
			//$date_name=array("DATE","StaDate","lastArgosDate");
			//$model->column_exist("V_Qry_VGroups_AllTaxons_EnjilDamStations",$date_name);
			//$table = $model->find("all",array('order'=> array("TSMan_Layer_Name asc"))+$conditions);				
			$table = $this->MapSelectionManager->find("all",array('order'=> array("TSMan_Layer_Name asc"))+$conditions+$options);				
			//$this->set('date_name',$date_name);
			$this->set('model',$this->MapSelectionManager);
			$this->set('views', $table);
			$this->set("debug",$debug);
			// Set response as XML
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;	
		}
		
		//get the station(s) from a map export view  
		function get_view(){
			$this->loadModel('MapSelectionManager');
			$table_name="";
			$condition=array();
			$count=false;
			$fields=array();
			$debug="";
			$find=0;
			$limit=50;
			$offset=0;
			$gpx_name=$this->gpx_name;
			$gpx_url="";
			$cluster="no";
			$agrwhere="";
			$filters=array();
			$format="json";
			$conditionstring2="";
			$bbox="";			
			
			//creation of the gpx's url
			if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$uri=$_SERVER['REQUEST_URI'];
				$uri=split("/",$uri);
				$app_name=$uri[1];
				$app_name.='/'.$uri[2];
				$gpx_url=$_SERVER['HTTP_HOST'].'/'.$app_name.'/gps/'.$gpx_name.".gpx";				
			}
			
			//cluster parameter
			if(isset($this->params['url']['cluster']) && $this->params['url']['cluster']!=""){
				if($this->params['url']['cluster']=="yes"){
					$cluster="yes";
				}
			}
			
			$round="";
			//round cluster parameter
			if(isset($this->params['url']['round']) && $this->params['url']['round']!=""){
				$round=$this->params['url']['round'];				
			}
			
			//zoom param for cluster	
			$zoom=0;
			if(isset($this->params['url']['zoom']) && $this->params['url']['zoom']!="")
				$zoom=$this->params['url']['zoom'];	
			
			$this->set('gpx_url',$gpx_url);
			//format from request
			if(stripos($this->request->header('Accept'),"application/xml")!==false)
				$format="xml"; 
			else if(stripos($this->request->header('Accept'),"application/json")!==false)
				$format="json";	
			
			//format return from param
			if((isset($this->params['url']['format']) && $this->params['url']['format']!="") || isset($this->request->params['format'])){
				if(isset($this->request->params['format']))
					$tmp_format=$this->request->params['format'];
				else
					$tmp_format=$this->params['url']['format'];
				if($tmp_format=="json"){
					$format="json";
				}
				if($tmp_format=="geojson"){
					$format='json';
				}
				if($tmp_format=="datatablejs"){
					$format="json";
				}
				else if($tmp_format=="xml"){
					$format="xml";
				}
				else if($tmp_format=="test"){
					$format="test";
				}
			}			
			$top="TOP $limit";
			if(isset($this->params['url']['limit']) && $this->params['url']['limit']!=""){
				$limit=$this->params['url']['limit'];
				if($limit!=0)
					$top="TOP $limit";
				else 
					$top="";
			}
			$offs="";
			$offseton=false;
			if(isset($this->params['url']['offset']) && $this->params['url']['offset']!=""){
				$agrwhere="WHERE";
				$offset=intval($this->params['url']['offset']);
				$offs="_cake_paging_.Id > $offset";
				$offseton=true;	
			}
			
			if(isset($this->params['url']['skip']) && $this->params['url']['skip']!=""){
				$agrwhere="WHERE";
				$offset=intval($this->params['url']['skip']);
				$offs="_cake_paging_.Id > $offset";
				$offseton=true;	
			}
			$rowstring="";
			//map => grid interaction
			if(isset($this->params['url']['rows']) && $this->params['url']['rows']!=""){
				$agrwhere="WHERE";
				$row=$this->params['url']['rows'];
				$splitrow=explode(",",$row);
				//print_r($row);
				$and="";
				if($offseton)
					$and="and";
				foreach($splitrow as $r){
					$rowstring==""?$rowstring.="_cake_paging_.Id=$r":$rowstring.=" or _cake_paging_.Id=$r";	
				}
				$rowstring=" $and (".$rowstring.")";			
			}
			
			
			
			//$condition[]=array("LAT is not NULL and LON is not NULL");	
			//take the table name parameter
			if(isset($this->params['url']['table_name']) && $this->params['url']['table_name']!=""){
				$table_name=$this->params['url']['table_name'];
			}
			
			if(isset($this->request->params['table_name']) && $this->request->params['table_name']!=""){
				$table_name=$this->request->params['table_name'];
					
			}	
			
			//check if it's a count request
			if(isset($this->params['url']['count']) && $this->params['url']['count']!=""){
				$count=true;
			}
			
			if(isset($this->request->params['count']))
				$count=true;
			
			
			if(isset($this->params['url']['filters']) && count($this->params['url']['filters'])>0){
				$filters=$this->params['url']['filters'];
				//$condition_array[];
				foreach($filters as $f){
					if($f){
						list($col,$val)=split(":",$f,2);
						if($col=='DATE'){
							//equal date search with DATE:[DATE]
							if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val)){
								$condition[]=array("CONVERT(char(10),[DATE],126)='$val'");
								$conditionstring2==""?$conditionstring2.="CONVERT(char(10),[DATE],126)='$val'":$conditionstring2.=" and CONVERT(char(10),[DATE],126)='$val'";	
							}
							//search with real date format		
							else if(strpos($val, ":")!==false){
								list($typedatesearch,$date)=split(":",$val,2);
								//equal date search with DATE:exact:[DATE]
								if($typedatesearch=="exact"){
									if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
										$condition[]=array("CONVERT(char(10),[DATE],126)='$date'");
										$conditionstring2==""?$conditionstring2.="CONVERT(char(10),[DATE],126)='$date'":$conditionstring2.=" and CONVERT(char(10),[DATE],126)='$date'";
									}	
								}
								//before date search with DATE:before:[DATE]
								else if($typedatesearch=="before"){
									if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
										$condition[]=array("CONVERT(char(10),[DATE],126)<'$date'");
										$conditionstring2==""?$conditionstring2.="CONVERT(char(10),[DATE],126)<='$date'":$conditionstring2.=" and CONVERT(char(10),[DATE],126)<='$date'";
									}	
								}
								//after date search with DATE:after:[DATE]
								else if($typedatesearch=="after"){
									if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
										$condition[]=array("CONVERT(char(10),[DATE],126)>'$date'");
										$conditionstring2==""?$conditionstring2.="CONVERT(char(10),[DATE],126)>='$date'":$conditionstring2.=" and CONVERT(char(10),[DATE],126)>='$date'";
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
									$condition[]=array("CONVERT(char(10),[DATE],126)='$today'");
									$conditionstring2==""?$conditionstring2.="CONVERT(char(10),[DATE],126)='$today'":$conditionstring2.=" and CONVERT(char(10),[DATE],126)='$today'";
								}
								else if($val=="yesterday"){
									$yesterday = date("Y-m-d",mktime(0,0,0,$m,$d-1,$y));
									$condition[]=array("CONVERT(char(10),[DATE],126)='$yesterday'");
									$conditionstring2==""?$conditionstring2.="CONVERT(char(10),[DATE],126)='$yesterday'":$conditionstring2.=" and CONVERT(char(10),[DATE],126)='$yesterday'";
								}
								else if($val=="lastweek"){
									$lastweek=date("Y-m-d",mktime(0,0,0,$m,$d-7,$y));
									$weekreq="CONVERT(char(10),DATE,120) >= CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, cast('$lastweek' as date))/7, 0), 120) and
				CONVERT(char(10),DATE,120) <= CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, cast('$lastweek' as date))/7, 6),120)";
									$condition[]=array($weekreq);
									$conditionstring2==""?$conditionstring2.="$weekreq":$conditionstring2.=" and $weekreq";
								}
								else if($val=="lastmonth"){
									$lastmonth = date("Y-m",mktime(0,0,0,$m-1,$d,$y));
									$condition[]=array("CONVERT(char(7), DATE, 120)='$lastmonth'");
									$conditionstring2==""?$conditionstring2.="CONVERT(char(7), DATE, 120)='$lastmonth'":$conditionstring2.=" and CONVERT(char(7), DATE, 120)='$lastmonth'";
								}
								else if($val=="lastyear"){
									$lastyear = date("Y",mktime(0,0,0,$m,$d,$y-1));
									$condition[]=array("CONVERT(char(4), DATE, 120)='$lastyear'");
									$conditionstring2==""?$conditionstring2.="CONVERT(char(4), DATE, 120)='$lastyear'":$conditionstring2.=" and CONVERT(char(4), DATE, 120)='$lastyear'";
								}
							}	
						}
						else {
							//No date search
							if(strpos($val, ":")!==false){
								list($typesearch,$search)=split(":",$val,2);
								//exact search
								if($typesearch=="exact"){
									$condition+=array($col=>$search);
									$conditionstring2==""?$conditionstring2.="$col='$search'":$conditionstring2.=" and $col='$search'";	
								}
								//begin search
								else if($typesearch=="begin"){
									$condition+=array($col.' like'=>$search.'%');
									$conditionstring2==""?$conditionstring2.="$col like '$search%'":$conditionstring2.=" and $col like '$search%'";	
								}
								//end search
								else if($typesearch=="end"){
									$condition+=array($col.' like'=>'%'.$search);
									$conditionstring2==""?$conditionstring2.="$col like '%$search'":$conditionstring2.=" and $col like '%$search'";	
								}
								//contain search
								else if($typesearch=="contain"){
									$condition+=array($col.' like'=>'%'.$search.'%');
									$conditionstring2==""?$conditionstring2.="$col like '%$search%'":$conditionstring2.=" and $col like '%$search%'";	
								}
							}
							else{
								$condition+=array($col.' like'=>$val.'%');
								$conditionstring2==""?$conditionstring2.="$col like '$val%'":$conditionstring2.=" and $col like '$val%'";
							}	
						}	
					}
				}				
			}
			
			//if table parameter exist
			$table_name=str_replace(" ","",$table_name);
			if($table_name!=""){
				try{
					$this->MapSelectionManager->setSource($table_name);
					$this->set('model',$this->MapSelectionManager);
					$schema=$this->MapSelectionManager->schema();
					$fields=array_keys($schema);
					$latlonnull="";
					if(in_array('LAT', $fields))
						$latlonnull="where LAT is not NULL and LON is not NULL";
					//take column parameter
					if(isset($this->params['url']['columns']) && $this->params['url']['columns']!=""){
						$column=$this->params['url']['columns'];
						$columnarray=split(",",$column);
						//check if the column exist
						foreach($columnarray as $c){
							if(!array_key_exists($c,$schema)){
								$this->set("inexistant",$c);
								$find=-2;
								break;
							}							
						}
						$fields=$columnarray;
					}
					//print_r($fields);
					$this->set('schema',$fields);	
				}catch(Exception $e){
					$find=-1;
				}
				//print_r("ici2 $latlonnull");
				//BBOX param if map call
				if(isset($this->params['url']['bbox']) && $this->params['url']['bbox']!="" && $latlonnull!=""){
					
					$bbox=$this->params['url']['bbox'];
					$bbox_array=split(",",$bbox);
					$min_lon=$bbox_array[0];
					$max_lon=$bbox_array[2];
					$min_lat=$bbox_array[1];
					$max_lat=$bbox_array[3];
					$condition = array("LAT >= $min_lat and LAT <= $max_lat and LON >= $min_lon and LON <= $max_lon");
					$conditionstring2==""?$conditionstring2.="LAT >= $min_lat and LAT <= $max_lat and LON >= $min_lon and LON <= $max_lon":$conditionstring2.=" and LAT >= $min_lat and LAT <= $max_lat and LON >= $min_lon and LON <= $max_lon";
				}
				
				
				$filters2="";
				//if table exist
				if($find==0){
					//create a condition array with filters
					if(isset($this->params['url']['filter']) && $table_name!=""){
						$filters2=$this->params['url']['filter'];
						
						//add filters on the array condition
						$filters2=split(",",$filters2);
						for($i=0;$i<count($filters2);$i++){
							if(count(($condi=split("<=",$filters2[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate'){
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' <='=>$condi[1]);
									$conditionstring2==""?$conditionstring2.="CONVERT(nchar(200),$condi[0],120)<= '$condi[1]'":$conditionstring2.=" and CONVERT(nchar(200),$condi[0],120) <= '$condi[1]'";			
								}	
								else{
									$condition+=array($condi[0].' <='=>$condi[1]);
									$conditionstring2==""?$conditionstring2.="$condi[0] <= '$condi[1]'":$conditionstring2.=" and $condi[0] <= '$condi[1]'";		
								}
							}
							else if(count(($condi=split(">=",$filters2[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate'){
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' >='=>$condi[1]);	
									$conditionstring2==""?$conditionstring2.="CONVERT(nchar(200),$condi[0],120) >= '$condi[1]'":$conditionstring2.=" and CONVERT(nchar(200),$condi[0],120) >= '$condi[1]'";	
								}	
								else{
									$condition+=array($condi[0].' >='=>$condi[1]);							
									$conditionstring2==""?$conditionstring2.="$condi[0] >= '$condi[1]'":$conditionstring2.=" and $condi[0] >= '$condi[1]'";		
								}
							}
							else if(count(($condi=split(">",$filters2[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate'){
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' >'=>$condi[1]);	
									$conditionstring2==""?$conditionstring2.="CONVERT(nchar(200),$condi[0],120) > '$condi[1]'":$conditionstring2.=" and CONVERT(nchar(200),$condi[0],120) > '$condi[1]'";
								}	
								else{
									$condition+=array($condi[0].' >'=>$condi[1]);							
									$conditionstring2==""?$conditionstring2.="$condi[0] > '$condi[1]'":$conditionstring2.=" and $condi[0] > '$condi[1]'";		
								}
							}
							else if(count(($condi=split("<",$filters2[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate'){
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' <'=>$condi[1]);
									$conditionstring2==""?$conditionstring2.="CONVERT(nchar(200),$condi[0],120) < '$condi[1]'":$conditionstring2.=" and CONVERT(nchar(200),$condi[0],120) < '$condi[1]'";
								}		
								else{
									$condition+=array($condi[0].' <'=>$condi[1]);							
									$conditionstring2==""?$conditionstring2.="$condi[0] < '$condi[1]'":$conditionstring2.=" and $condi[0] < '$condi[1]'";		
								}
							}
							else if(count(($condi=split("=",$filters2[$i])))>1){
								$condition+=array($condi[0]=>$condi[1]);	
								$conditionstring2==""?$conditionstring2.="$condi[0] = '$condi[1]'":$conditionstring2.=" and $condi[0] = '$condi[1]'";	
							}	
							else if(count(($condi=split(" LIKE ",$filters2[$i])))>1){
								$mot=$condi[1];
								$mot=str_replace(" ","% ",$mot);
								$condition+=array($condi[0].' like '=>$mot);
								$conditionstring2==""?$conditionstring2.="$condi[0] like '$condi[1]'":$conditionstring2.=" and $condi[0] like '$condi[1]'";			
							}
							else if(count(($condi=split(" IN ",$filters2[$i])))>1){
								$mot=str_replace(";",",",$condi[1]);
								$motarray=explode(",",$mot);
								
								$func = function($value) {
									return "'".trim($value)."'";
								};	
								$motarray = array_map($func, $motarray);
								$mot=implode(" , ", $motarray);
								$condition+=array("$condi[0]  IN "."(".$mot.")");
								$conditionstring2==""?$conditionstring2.="$condi[0] IN ($mot)":$conditionstring2.=" and $condi[0] IN ($mot)";			
							}	
						}
						$filters2=$this->params['url']['filter'];	
					}
					
					$export=false;
					//check if it's export call
					if(isset($this->params['url']['export']) && $this->params['url']['export']!=""){
						$export=true;
						$top="";
					}					
					if(isset($this->request->params['export'])){
						$export=true;
						$top="";
					}

					//ns grid order	
					$orderstring="";
					$sort_column=$fields[0];					
					$sort_dir="asc";
					$orderstring="ORDER BY (SELECT NULL)";
					if(isset($this->params['url']['sortColumn']) &&  $this->params['url']['sortColumn']!=""){
						if(isset($this->params['url']['sortOrder']) && $this->params['url']['sortOrder']!="")
							$sort_dir= $this->params['url']['sortOrder'];
						$sort_column=$this->params['url']['sortColumn'];
						$orderstring="ORDER BY $sort_column $sort_dir";
					}
					
					//count
					if($count){
						$result=$this->MapSelectionManager->find('count',array(
							'conditions'=>array_merge(array()+$condition))
						);
						$find=2;
					}
					//DATATABLEJS
					else if(isset($tmp_format) && $tmp_format=="datatablejs"){
						$sEcho=1;
						$total=$this->MapSelectionManager->find('count');
						$this->set('total',$total);
						
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
						
						
						//column sort
						if(isset($this->params['url']['iSortCol_0']) &&  $this->params['url']['sSortDir_0']){
							$index_col=intval($this->params['url']['iSortCol_0']);
							$sort_dir= $this->params['url']['sSortDir_0'];
							$sort_column=$fields[$index_col];
						}
						
						$count=$this->MapSelectionManager->find('count',array(
							'conditions'=>$condition
						));
						$this->set('totaldisplay',$count);

						$result=$this->MapSelectionManager->find('all',array(
							'fields'=>$fields,
							'order'=> array("$sort_column $sort_dir"),
							'limit'=>$limit,
							'offset'=>$offset,
							'conditions'=>array()+$condition
						));	
						//$this->MapSelectionManager->gpx_save($result,$gpx_name);
						$this->set('sEcho',$sEcho);
						$find=1;
						if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
							$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');
							$uri=$_SERVER['REQUEST_URI'];
							$uri=split("/",$uri);
							$app_name=$uri[1];
							$app_name.='/'.$uri[2];
							fwrite($fp,print_r($result,true));
						}
					}
					//round cluster
					else if($round!=""){
						$roundlat=
						$fields=array("round(LAT,$round) as LAT","round(LON,$round) as LON","count(*) as nb");
						$result=$this->MapSelectionManager->find('all',array(
							'fields'=>$fields,
							'limit'=>$limit,
							'offset'=>$offset,
							'group'=>array("round(LAT,$round)","round(LON,$round)"),
							'conditions'=>array()+$condition
						));	
						$this->set('result',$result);
						$this->set('table_name',$table_name);
						$find=1;
					}
					//map and ns grid
					else{
						//old method without rowcount field
						//$condition[]=array("row = 11");
						//print_r($condition);
						/*$result=$this->MapSelectionManager->find('all',array(
							'limit'=>$limit,
							'offset'=>$offset,
							'fields'=>$fields,
							'conditions'=>array()+$condition)
						);*/
						
						//$conditionstring2=implode(" and ", $filters);
						//print_r($conditionstring2);
						if($conditionstring2!="" && $latlonnull!="")
							$conditionstring2="and $conditionstring2";
						else if($conditionstring2!="" && $latlonnull=="")
							$conditionstring2="where $conditionstring2";
						//print_r($conditionstring2);

						$func = function($value) {
							return "[".$value."]";
						};	
						
						$fieldmapped = array_map($func, $fields);
						$fieldsstring=implode(" , ", $fieldmapped);
						$result=$this->MapSelectionManager->query("SELECT distinct $top * FROM ( 
						SELECT ROW_NUMBER() OVER ($orderstring) AS Id, $fieldsstring 
						FROM [$table_name] AS [MapSelectionManager] $latlonnull $conditionstring2 ) AS _cake_paging_ 
						$agrwhere $offs $rowstring 
						");
						$total=$this->MapSelectionManager->find('count',array(
							'fields'=>$fields,
							'conditions'=>array()+$condition)
						);
						
						$this->set('totaldisplay',$total);
						$this->set('ModelName','MapSelectionManager');
						if($export){
							$exportfilter="";
							if($filters2=="" && $bbox!="")
								$exportfilter="bbox: $bbox";
							else if($filters2!="" && $bbox=="")
								$exportfilter=$filters2;
							else if($filters2!="" && $bbox!="")	
								$exportfilter="$filters2, \nbbox:".$bbox;
								
							if(count($result)>0)
								$this->MapSelectionManager->export_save($result,$gpx_name,$table_name,$exportfilter);
							$gpx_array=array('gpx_url'=>$gpx_url);
							$find=3;	
						}
						else	
							$find=1;
					}					
					
					$this->set('result',$result);
					$this->set('table_name',$table_name);
				}	
			}	
			
			$this->set('find',$find);
			$this->set('debug',$debug);
			// Set response as $format
			$this->RequestHandler->respondAs($format);
			// $this->RequestHandler->respondAs("html");
			if(isset($tmp_format) && $tmp_format=="datatablejs") //datatatable view
					$this->viewPath .= '/'."datatablejs";
			else if(isset($tmp_format) && $tmp_format=="geojson"){ //geojson view
				$this->viewPath .= '/'."geojson";
				
				$minlat=1000;
				$minlon=1000;
				$maxlat=-1000;
				$maxlon=-1000;
				//bbox creation
				foreach($result as $s){
					$thislat=$s[0]['LAT'];
					$thislon=$s[0]['LON'];
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
				
				if($cluster=="yes"){
					//$cartomodel=new CartoModel();
					$this->set('cluster',true);
					$result=$this->MapSelectionManager->cluster($result,20,$zoom);
					
					
					
					$this->set('result',$result);
					//print_r($result);
				}	
			}
			else
				$this->viewPath .= '/'.$format;
			$this->layout = $format;
			$this->layoutPath = $format;
				
		}
				
		function gpx_url(){
			//creation of the gpx's url
			$gpx_name=$this->gpx_name;
			if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$uri=$_SERVER['REQUEST_URI'];
				$uri=split("/",$uri);
				$app_name=$uri[1];
				$app_name.='/'.$uri[2];
				$gpx_url=$_SERVER['HTTP_HOST'].'/'.$app_name.'/gps/'.$gpx_name.".gpx";				
			}
			else{
				$uri=$_SERVER['REQUEST_URI'];
				$uri=split("/",$uri);
				$app_name=$uri[1];
				$gpx_url=$_SERVER['HTTP_HOST'].'/'.$app_name.'/gps/'.$gpx_name.".gpx";
			}
			$this->set("result",$gpx_url);
			$this->RequestHandler->respondAs("json");
			$this->viewPath .= '/'."json";
			$this->layout = "json";
			$this->layoutPath = "json";
		}
		
		function detail_view(){
			$table_name="";
			$this->loadModel('MapSelectionManager');			
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
			
			//get the view name
			if(isset($this->params['url']['table_name']) && $this->params['url']['table_name']!=""){
				$table_name=$this->params['url']['table_name'];
			}
			
			if(isset($this->request->params['table_name']) && $this->request->params['table_name']!="")
				$table_name=$this->request->params['table_name'];
			
			$table_name=str_replace(" ","",$table_name);
			if($table_name!="")
				$this->MapSelectionManager->setSource($table_name);
				
			$schema=$this->MapSelectionManager->schema();
			$schema=array_merge(array(""=>""),$schema);
			$this->set('schema',$schema);
			$this->set('table_name',$table_name);
			
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;
			
		}		
	}

?>