<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	var $actsAs = array("Containable"); 

	public function __construct($id = false, $table = null, $ds = null) { 
        parent::__construct($id, $table, $ds); 
        $this->dom = new DOMDocument; 
        if (isset($this->data[get_class($this)]["xml"])) { 
            $this->dom->LoadXML($this->data[get_class($this)]["xml"]); 
        } 
    } 	
	//for debugging create file on C:\ 
	function filedebug($string,$filename="debug"){
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/$filename", 'w');
		fwrite($fp, $string."\n");
	}
	
	//return a JSON file	
	function get_file($filename){
		$string=file_get_contents($filename);
		$json=json_decode($string, true);
		return $json;
	}
	
	//Create a condition array with pamameter for the find method of model 
	function filter_create($ca,$place,$region,$date,$min_date,$max_date,$fieldactivity,$datatablesearch,$taxon_name){
		$condition_array=$ca;
		//take place parameter for a place filter
		if(isset($place) && $place!="" && $place!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(strlen($place)>0 && $place[sizeof($place)-1]=="\"" && $place[strlen($place)-1]=="\""){
				$like="";
			}	
			else
				$place="%".$place."%";
			$condition_array+=array("Place $like"=>$place);
		}
		
		//take region parameter for a region filter
		if(isset($region) && $region!="" && $region!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(strlen($region)>0 && $region[sizeof($region)-1]=="\"" && $region[strlen($region)-1]=="\""){
				$like="";
			}	
			else
				$region="%".$region."%";
			$condition_array+=array("Region $like"=>$region);	
		}	
		
		//take taxonsearch parameter for a taxon filter
		if(isset($taxon_name) && $taxon_name!=""){
			$condition_array+=array("Name_Taxon LIKE"=>"%".$taxon_name."%");
		}
		
		//fieldactivity filter 
		if(isset($fieldactivity) && $fieldactivity!="" && $fieldactivity!="null"){
			$like="LIKE";
			$fieldactivity="%".$fieldactivity."%";
			$condition_array+=array("FieldActivity_Name $like"=>$fieldactivity);
		}
		
		//date filter
		if(isset($date) && $date!=""){
			date_default_timezone_set('UTC');
			$idate=$date;
			if($idate=="hier"){
				$yesterday = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
				$condition_array+=array("CONVERT(VARCHAR, DATE, 120) LIKE"=>"%".$yesterday."%");
			}
			else if($idate=="2ans"){
				$twoyear = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-2));
				$condition_array+=array("CONVERT(VARCHAR, DATE, 120) >="=>$twoyear);
			}
			else if($idate=="1ans"){
				$twoyear = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")-1));
				$condition_array+=array("CONVERT(VARCHAR, DATE, 120) >="=>$twoyear);
			}
			else if(stripos($idate,";")!==false){
				$idatearray=split(";",$idate);
				$datedep=$idatearray[0];
				$datearr=$idatearray[1];
				//complete the date if it's not complete
				if(substr_count($datedep, '-')==0){
					$datedep.="-01-01";
					$datearr.="-12-31";
				}
				else if(substr_count($datedep, '-')==1){
					$datedep.="-01";
					$datearr.="-31";
				}
				$condition_array+=array("CONVERT(VARCHAR, DATE, 120) >="=>$datedep,"CONVERT(VARCHAR, DATE, 120) <="=>$datearr);
			}
		}
		
		//take min-date parameter for a min-date filter (from ecoreleve-explorer)
		if(isset($min_date) && $min_date!="" && $min_date!="null"){
			$datedep=$min_date;
			$condition_array+=array("CONVERT(VARCHAR, $date_name, 120) >="=>$datedep);
			
			//take max-date parameter for a max-date filter when min date is set because when we have no date only min-date is empty
			if(isset($max_date) && $max_date!="" && $max_date!="null"){
				$datearr=$max_date;
				$condition_array+=array("CONVERT(VARCHAR, $date_name, 120) <="=>$datearr);
			}
		}	
		
		//create the condition array from a search of datatable js default input search
		if(isset($datatablesearch) && $datatablesearch!=""){
			$search=$datatablesearch;
			$like="LIKE";
			$left_p="%";
			$right_p="%";
			$column_search="";				
			//if we choose to search only in column and also see if it's not a date because of ":"
			if(stripos($search,":")!==false && !preg_match('/(\d+)-(\d+)-(\d+) ((\d+):){1,2}(\d+)/', $search) && !preg_match('/((\d+):){1,2}(\d+)/', $search)){
				$arraysearch=split(":",$search,2);
				$column_search=$arraysearch[0];
				$search=$arraysearch[1];
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
			//if column search fill the variables
			if(in_array($Stationjoinstringnamedot.$column_search,$column_array)){
				switch($column_search){
					case "TSta_PK_ID":$fa_search="";$n_search="";$d_search="";$condition_array+=array("TSta_PK_ID $like" => $pk_search);break;
					case "FieldActivity_Name":$pk_search="";$n_search="";$d_search="";$condition_array+=array("FieldActivity_Name $like" => $fa_search);break; 
					case "Name":$fa_search="";$pk_search="";$d_search="";$condition_array+=array("Name $like" => $n_search);break; 
					case "DATE":$fa_search="";$n_search="";$pk_search="";$condition_array+=array("CONVERT(VARCHAR, DATE, 120) $like" => $d_search);break; 	
				}
			}
			else{
				$condition_array+= array('or'=>array(														
													"FieldActivity_Name $like" => $fa_search,
													"Name $like" => $n_search,
													"CONVERT(VARCHAR, DATE, 120) $like" => $d_search
													)+$pk_condition_arr
												);
			}
			
			
		}
			
		return $condition_array;	
	}
}
