<?php

class MapSelectionManager extends AppModel {
	//public $useDbConfig = 'mycoflore';
	public $useTable = 'TMapSelectionManager';
	//public $primaryKey = 'TSta_PK_ID';
	
	public function gpx_save($stations,$file_name){
		$gpx='<?xml version="1.0" encoding="UTF-8" standalone="no" ?>
<gpx xmlns="http://www.topografix.com/GPX/1/1" creator="byHand" version="1.1"
   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
   xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd">';
		$error=false;
		foreach($stations as $rmodel){
			if(!isset($rmodel['MapSelectionManager']['LAT']) || !isset($rmodel['MapSelectionManager']['LON'])
			&& (!isset($rmodel['MapSelectionManager']['Date']) || !isset($rmodel['MapSelectionManager']['DATE']) 
			|| !isset($rmodel['MapSelectionManager']['StaDate'])) 
			&& (!isset($rmodel['MapSelectionManager']['Station']) || !isset($rmodel['MapSelectionManager']['Site_name']) ||
			!isset($rmodel['MapSelectionManager']['PTT']) || !isset($rmodel['MapSelectionManager']['Name_Station'])
			|| !isset($rmodel['MapSelectionManager']['StaName']))){
				$error=true;
				break;
			}
				
			$lat=$rmodel['MapSelectionManager']['LAT'];
			$lon=$rmodel['MapSelectionManager']['LON'];
			if(isset($rmodel['MapSelectionManager']['ELE']))
				$ele=$rmodel['MapSelectionManager']['ELE'];
			else 
				$ele="";
			if(isset($rmodel['MapSelectionManager']['Date']))
				$date=$rmodel['MapSelectionManager']['Date'];
			else if(isset($rmodel['MapSelectionManager']['DATE']))
				$date=$rmodel['MapSelectionManager']['DATE'];
			else if(isset($rmodel['MapSelectionManager']['StaDate']))
				$date=$rmodel['MapSelectionManager']['StaDate'];	
			$date=str_replace(" ","T",$date)."Z";		
			if(isset($rmodel['MapSelectionManager']['Station']))
				$name=$rmodel['MapSelectionManager']['Station'];
			else if(isset($rmodel['MapSelectionManager']['Site_name']))	
				$name=$rmodel['MapSelectionManager']['Site_name'];
			else if(isset($rmodel['MapSelectionManager']['PTT']))	
				$name=$rmodel['MapSelectionManager']['PTT'];
			else if(isset($rmodel['MapSelectionManager']['Name_Station']))	
				$name=$rmodel['MapSelectionManager']['Name_Station'];
			else if(isset($rmodel['MapSelectionManager']['StaName']))	
				$name=$rmodel['MapSelectionManager']['StaName'];	
			$sym="";
			
			$gpx.="\n<wpt lat='$lat' lon='$lon'>\n";
			$gpx.="<ele>$ele</ele>\n";
			$gpx.="<time>$date</time>\n";
			$gpx.="<desc></desc>\n";
			$gpx.="<name>$name</name>\n";
			$gpx.="<sym>Flag, Blue</sym>\n";			
			$gpx.="</wpt>\n";
		}
		
		$gpx.='</gpx>';
		if($error)
			$gpx="error fields need 'LAT' 'LON' 'ELE' 'Date' 'Station or Site_name'";
		
		if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
			$fp = fopen("gps/$file_name.gpx", 'w');			
			fwrite($fp, print_r($gpx,true));
		}
		else{
			$fp = fopen("app/webroot/gps/$file_name.gpx", 'w');			
			fwrite($fp, print_r($gpx,true));
		}
	
		if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
			$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res2", 'w');			
			fwrite($fp, print_r($gpx,true));
		}
	}
	
}

?>