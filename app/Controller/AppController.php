<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Model', 'Model');
App::uses('AppModel', 'Model');
App::uses('Value', 'Model');	
App::uses('Taxon', 'Model');
App::uses('Taxon_Name', 'Model');
App::uses('Taxon_Addi', 'Model');
App::uses('Taxon', 'Model');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $helpers = array('Xml', 'Text','form','html','Cache','Json');
	public $components = array('RequestHandler','Cookie','Session');
	var $typereturn;
	public $notauth=true;	
	public $admin=false;
	public $cacheAction = array(  //set the method(webservice) with a cached result
		//'proto_list' => cache_time,
		//'station_get' => cache_time,  
		//'proto_taxon_get' => cache_time,
		//'proto_get' => cache_time
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
			$nb="";
			
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
				if(count($fields)>1 && ($table_name=="TTaxa_Name" || $table_name=="TTaxa")){
					$rankname="RANK";
					if($table_name=="TTaxa_Name")
						$rankname="TTaxaJoin.RANK";
					$array_conditions[]=array("(($rankname != 'CL' and $rankname  != 'FM' and $rankname  != 'OR' and $rankname  != 'KD' and $rankname  != 'PH') or 
					($rankname != 'Classe' and $rankname  != 'Famille' and $rankname  != 'Ordre' and $rankname  != 'Règne' and $rankname  != 'Phylum'))");
				}
				if($count){
					$nb=$model->find("count",array(
									'fields'=>$field_array,
									'group'=>$field_array,
									'conditions'=>$array_conditions)+$options
									);	
					$this->set('count',"");				
				}				
				else if($table_name=="TTaxa_Name"){
					/*print_r(array(
									'fields'=>$field_array,
									'order'=>"$column_name asc",
									'group'=>$field_array,
									'conditions'=>$array_conditions,
									'limit'=>$limit,
									'offset'=>intval($offset)
									)+$options);
					print_r($this->request->params);*/
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
					$this->set("result",$model_result);	
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
					$this->set("result",$model_result);	
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
			if(($table_name=="TTaxa_Name" && $column_name=="NAME_WITHOUT_AUTHORITY") || ($table_name=="TTaxa" && $column_name=="NAME_VERN_FR")){
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
}
