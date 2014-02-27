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
	function filter_create($ca,$place,$region,$date,$min_date,$max_date,$fieldactivity,$datatablesearch,$taxon_name,$date_name,$autocomplete,$currentdate=null){
		$condition_array=$ca;
		//take place parameter for a place filter
		if(isset($place) && $place!="" && $place!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(!$autocomplete || (strlen($place)>0 && $place[sizeof($place)-1]=="\"" && $place[strlen($place)-1]=="\"")){
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
			if(!$autocomplete || (strlen($region)>0 && $region[sizeof($region)-1]=="\"" && $region[strlen($region)-1]=="\"")){
				$like="";
			}	
			else
				$region="%".$region."%";
			$condition_array+=array("Region $like"=>$region);	
		}	
		
		//take taxonsearch parameter for a taxon filter
		if(isset($taxon_name) && $taxon_name!=""){
			if(!$autocomplete)
				$condition_array+=array("Name_Taxon LIKE"=>"%".$taxon_name."%");
			else
				$condition_array+=array("Name_Taxon"=>$taxon_name);
		}
		
		//fieldactivity filter 
		if(isset($fieldactivity) && $fieldactivity!="" && $fieldactivity!="null"){
			if(!$autocomplete){
				$fieldactivity="%".$fieldactivity."%";
				$condition_array+=array("FieldActivity_Name LIKE"=>$fieldactivity);
			}
			else
				$condition_array+=array("FieldActivity_Name"=>$fieldactivity);
		}
		
		//date filter
		if(isset($date) && $date!=""){
			date_default_timezone_set('UTC');
			$idate=$date;
			$idate=$date;
			$m=date("m");
			$d=date("d");
			$y=date("Y");
			if($currentdate)
				list($y,$m,$d)=explode("-",$currentdate);	
			$today = date("Y-m-d",mktime(0,0,0,$m,$d,$y));
			if($idate=="week"){				
				$condition_array[]=array("CONVERT(char(10),DATE,120) >= CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, cast('$today' as date))/7, 0), 120)",
				"CONVERT(char(10),DATE,120) <= CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, cast('$today' as date))/7, 6),120)");
			}
			else if($idate=="month"){
				$currentmonth = date("Y-m",mktime(0,0,0,$m,$d,$y));
				$condition_array+=array("CONVERT(char(7), DATE, 120) ="=>$currentmonth);
			}
			else if($idate=="year"){				
				$currentyear = date("Y",mktime(0,0,0,$m,$d,$y));
				$condition_array+=array("CONVERT(char(4), DATE, 120) ="=>$currentyear);
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
				if($datearr=="")
					$datearr=$today;
				
				if($datedep=="")
					$condition_array+=array("CONVERT(VARCHAR, DATE, 120) <="=>$datearr);
				else	
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
				$pk_condition_arr=array("TSta_PK_ID $like" => $pk_search);
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
	
	
	//Create a condition array with pamameter for the find method of model. Work with the taxon table. 
	function taxon_filter($condition_array,$id_taxon,$ID_HIGHER_TAXON,$ID_NAME
			,$NAME_WITH_AUTHORITY,$AUTHORITY,$NAME_WITHOUT_AUTHORITY,$NAME_VALID,$NOM_VERN_FR,$NOM_VERN_ENG,$NOM_VERN_FR
			,$KINGDOM,$PHYLUM,$CLASS,$ORDER,$FAMILY,$RANK,$TAXREF_CD_NOM,$TAXREF_CD_TAXSUP,$TAXREF_CD_REF
			,$autocomplete){
		if($id_taxon!="")
			$condition_array+=array("ID_Taxon"=>$id_taxon);
		
		if($ID_HIGHER_TAXON!=""){
			if(!$autocomplete){
				$ID_HIGHER_TAXON="%".$ID_HIGHER_TAXON."%";
				$condition_array+=array("ID_HIGHER_TAXON LIKE"=>$ID_HIGHER_TAXON);
			}
			else
				$condition_array+=array("ID_HIGHER_TAXON"=>$ID_HIGHER_TAXON);
		}	
		
		if($ID_NAME!=""){
			if(!$autocomplete){
				$ID_NAME="%".$ID_NAME."%";
				$condition_array+=array("ID_NAME LIKE"=>$ID_NAME);
			}
			else
				$condition_array+=array("ID_NAME"=>$ID_NAME);
		}
		
		if($NAME_WITH_AUTHORITY!=""){
			if(!$autocomplete){
				$NAME_WITH_AUTHORITY="%".$NAME_WITH_AUTHORITY."%";
				$condition_array+=array("NAME_WITH_AUTHORITY LIKE"=>$NAME_WITH_AUTHORITY);
			}
			else
				$condition_array+=array("NAME_WITH_AUTHORITY"=>$NAME_WITH_AUTHORITY);
		}
		
		if($AUTHORITY!=""){
			if(!$autocomplete){
				$AUTHORITY="%".$AUTHORITY."%";
				$condition_array+=array("AUTHORITY LIKE"=>$AUTHORITY);
			}
			else
				$condition_array+=array("AUTHORITY"=>$AUTHORITY);
		}
		
		if($NAME_WITHOUT_AUTHORITY!=""){
			if(!$autocomplete){
				$NAME_WITHOUT_AUTHORITY="%".$NAME_WITHOUT_AUTHORITY."%";
				$condition_array+=array("NAME_WITHOUT_AUTHORITY LIKE"=>$NAME_WITHOUT_AUTHORITY);
			}
			else
				$condition_array+=array("NAME_WITHOUT_AUTHORITY"=>$NAME_WITHOUT_AUTHORITY);
		}
		
		if($NAME_VALID!=""){
			if(!$autocomplete){
				$NAME_VALID="%".$NAME_VALID."%";
				$condition_array+=array("NAME_VALID LIKE"=>$NAME_VALID);
			}
			else
				$condition_array+=array("NAME_VALID"=>$NAME_VALID);
		}
		
		if($NOM_VERN_FR!=""){
			if(!$autocomplete){
				$NOM_VERN_FR="%".$NOM_VERN_FR."%";
				$condition_array+=array("NOM_VERN_FR LIKE"=>$NOM_VERN_FR);
			}
			else
				$condition_array+=array("NOM_VERN_FR"=>$NOM_VERN_FR);
		}
		
		if($NOM_VERN_ENG!=""){
			if(!$autocomplete){
				$NOM_VERN_ENG="%".$NOM_VERN_ENG."%";
				$condition_array+=array("NOM_VERN_ENG LIKE"=>$NOM_VERN_ENG);
			}
			else
				$condition_array+=array("NOM_VERN_ENG"=>$NOM_VERN_ENG);
		}
		
		if($KINGDOM!=""){
			if(!$autocomplete){
				$KINGDOM="%".$KINGDOM."%";
				$condition_array+=array("KINGDOM LIKE"=>$KINGDOM);
			}
			else
				$condition_array+=array("KINGDOM"=>$KINGDOM);
		}
		
		if($PHYLUM!=""){
			if(!$autocomplete){
				$PHYLUM="%".$PHYLUM."%";
				$condition_array+=array("PHYLUM LIKE"=>$PHYLUM);
			}
			else
				$condition_array+=array("PHYLUM"=>$PHYLUM);
		}
		
		if($CLASS!=""){
			if(!$autocomplete){
				$CLASS="%".$CLASS."%";
				$condition_array+=array("CLASS LIKE"=>$CLASS);
			}
			else
				$condition_array+=array("CLASS"=>$CLASS);
		}
		
		if($ORDER!=""){
			if(!$autocomplete){
				$ORDER="%".$ORDER."%";
				$condition_array+=array("ORDER LIKE"=>$ORDER);
			}
			else
				$condition_array+=array("ORDER"=>$ORDER);
		}	

		if($FAMILY!=""){
			if(!$autocomplete){
				$FAMILY="%".$FAMILY."%";
				$condition_array+=array("FAMILY LIKE"=>$FAMILY);
			}
			else
				$condition_array+=array("FAMILY"=>$FAMILY);
		}	
		
		if($RANK!=""){
			if(!$autocomplete){
				$RANK="%".$RANK."%";
				$condition_array+=array("RANK LIKE"=>$RANK);
			}
			else
				$condition_array+=array("RANK"=>$RANK);
		}
		
		if($TAXREF_CD_NOM!=""){
			if(!$autocomplete){
				$TAXREF_CD_NOM="%".$TAXREF_CD_NOM."%";
				$condition_array+=array("TAXREF_CD_NOM LIKE"=>$TAXREF_CD_NOM);
			}
			else
				$condition_array+=array("TAXREF_CD_NOM"=>$TAXREF_CD_NOM);
		}
		
		if($TAXREF_CD_TAXSUP!=""){
			if(!$autocomplete){
				$TAXREF_CD_TAXSUP="%".$TAXREF_CD_TAXSUP."%";
				$condition_array+=array("TAXREF_CD_TAXSUP LIKE"=>$TAXREF_CD_TAXSUP);
			}
			else
				$condition_array+=array("TAXREF_CD_TAXSUP"=>$TAXREF_CD_TAXSUP);
		}
		
		if($TAXREF_CD_REF!=""){
			if(!$autocomplete){
				$TAXREF_CD_REF="%".$TAXREF_CD_REF."%";
				$condition_array+=array("TAXREF_CD_REF LIKE"=>$TAXREF_CD_REF);
			}
			else
				$condition_array+=array("TAXREF_CD_REF"=>$TAXREF_CD_REF);
		}
		
		return $condition_array;
	}
	
	
	//create condition array for station
	function station_filter($db,$condition_array,$locality,$area,$name,$fa,$lat,$lon,$date,$autocomplete){
		
		if(isset($locality) && $locality!="" && $locality!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(!$autocomplete || (strlen($locality)>0 && $locality[sizeof($locality)-1]=="\"" && $locality[strlen($locality)-1]=="\"")){
				$like="";
			}	
			else
				$locality="%".$locality."%";
			$condition_array+=array("Locality $like"=>$locality);
		}
		//take area parameter for a area filter
		if(isset($area) && $area!="" && $area!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(!$autocomplete || (strlen($area)>0 && $area[sizeof($area)-1]=="\"" && $area[strlen($area)-1]=="\"")){
				$like="";
			}	
			else
				$area="%".$area."%";
			//$condition_array[]=array("Area $like"=>$area);	
		}	
		
		if(isset($name) && $name!="" && $name!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(!$autocomplete || (strlen($name)>0 && $name[sizeof($name)-1]=="\"" && $name[strlen($name)-1]=="\"")){
				$like="";
			}	
			else
				$name="%".$name."%";
			$condition_array+=array("Name $like"=>$name);
		}
		
		if(isset($fa) && $fa!="" && $fa!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(!$autocomplete || (strlen($fa)>0 && $fa[sizeof($fa)-1]=="\"" && $fa[strlen($fa)-1]=="\"")){
				$like="";
			}	
			else
				$fa="%".$fa."%";
			$condition_array+=array("Name_FieldActivity $like"=>$fa);
		}
		
		if(isset($lat) && $lat!="" && $lat!="null"){
			$condition_array+=array("LAT"=>$lat);
		}
		
		if(isset($lon) && $lon!="" && $lon!="null"){
			$condition_array+=array("LON"=>$lon);
		}
		
		if(isset($fa) && $fa!="" && $fa!="null"){
			$like="LIKE";
			//verify if its a like research or not		
			if(!$autocomplete || (strlen($fa)>0 && $fa[sizeof($fa)-1]=="\"" && $fa[strlen($fa)-1]=="\"")){
				$like="";
			}	
			else
				$fa="%".$fa."%";
			$condition_array+=array("Name_FieldActivity $like"=>$fa);
		}
		if(isset($date) && $date!=""){
			date_default_timezone_set('UTC');
			$idate=$date;			
			$today = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
			if($idate=="week"){				
				$condition_array+=array("CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, getdate())/7, 0), 120) <="=>$today,
				"CONVERT(char(10), DATEADD(week, DATEDIFF(day, 0, getdate())/7, 5),120 >="=>$today);
			}
			else if($idate=="month"){
				$currentmonth = date("Y-m",mktime(0,0,0,date("m"),date("d"),date("Y")));
				$condition_array+=array("CONVERT(char(7), DATE, 120) ="=>$currentmonth);
			}
			else if($idate=="year"){
				
				$currentyear = date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")));
				$condition_array+=array("CONVERT(char(4), DATE, 120) >="=>$currentyear);
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
		
		return $condition_array;
	}
	
	//return true if one column name is in a table
	function column_exist($table_name,$column_name_array,$db){
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r($bd,true));
		$model= new Model($table_name,str_replace(" ","",$table_name),$db);
		
		foreach ($model->schema() as $key=>$val){
			if(in_array($key,$column_name_array)){
				return true;
			}
		}
		
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'a');		
		//fwrite($fp, print_r("tablename:".$table_name."//",true));
		return false;
	}
	
	//creation of attribut for geojson point from an array of field => value
	function create_geojson_attribut($data){
		$i=0;
		$attrs="";
		foreach($data as $key=>$val){
			$i==0?$attrs.='"'.$key.'":"'.$val.'"':$attrs.=',"'.$key.'"'.':"'.$val.'"';
			$i++;
		}
		return $attrs;
	}
}
