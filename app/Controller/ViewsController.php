<?php
	class ViewsController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);
		public $gpx_name ="data";
		function index(){
			
		}	
		
		//Return a list of theme view  
		function themes_list(){
			$this->loadModel('MapSelectionManager');
			$this->MapSelectionManager->setSource("TThemeEtude");
			//$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
			
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
			
			//$date_name=array("DATE","StaDate","lastArgosDate");
			//$model->column_exist("V_Qry_VGroups_AllTaxons_EnjilDamStations",$date_name);
			//$table = $model->find("all",array('order'=> array("TSMan_Layer_Name asc"))+$conditions);				
			$table = $this->MapSelectionManager->find("all",array(
												'fields'=>array('TProt_PK_ID','Caption'),	
												'order'=> array("Caption asc"),
												'group'=>array('Caption','TProt_PK_ID')
												)+$conditions+$options
			);				
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
			//$model = new AppModel("TMapSelectionManager","TMapSelectionManager",base);	
			
			//format from request
			if(stripos($this->request->header('Accept'),"application/xml")!==false)
				$format="xml"; 
			else if(stripos($this->request->header('Accept'),"application/json")!==false)
				$format="json";	
			
			if(isset($this->params['url']['id_theme']) && $this->params['url']['id_theme']!=""){
				$id_theme=$this->params['url']['id_theme'];
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
			$table = $this->MapSelectionManager->find("all",array('order'=> array("TSMan_Layer_Name asc"))+$conditions);				
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
			$limit=0;
			$offset=0;
			$gpx_name=$this->gpx_name;
			$gpx_url="";
			$cluster="no";
			
			//creation of the gpx's url
			if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
				$uri=$_SERVER['REQUEST_URI'];
				$uri=split("/",$uri);
				$app_name=$uri[1];
				$app_name.='/'.$uri[2];
				$gpx_url=$_SERVER['HTTP_HOST'].'/'.$app_name.'/gps/'.$gpx_name.".gpx";				
			}
			
			if(isset($this->params['url']['cluster']) && $this->params['url']['cluster']!=""){
				if($this->params['url']['cluster']=="yes"){
					$cluster="yes";
				}
			}

			//zoom param for cluster	
			if(isset($this->params['url']['zoom']) && $this->params['url']['zoom']!="")
				$zoom=$this->params['url']['zoom'];	
			
			$this->set('gpx_url',$gpx_url);
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
			
			if(isset($this->params['url']['limit']) && $this->params['url']['limit']!=""){
				$limit=$this->params['url']['limit'];
			}
			
			if(isset($this->params['url']['offset']) && $this->params['url']['offset']!=""){
				$offset=intval($this->params['url']['offset']);
			}
			
			//BBOX param if map call
			if(isset($this->params['url']['bbox']) && $this->params['url']['bbox']!=""){
				$bbox=$this->params['url']['bbox'];
				$bbox_array=split(",",$bbox);
				$min_lon=$bbox_array[0];
				$max_lon=$bbox_array[2];
				$min_lat=$bbox_array[1];
				$max_lat=$bbox_array[3];
				$condition = array("LAT >= $min_lat and LAT <= $max_lat and LON >= $min_lon and LON <= $max_lon");
			}
						
			//take the table name parameter
			if(isset($this->params['url']['table_name']) && $this->params['url']['table_name']!=""){
				$table_name=$this->params['url']['table_name'];
			}
			
			if(isset($this->request->params['table_name']) && $this->request->params['table_name']!="")
				$table_name=$this->request->params['table_name'];
			
			//check if it's a count request
			if(isset($this->params['url']['count']) && $this->params['url']['count']!=""){
				$count=true;
			}
			
			if(isset($this->request->params['count']))
				$count=true;
			
			$table_name=str_replace(" ","",$table_name);
			if($table_name!=""){
				try{
					$this->MapSelectionManager->setSource($table_name);
					$this->set('model',$this->MapSelectionManager);
					$schema=$this->MapSelectionManager->schema();
					$fields=array_keys($schema); 
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
					$this->set('schema',$fields);	
				}catch(Exception $e){
					$find=-1;
				}
				if($find==0){
					//create a condition array with filters
					if(isset($this->params['url']['filters']) && $table_name!=""){
						$filters=$this->params['url']['filters'];
						
						//add filters on the array condition
						$filters=split(",",$filters);
						for($i=0;$i<count($filters);$i++){
							if(count(($condi=split("<=",$filters[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate')
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' <='=>$condi[1]);	
								else
									$condition+=array($condi[0].' <='=>$condi[1]);							
							}
							else if(count(($condi=split(">=",$filters[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate')
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' >='=>$condi[1]);	
								else
									$condition+=array($condi[0].' >='=>$condi[1]);							
							}
							else if(count(($condi=split(">",$filters[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate')
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' >'=>$condi[1]);	
								else
									$condition+=array($condi[0].' >'=>$condi[1]);							
							}
							else if(count(($condi=split("<",$filters[$i])))>1){
								if($condi[0]=='DATE' || $condi[0]=='Date' || $condi[0]=='StaDate')
									$condition+=array("CONVERT(nchar(200),$condi[0],120)".' <'=>$condi[1]);	
								else
									$condition+=array($condi[0].' <'=>$condi[1]);							
							}
							else if(count(($condi=split("=",$filters[$i])))>1){
								$condition+=array($condi[0]=>$condi[1]);							
							}	
							else if(count(($condi=split(" LIKE ",$filters[$i])))>1){
								$mot=$condi[1];
								$mot=str_replace(" ","% ",$mot);
								$condition+=array($condi[0].' like '=>'%'.$mot.'%');							
							}	
						}								
					}
					
					$sort_column=$fields[0];
					$sort_dir="asc";
					if($count){
						$result=$this->MapSelectionManager->find('count',array(
							'conditions'=>array()+$condition)
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
					else{		
						$result=$this->MapSelectionManager->find('all',array(
							'limit'=>$limit,
							'offset'=>$offset,
							'fields'=>$fields,
							'conditions'=>array()+$condition)
						);
						$this->MapSelectionManager->gpx_save($result,$gpx_name);
						$gpx_array=array('gpx_url'=>$gpx_url);
						//$result=array_merge($result, $gpx_array);
						
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
			if(isset($tmp_format) && $tmp_format=="datatablejs") //datatatable view
					$this->viewPath .= '/'."datatablejs";
			else if(isset($tmp_format) && $tmp_format=="geojson"){ //geojson view
				$this->viewPath .= '/'."geojson";
				if($cluster=="yes"){
					$cartomodel=new CartoModel();
					$result=$cartomodel->cluster($result,20,$zoom);
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
			
			$this->set('schema',$schema);
			$this->set('table_name',$table_name);
			
			$this->RequestHandler->respondAs($format);
			$this->viewPath .= "/".$format;
			$this->layout = $format;
			$this->layoutPath = $format;
			
		}		
	}

?>