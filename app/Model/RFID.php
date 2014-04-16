<?php
class RFID extends AppModel {
	public $useDbConfig = 'ereleveSensor';
	public $useTable = 'RFID';
	function import_txt($filename,$id,$filetype=null){
		// print_r($filename." ".$id." ".$filetype);
		set_time_limit (300);
		$withheader=false;
		$handle = fopen($filename, "r");
		$i=0;
		$result=array();
		$savearray=array();
		$separator="";
		$margeerreur=0;
		$trimarray = function($val){
			return trim($val);
		};
		
		
		
		while (($row = fgets($handle)) !== FALSE) {	
			$ishead=false;	
			//$row=trim($row); //field count problem if uncomment
			//get file type					
			if($separator=="" && count(split("\t",$row))>2)
				$separator="\t";
			else if($separator=="")	
				$separator=";";
			
			
			$rowarray=array_map($trimarray,split($separator,$row));
			if($i==0){
				$fieldtype1=array("NB"=>"no","TYPE"=>"type",'"PUCE "'=>"code","DATE"=>"no","TIME"=>"no");
				$fieldtype2=array("#"=>"no","Transponder Type:"=>"type","Transponder Code:"=>"code","Date:"=>"no","Time:"=>"no",
					"Event:"=>"Event","Unit #:"=>"Unit","Antenna #:"=>"Antenna","Memo:"=>"Memo","Custom:"=>"Custom");
				$fieldtype3=array("Transponder Type:"=>"type","Transponder Code:"=>"code","Date:"=>"no","Time:"=>"no",
					"Event:"=>"Event","Unit #:"=>"Unit","Antenna #:"=>"Antenna","Memo:"=>"Memo","Custom:"=>"Custom");					
				//type with header
				if($filetype=="1" || array_keys($fieldtype1)==$rowarray){
					$separator="\t";
					//csv field
					$field=array("NB","TYPE",'"PUCE "',"DATE","TIME");
					$field_label=array("no","Type","Code","no","no");
					//field valid function array
					$validator=array("no","validType","valideCode","validDateFile","validTimeFile");
				}
				else if($filetype=="2" || array_keys($fieldtype2)==array_slice($rowarray,0,count($fieldtype2))){
					$separator=";";
					$margeerreur=0;
					//csv field
					$field=array("#","Transponder Type:","Transponder Code:","Date:","Time:",
					"Event:","Unit #:","Antenna #:","Memo:","Custom:");
					$field_label=array("no","Type","Code","no","no","no","no","no","no","no");
					//field valid function array
					$validator=array("no","validType","valideCode","validDateFile","validTimeFile","no","no","no","no","no");	
				}	
				else if($filetype=="3" || array_keys($fieldtype3)==array_slice($rowarray,0,count($fieldtype3))){
					$separator="\t";
					if(count($fieldtype3)!=count($rowarray))
						$margeerreur=count($rowarray)-count($fieldtype3);
					//csv field
					$field=array("Transponder Type:","Transponder Code:","Date:","Time:",
					"Event:","Unit #:","Antenna #:","Memo:","Custom:");
					$field_label=array("Type","Code","no","no","no","no","no","no","no");
					//field valid function array
					$validator=array("validType","valideCode","validDateFile","validTimeFile","no","no","no","no","no");	
				}
				//without header type
				else {
					if($separator=="" && count(split("\t",$row))>2)
						$separator="\t";
					else if($separator=="")	
						$separator=";";
					if($separator==";"){	
						//csv field
						$field=array("#","Transponder Type:","Transponder Code:","Date:","Time:",
						"Event:","Unit #:");
						$field_label=array("no","Type","Code","no","no","no","no");
						//field valid function array
						$validator=array("no","validType","valideCode","validDateFile","validTimeFile","no","no");	
					}	
					else{
						$separator="\t";
						//csv field
						$field=array("NB","TYPE",'"PUCE "',"DATE","TIME");
						$field_label=array("no","Type","Code","no","no");
						//field valid function array
						$validator=array("no","validType","valideCode","validDateFile","validTimeFile");
					}					
				}				
			}		

			//check if it's header	
			$intersectfield=array_intersect($rowarray,$field);			
			if(count($intersectfield)==count($field)){
				$ishead=true;
				$withheader=true;
			}
			
			if(!$ishead){				
				//field count validation				
				if(count($rowarray)-$margeerreur!=count($field)){
					return array("messsage"=>array($i+1=>"Filetype  ".$filetype." must have ".count($field)." fields : ".implode(", ",$field)));
				}
				
				//field content validation
				for($j=0;$j<count($field);$j++){
					$validresult=$this->$validator[$j]($rowarray[$j],$i);
					if($validresult!="ok"){
						return array("message"=>array($i+1=>$validresult));
					}
				}
			}
			$currentsave=array();
			
			//save array creation
			if(!($withheader && $i==0)){
				//normal field
				for($j=0;$j<count($field);$j++){
					if($field_label[$j]!="no")
						$currentsave+=array($field_label[$j]=>str_replace('"',"",$rowarray[$j]));
				}
				
				//date/time field 
				$strtolower2=function($val){
					return str_replace(":","",strtolower($val));
				};
				$dateindex=array_search("date", array_map($strtolower2, $field)); 
				$timeindex=array_search("time", array_map($strtolower2, $field)); 
				$date=$rowarray[$dateindex];
				$time=$rowarray[$timeindex];
				
				//PM case
				if(strpos($time, "PM")!==false){
					list($h,$m,$sPM)=explode(":",$time);
					$h=intval($h)+12;
					$time=trim(str_replace("PM","",$h.":".$m.":".$sPM));
				}
				list($d,$m,$y)=explode("/",$date);
				list($h,$mi,$s)=explode(":",$time);
				$datetime=date("Ymd H:i:s", mktime(intval($h), intval($mi), intval($s), intval($m), intval($d), intval($y)));
				$datetimeforcmp=date("Y-m-d H:i:s", mktime(intval($h), intval($mi), intval($s), intval($m), intval($d), intval($y)));	
				
				$currentsave+=array("Date"=>$datetime,"Fk_object"=>$id);
				
				//check if already exist
				$existcond=$currentsave;
				unset($existcond['Date']);
				$existcond+=array("convert(varchar, Date, 120)"=>$datetimeforcmp);
				$existcheck=$this->find("first",array("conditions"=>$existcond));
				//print_r($existcond);
				if(count($existcheck)>0)
					return array("message"=>array($i+1=>"Row already exist"));
					
				$savearray[]=$currentsave;
				$result[]=$rowarray;
			}
			$i++;
		}
		$this->SaveMany($savearray);
		return(array("message"=>"success"));
	}
	
	function validDateFile($date,$i){
		$message="ok";	
		if(!preg_match('/([0-2]?[0-9]|3[0-1])\/(1[0-2]|0?[0-9])\/(19|20)[0-9]{2}/', $date))
			$message="date filetype1 must be in this format dd/mm/yyyy";
		/*if(count(explode('/',trim($date)))==3){				
			list($dd,$mm,$yyyy) = explode('/',$date);
			print_r(intval($dd)." ".intval($mm)." ".intval($yyyy));
			if(!checkdate(intval($mm),intval($dd),intval($yyyy))) {
				$message="date filetype1 must be in this format dd/mm/yyyy";
			}	
		}	
		else
			$message="date filetype1 must be in this format dd/mm/yyyy";*/
		
		return $message;
	}
		
	function validTimeFile($time,$i){
		$message="ok";
		if(!preg_match('/(2[0-3]|[0-1]?[0-9]):[0-5]?[0-9]:[0-5]?[0-9]/', $time) && !preg_match('/([0-1]?[0-9]):[0-5]?[0-9]:[0-5]?[0-9] (AM|PM)/', $time)){
			$message="time must be in that format hh:mm:ss";
		}
		return $message;
	}			
	
	function validType($type,$i){
		$message="ok";
		if(str_replace('"',"",trim($type))==""){
			$message="type must not be empty";
		}
		return $message;
	}
	
	function valideCode($code,$i){
		$message="ok";
		if(str_replace('"',"",trim($code))==""){
			$message="code must not be empty";
		}
		return $message;
	}
	
	//validate function for field without validation rule 
	function no($val,$i){
		return true;
	}
}
?>