<?php
App::uses('TaxonName', 'Model');
App::uses('TProtocolInventory', 'Model');
App::uses('CommunesRhoneAlpes', 'Model');
App::uses('Table_Import', 'Model');
App::uses('Tthesaurus', 'Model');

class Station extends AppModel {
	// public $useDbConfig = 'mycoflore';
	public $useTable = 'TStations';
	public $primaryKey = 'TSta_PK_ID';
	//public $actsAs = array('Containable');
	
	public $hasMany = array(
        'Additionnal' => array(
            'className' => 'StationAddi',
			'foreignKey' => 'FK_TSta_ID'
        ),
		'StationProtocoles' => array(
			'className' => 'TProtocolInventory',
			'foreignKey' => 'FK_TSta_ID',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Simplified_Habitat' => array(
			'className' => 'SimplifiedHabitat',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Nest_Description' => array(
			'className' => 'NestDescription',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Vertebrate_interview' => array(
			'className' => 'Vertebrateinterview',
			'foreignKey' => 'FK_TSta_ID'
		),
		'ArgosDataArgos' => array(
			'className' => 'ArgosDataArgos',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Vertebrate_individual' => array(
			'className' => 'Vertebrateindividual',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Track_clue' => array(
			'className' => 'Trackclue',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Sighting_conditions' => array(
			'className' => 'Sightingconditions',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Phytosociology_habitat' => array(
			'className' => 'Phytosociologyhabitat',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Phytosociologyreleve' => array(
			'className' => 'Phytosociologyreleve',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Building_and_Activities' => array(
			'className' => 'BuildingandActivities',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Entomo_population' => array(
			'className' => 'Entomopopulation',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Chiroptera_capture' => array(
			'className' => 'Chiropteracapture',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Chiroptera_detection' => array(
			'className' => 'Chiropteradetection',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Clutch_Description' => array(
			'className' => 'ClutchDescription',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Transects' => array(
			'className' => 'Transects',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Vertebrate_Group' => array(
			'className' => 'VertebrateGroup',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Bird_Biometry' => array(
			'className' => 'BirdBiometry',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Capture_Group' => array(
			'className' => 'CaptureGroup',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Vertebrate_individual_death' => array(
			'className' => 'Vertebrateindividualdeath',
			'foreignKey' => 'FK_TSta_ID'
		),
		'ArgosDataGPS' => array(
			'className' => 'ArgosDataGPS',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Release_Group' => array(
			'className' => 'ReleaseGroup',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Station_Description' => array(
			'className' => 'StationDescription',
			'foreignKey' => 'FK_TSta_ID'
		),
		'Station_equipment' => array(
			'className' => 'Stationequipment',
			'foreignKey' => 'FK_TSta_ID'
		)
	);	
	
	
	/*________________VALIDATOR______________*/
	public $validate = array(
        'LAT' => array(
			'rule' => array('isFloat'),	   
            'message' => 'LAT must be a float'
        ),
		'LON' => array(
			'rule' => array('isFloat'),	   
            'message' => 'LON must be a float'
        )
    );
	
	function isFloat($latorlon){
		if(isset($latorlon['LAT'])){
			$lat=$latorlon['LAT'];
			$lat=str_replace(",", ".", $lat);
			return filter_var($lat, FILTER_VALIDATE_FLOAT);				
		}
		else if(isset($latorlon['LON'])){
			$lon=$latorlon['LON'];
			$lon=str_replace(",", ".", $lon);
			return filter_var($lon, FILTER_VALIDATE_FLOAT);				
		}	
	}
	/*_______________________________________*/

	function To_error_table($rowarray,$numimport,$message,$csvline){
		$error_data=array('TAXON_ID'=>$rowarray[0],'CD_INSEE'=>$rowarray[1],'LIEU-DIT'=>$rowarray[2],
		'ALT'=>$rowarray[3],'LAT'=>$rowarray[4],'LNG'=>$rowarray[5]
		,'DATE'=>$rowarray[6],'RECOLTEUR'=>$rowarray[7],'DETERMINATEUR'=>$rowarray[8],
		'HABITAT'=>$rowarray[9],'SUBSTRAT'=>$rowarray[10],'HOTE'=>$rowarray[11]
		,'NO EXSICCATUM'=>$rowarray[12],'SOURCE'=>$rowarray[13],'NUM_IMPORT'=>"".$numimport,'CSV_LINE'=>"".$csvline,'MESSAGE'=>$message);
		return $error_data;
	}
	
	/*_____________________IMPORTCSV___________________*/
	function importcsv2($filename,$iduser) {
 		$taxonmodel=new Taxon();
		$table_import=new Table_Import();
		setlocale(LC_ALL, 'fr_FR');
		date_default_timezone_set('Europe/Paris');
		set_time_limit (300);
		ini_set('max_execution_time', 300);
		//error table import get last num import
		$table_import_array=$table_import->find("first",array('order'=>'num_import desc'));
		if((!is_array($table_import_array) || count($table_import_array)<1)){
			$num_import=1;
		}
		else{
			$num_import=$table_import_array['Table_Import']['NUM_IMPORT']+1;
		}
		//print_r("de $num_import ");
		//print_r($table_import_array);
		//print_r(" fe ");
		$fieldname=array("TAXON_ID","CD_INSEE","LIEU-DIT"
		,"ALT","LAT","LNG","DATE","RECOLTEUR","DETERMINATEUR","HABITAT","SUBSTRAT","HOTE","NO EXSICCATUM","SOURCE"
		);		
			
		$fieldnamereal=array("LIEU-DIT"=>"Locality","ALT"=>"ELE","LAT"=>"LAT"
		,"LNG"=>"LON","DATE"=>"DATE","RECOLTEUR"=>"FieldWorker1","DETERMINATEUR"=>"FieldWorker2","HABITAT"=>"Name_Habitat"
		,"SUBSTRAT"=>"Name_Substatum","HOTE"=>"Host","NO EXSICCATUM"=>"Exsiccatum_num","SOURCE"=>"Source"
		);
		$fieldt1=array("LIEU-DIT","ALT","LAT","LNG","DATE","RECOLTEUR","DETERMINATEUR");
		$fieldt11=array("DEPT","LIEU-DIT 2","SOURCE");
		$fieldt2=array("HABITAT","SUBSTRAT","HOTE","NO EXSICCATUM","SOURCE");	
		$specialfield=array("TAXON_ID","CD_INSEE");
		$uniquefield=array("LAT","LNG","DATE","ALT","RECOLTEUR","DETERMINATEUR","LIEU-DIT");	
		$nametable1='Station';
		$nametable2='StationProtocoles';
		$nametable3='Additionnal';
		$dataprotoall=array();
		// open the file
 		$handle = fopen($filename, "r");
 		//$handle = $this->utf8_fopen_read($filename);
 		// read the 1st row as headings
 		$header = fgetcsv($handle);
 		
		// create a message container
		$return = array(
			'state' => "",
			'messages' => array(),
			'errors' => array(),
			'warning' => array()			
		);		
				
		/*_____________header check____________*/
		$header_array=split(";",$header[0]);
		$encoding=mb_detect_encoding($header_array[0]);		
		if($encoding!="UTF-8"){
			$return['errors'][] = __(sprintf("Encoding error.'".$encoding."' detected and must be 'UTF-8'", true));
			return 	$return;
		}
		$field=array();
		$inisize=count($header_array);
		//in_array('PHOTO',$header_array) ? $fieldname=$fieldname2 : $fieldname=$fieldname1;
		if($inisize!=count($fieldname)){
			$return['errors'][] = __(sprintf('Field count error should be '.count($fieldname).' not '.$inisize, true));
			return 	$return;
		}
		else{
			for($i=0;$i<$inisize;$i++){
				$header_array[$i]=@iconv ("UTF-8","ASCII//IGNORE",$header_array[$i]);
				
				if(!in_array($header_array[$i], $fieldname)){
					$return['errors'][] = __(sprintf('Field(s) unknown:"'.$header_array[$i].'"',$i), true);
					return 	$return;			
				}
				array_push($field,$header_array[$i]);	
				unset($header_array[$i]);			
			}	
			if(count($header_array)>0){
				$return['errors'][] = __(sprintf('Missing Field:'.print_r($header_array,true),$i), true);
				return 	$return;
			}
		}
		/*_____________________________________*/			
			
		$laststaidarray=$this->query("SELECT IDENT_CURRENT('TStations')");
		$laststaid=array_pop($laststaidarray[0][0]);
		//print_r($laststaid);
		$dataall=array();
		$dataerrorlog;
		$i=0;
 		$index=0;
		/*___________read each data row in the file_________*/
 		while (($row = fgets($handle)) !== FALSE) {					
 			$i++;
 			$data = array($nametable1=>array(),$nametable2=>array(array()),$nametable3=>array());
			$rowarray=split(";",$row);			
			$dospecial=false;			
			$unicond=array();
			$idreftaxon=$rowarray[array_search("TAXON_ID", $field)];
			$habitat=$rowarray[array_search("HABITAT", $field)];			
			$habitat=str_replace("'","''",$habitat);
			$substrat=$rowarray[array_search("SUBSTRAT", $field)];	
			$substrat=str_replace("'","''",$substrat);
			$hote=$rowarray[array_search("HOTE", $field)];		
			$hote=str_replace("'","''",$hote);
			$excode=$rowarray[array_search("NO EXSICCATUM", $field)];
			$excode=str_replace("'","''",$excode);
			$source=str_replace(CHR(10),"",$rowarray[array_search("SOURCE", $field)]);							
			$source=str_replace(CHR(13),"",$source);
			$source=preg_replace("/(\r\n|\n|\r)/", "", $source);	
			$source=str_replace("'","''",$source);
			$source=trim($source);	
			if($inisize==count($rowarray)){//check if the number of field is correct
				$mess="";
				//check if station field or correct
				$empty=false;
				foreach($uniquefield as $f){
					$unindex=array_search($f, $field);				
					$unival=$rowarray[$unindex];
					$unival = str_replace(CHR(10),"",$unival); 
					$unival = str_replace(CHR(13),"",$unival);
					$unival=str_replace("'","''",$unival);	
					//$unival=iconv(mb_detect_encoding($unival),"ASCII//IGNORE",$unival);
					$realname=$fieldnamereal[$f];
					
					if($realname=="ELE" && !ctype_digit($unival)){
						$mess=="" ? $mess.="ELE must be a int and not empty: '$unival'. " : $mess.="and ELE must be a int and not empty: '$unival'. ";						
					}
					else if($realname=="ELE")
						$ele=$unival;
						
					if($realname=="DATE"){
						$date=$unival;
						if(!preg_match("^\d{1,2}/\d{2}/\d{4}^", $unival))
							$mess=="" ? $mess.="Incorrect date: '$unival' " : $mess.="and Incorrect date: '$unival' ";
						/*$patterns = array ('/(\d{1,2})\/(\d{1,2})\/(19|20)(\d{2})/');
						$replace = array ('\3\4\2\1');
						$unival=preg_replace($patterns, $replace, $unival);*/
						$realname='CONVERT(varchar(255), DATE, 103)';
					}					
					if($realname=="LAT" || $realname=="LON"){
						if($realname=="LAT")
							$lat=$unival;
						else
							$lon=$unival;
						//print_r("lalo:$unival");	
						$unival=str_replace(",", ".", $unival);
						if(!filter_var($unival, FILTER_VALIDATE_FLOAT) || (strpos($unival,'.') === false) || (strpos($unival,'e') !== false))
							$mess=="" ? $mess.="$realname must be a float and not empty: '$unival'" : $mess.="and $realname must be a float and not empty: '$unival'";
						//print_r("lalo:$unival mess:$mess, ");	
					}
					if($realname=="FieldWorker1")
						$fw1=$unival;
					if($realname=="FieldWorker2")
						$fw2=$unival;
					if($realname=="Locality")
						$loc=$unival;
					$unicond[]=array("$realname = '$unival'");
				}
				
				//if error find
				if($mess!=""){
					$message = __(sprintf("Row %d failed to save.".$mess ,$i), true);
					$return['errors'][] = $message;
					$error=$this->To_error_table($rowarray,$num_import,$message,$i);
					$dataerrorlog[]=$error;
					//print_r($t);
					continue;
				}
				
				$ondatafind=false;
				
				//print_r("FieldWorker1:'$fw1', FieldWorker2:'$fw2', Locality:'$loc'");
				//print_r(json_encode($dataall));
				
				//check if station already exist on this file
				//print_r($dataall);
				$pexist=false;
				foreach($dataall as $prevdata){						
					if($prevdata['Station']['ELE']==$ele && $prevdata['Station']['LON']==str_replace(",", ".", $lon)
					&& $prevdata['Station']['LAT']==str_replace(",", ".", $lat) && $prevdata['Station']['DATE']==$date
					&& $prevdata['Station']['FieldWorker1']==$fw1 && $prevdata['Station']['FieldWorker2']==$fw2 
					&& $prevdata['Station']['Locality']==$loc){
						//print_r("fileexist");
						$ondatafind=true;
						$curidsta=intval($laststaid)+$index+1;
						$datastaproto=$prevdata['StationProtocoles'];
						
							
						foreach($datastaproto as $proto){
							if($proto['Id_Taxon']==$idreftaxon && $proto['Name_Habitat']==$habitat
								&& $proto['Name_Substatum']==$substrat && $proto['Host']==$hote && $proto['Exsiccatum_num']==$excode
								&& $proto['Source']==$source){	
									
									$message=__(sprintf('Row %d failed to save. Error: Row already exist in file' ,$i), true);
									$return['errors'][] = $message;	
									$error=$this->To_error_table($rowarray,$num_import,$message,$i);
									$dataerrorlog[]=$error;
									$pexist=true;							
							}
						}
						break;
					}					
				}	
				
				if($pexist)
					continue;
			/*	
				print_r("i:".$i." ");
				print_r(count($unicond));
				print_r("
		");*/
				$unifind=array();
				if(!$ondatafind){
					//check if station already exist on sql table
					$unifind=$this->find("all",array(   
						'recursive'=> -1,
						'fields'=>'TSta_PK_ID',
						'conditions'=> $unicond
					));
				}
				
				//if station not exist
				//if((!is_array($unifind) || count($unifind)<1) && !$ondatafind){
				if(!is_array($unifind) || count($unifind)<1){
					//create the model to save
					foreach($fieldname as $ft1){				
						$index=array_search($ft1, $field);				
						$val=str_replace(CHR(10),"",$rowarray[$index]);						
						$val=str_replace(CHR(13),"",$val);
						$val=preg_replace("/(\r\n|\n|\r)/", "", $val);
						$val=str_replace("'","''",$val);
						
						//$val=@iconv (mb_detect_encoding($val),"ASCII//IGNORE",$val);
						if(!in_array($ft1,$specialfield)){
							if(in_array($ft1,$fieldt1)){           //save for this model
								$ft1=$fieldnamereal[$ft1];
								if($ft1=="LAT" || $ft1=="LON"){
									$val= floatval(str_replace(",",".",$val));							
								}					
								$data[$nametable1]+=array($ft1=>$val);								
							}	
							else if(in_array($ft1,$fieldt2)){     //save for associated model protocole
								$ft1=$fieldnamereal[$ft1];
								$data[$nametable2][0]+=array($ft1=>$val);
									
							}
							else if(in_array($ft1,$fieldt11)){     //save for associated model additionnal
								$ft1=$fieldnamereal[$ft1];
								//$current_ident=$this->query("Select IDENT_CURRENT('TStations')");
								array_push($data[$nametable3],array('FK_value_type'=>$ft1,'value'=>$val));
							}	
						}
						$data[$nametable1]['Creation_date']= date('d/m/Y h:i:s a', time());
						$data[$nametable1]['Creator']= $iduser;
						//print_r($data[$nametable1]);
					}
				
					//TAXON
					$idreftaxon=$rowarray[array_search("TAXON_ID", $field)];
					//print_r($taxon);
					//$taxon=@iconv (mb_detect_encoding($taxon),"ASCII//IGNORE",$taxon);
					$idtaxon=array();
					$idtaxon=$taxonmodel->find("all",array(  
						'recursive'=> -1,
						'fields'=>array('TAXREF_CD_TAXSUP','NAME_VALID_WITH_AUTHORITY','NAME_VALID_WITHOUT_AUTHORITY','ID_TAXON'),
						'conditions'=> array("ID_TAXON"=>$idreftaxon),
						//'group'=>'NAME_WITHOUT_AUTHORITY'
					));				
					
					if(count($idtaxon)>0 && is_array($idtaxon)){
						$data[$nametable2][0]+=array('Id_Taxon'=>$idtaxon[0]['Taxon']['ID_TAXON']);							
						$data[$nametable2][0]+=array('Name_Taxon'=>$idtaxon[0]['Taxon']['NAME_VALID_WITH_AUTHORITY']);
						$data[$nametable2][0]+=array('Original_Name'=>$idtaxon[0]['Taxon']['NAME_VALID_WITHOUT_AUTHORITY']);
						$data[$nametable2][0]+=array('Identity_sure'=>0);	
					}
					else{
						$message = __(sprintf("Row %d failed to save. Taxon not find for id:'".$idreftaxon."'.",$i), true);
						$return['errors'][] = $message;
						$error=$this->To_error_table($rowarray,$num_import,$message,$i);
						$dataerrorlog[]=$error;
						continue;
					}
					
					//COMMUNE
					$communemodel=new CommunesRhoneAlpes();
					$idinsee=$rowarray[array_search("CD_INSEE", $field)];
					/*if($idreftaxon==100048585)
						print_r(" $idinsee ");*/
					//print_r($taxon);
					//$idinsee=@iconv (mb_detect_encoding($idinsee),"ASCII//IGNORE",$idinsee);
					$idcomm=array();
					$idcomm=$communemodel->find("all",array(  
						'recursive'=> -1,
						'fields'=>array('INSEE','ARTMIN','NCCENR'),
						'conditions'=> array("INSEE"=>$idinsee),
						//'group'=>'NAME_WITHOUT_AUTHORITY'
					));				
					
					if(count($idcomm)>0 && is_array($idcomm)){
						$nomcomm=str_replace(array("(",")"),array("",""),$idcomm[0]['CommunesRhoneAlpes']['ARTMIN']).' '.$idcomm[0]['CommunesRhoneAlpes']['NCCENR'];
						//$nomcomm=@iconv (mb_detect_encoding($nomcomm),"ASCII//IGNORE",$nomcomm);
						$data[$nametable1]+=array('Area'=>$nomcomm);
					}
					else{
						$message = __(sprintf("Row %d failed to save. Commune not find for id:'".$idinsee."'.",$i), true);
						$return['errors'][] = $message;
						$error=$this->To_error_table($rowarray,$num_import,$message,$i);
						$dataerrorlog[]=$error;
						continue;
					}
					/*	
					$fp = fopen("app/webroot/gps/file2", 'a');	
								fwrite($fp, "t2: ".print_r($data[$nametable2],true)."\n");*/	
					// validate the row			
					$this->set($data);
					$this->StationProtocoles->set($data[$nametable2][0]);
					//$sproto=new TProtocolInventory();
					//$data['StationProtocoles'][0]['FK_TSta_ID']='0';	
					//$sproto->set($data['StationProtocoles'][0]);
					//$fp = fopen("app/webroot/gps/file2", 'a');	
					//fwrite($fp, "val: ".print_r($this->StationProtocoles->validates(),true)."\n");	
					$this->create();				
					
					if (!$this->validates() || !$this->StationProtocoles->validates()){
						if(!$this->validates())
							$errortab=$this->validationErrors;
						else
							$errortab=$this->StationProtocoles->validationErrors;
						foreach($errortab as $key=>$val)	
							foreach($val as $er)
								$errorvalidate=$er;
						//$this->_flash(,'warning');
						$message=__(sprintf('Row %d failed to validate. Error: '.$errorvalidate,$i),true);
						$return['errors'][] = $message;
						$error=$this->To_error_table($rowarray,$num_import,$message,$i);
						$dataerrorlog[]=$error;	
					}				
					// save the row
					else{
						try{
							$isnotcatch=true;
							$issave=true;
							//$issave=$this->saveAssociated($data);
							try{
							}catch(Exception $e){	
								$message = __(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
								$return['errors'][] = $message;
								$error=$this->To_error_table($rowarray,$num_import,$message,$i);
								$dataerrorlog[]=$error;
								$issave=false;
								$isnotcatch=false;
							}
						}catch(Exception $e){	
							$message = __(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
							$return['errors'][] = $message;
							$error=$this->To_error_table($rowarray,$num_import,$message,$i);
							$dataerrorlog[]=$error;
							$issave=false;
						}	
						if (!$issave && $isnotcatch){
							$message=__(sprintf('Row %d failed to save.'.print_r($this->validationErrors,true),$i), true);
							$return['errors'][] = $message;
							$error=$this->To_error_table($rowarray,$num_import,$message,$i);
							$dataerrorlog[]=$error;
							$issave=false;
						}	
						else{	
							// success message!
							$return['messages'][] = __(sprintf('Row %d was saved.',$i), true);			
						}	
					}
					$index++;
					$dataall[]=$data;
				}				
				else{
				//if station already exist create only protocole fields		
					$protomodel=new TProtocolInventory();
					
					
					//get station id
					if($ondatafind){
						$idstation=$curidsta;	
					}	
					else{						
						$idstation=$unifind[0]['Station']['TSta_PK_ID'];						
					}	
						
					$pexist=false;
					$idt=0;
					//get taxon id from cd tax ref
					$idtaxon=array();
					$idtaxon=$taxonmodel->find("all",array(  
						'recursive'=> -1,
						'fields'=>array('TAXREF_CD_REF','NAME_VALID_WITH_AUTHORITY','NAME_VALID_WITHOUT_AUTHORITY','ID_TAXON'),
						'conditions'=> array("ID_TAXON"=>$idreftaxon),
						//'group'=>'NAME_WITHOUT_AUTHORITY'
					));	
					//print_r($taxonmodelarr);
					if(count($idtaxon)>0 && is_array($idtaxon)){
						$idt=$idtaxon[0]['Taxon']['ID_TAXON'];
					}
					
					//print_r(" $i ");
					//print_r($dataprotoall);
					//print_r(array("'".$idstation."'","'".$idt."'","'".$habitat."'","'".$substrat."'","'".$hote."'","'".$excode."'","'".$source."'"));
					/*//check if protocole already exist in file
					foreach($dataprotoall as $dapr){
						if($dapr['FK_TSta_ID']==$idstation && $dapr['Id_Taxon']==$idt && $dapr['Name_Habitat']==$habitat
						&& $dapr['Name_Substatum']==$substrat && $dapr['Host']==$hote && $dapr['Exsiccatum_num']==$excode
						&& $dapr['Source']==$source){	
							$message=__(sprintf('Row %d failed to save. Error: Row already exist in file' ,$i), true);
							$return['errors'][] = $message;	
							$error=$this->To_error_table($rowarray,$num_import,$message,$i);
							$dataerrorlog[]=$error;
							$pexist=true;							
						}
					}	*/
										
					if(!$pexist){
						$protoexist=$protomodel->find("all",array(
							"conditions"=>array("FK_TSta_ID=$idstation and TProtocolInventory.Id_Taxon='$idt' and Name_Habitat='$habitat' 
							and Name_Substatum='$substrat' and Host='$hote' and Exsiccatum_num='$excode' and Source='$source'")
						));
						//check if protocole already exist in sql table
						if(count($protoexist)>0 && is_array($protoexist)){
							$message=__(sprintf('Row %d failed to save. Error: Row already exist in sql table' ,$i), true);
							$return['errors'][] = $message;	
							$error=$this->To_error_table($rowarray,$num_import,$message,$i);
							$dataerrorlog[]=$error;
							continue;
						}
					}
					else
						continue;
					
					//creation of the protocol saving array
					$dataproto=array();
					foreach($fieldt2 as $ft1){
						$index=array_search($ft1, $field);			
						$val=str_replace(CHR(10),"",$rowarray[$index]);						
						$val=str_replace(CHR(13),"",$rowarray[$index]);
						$val=preg_replace("/(\r\n|\n|\r)/", "", $val);
						$val=str_replace("'","''",$val);
						//$val=@iconv (mb_detect_encoding($val),"ASCII//TRANSLIT",$val);
						//$val=mb_convert_encoding($val,'ASCII');
						if($ft1=="NOM ORIGINE")	continue;
						$ft1=$fieldnamereal[$ft1];							
						$dataproto+=array($ft1=>$val);
					}
					
					$dataproto+=array('FK_TSta_ID'=>$idstation);
					
					//TAXON
					//print_r($taxon);
					//$taxon=@iconv (mb_detect_encoding($taxon),"ASCII//IGNORE",$taxon);
											
					if(count($idtaxon)>0 && is_array($idtaxon)){
							$dataproto+=array('Id_Taxon'=>$idtaxon[0]['Taxon']['ID_TAXON']);							
							$dataproto+=array('Name_Taxon'=>$idtaxon[0]['Taxon']['NAME_VALID_WITH_AUTHORITY']);
							$dataproto+=array('Original_Name'=>$idtaxon[0]['Taxon']['NAME_VALID_WITHOUT_AUTHORITY']);
							$dataproto+=array('Identity_sure'=>0);
					}
					else{
						$message=__(sprintf("Row %d failed to save. Taxon id not find for '".$idreftaxon."'",$i), true);
						$return['errors'][] = $message;
						$error=$this->To_error_table($rowarray,$num_import,$message,$i);
						$dataerrorlog[]=$error;
						continue;
					}
					
					$protomodel->create();				
					// validate the row			
					$protomodel->set($dataproto);
					
					if(!$protomodel->validates()){
						//$protomodel->_flash(,'warning');
						$errortab=$protomodel->validationErrors;
						foreach($errortab as $key=>$val)	
							foreach($val as $er)
								$errorvalidate=$er;
						$message = __(sprintf('Row %d failed to validate. Error: '.$errorvalidate,$i), true);	;
						$return['errors'][] = $message;
						$error=$this->To_error_table($rowarray,$num_import,$message,$i);
						$dataerrorlog[]=$error;
					}				
					// save the row
					else{
						try{
							$isnotcatch=true;
							$issave=true;
							//$issave=$protomodel->save($dataproto);
						}catch(Exception $e){							
							$issave=false;
							$isnotcatch=false;
							$message=__(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
							$return['errors'][] = $message;
							$error=$this->To_error_table($rowarray,$num_import,$message,$i);
							$dataerrorlog[]=$error;
						}	
						if (!$issave && $isnotcatch){
							$message = __(sprintf('Row %d failed to save. Error :',$i), true);;
							$return['errors'][] = $message;
							$error=$this->To_error_table($rowarray,$num_import,$message,$i);
							$dataerrorlog[]=$error;
						}	
						else{	
						// success message!
							$return['messages'][] = __(sprintf('Row %d was saved. Station already exist so only the protocole has been added.',$i), true);			
						}	
					}
					$dataprotoall[]=$dataproto;
				}
				//if($i==1500)break;				
			}
			else{
				$message = __(sprintf('Row %d failed to save. Row field count error',$i), true);
				$return['errors'][] = $message;
				$error=$this->To_error_table($rowarray,$num_import,$message,$i);
				$dataerrorlog[]=$error;
				continue;
			}	
			//print_r("data:");			
 		}
 		/*____________________________________*/
		
		if($i==0){
			$return['errors'][] = __(sprintf('No file or file empty',$i), true);
		}
		else{
			if(count($return['errors'])==0){
				$this->saveMany($dataall,array('deep'=>true));
				$return['state']='success';
				if(isset($protomodel)){
					$protomodel->saveMany($dataprotoall);
				}	
				//print_r("success : ");
				//print_r($dataall);
			}
			else{	
				$return['state']='error';
				if(count($table_import)>0){
					$return['num_import']=$num_import;
					$table_import->saveMany($dataerrorlog);
					//print_r("error : ");
					//print_r($dataerrorlog);
				}	
			}	
		}
		//print_r();
 		// close the file
 		fclose($handle);
 		
 		//print_r($return);
 		// return the messages
 		return $return;
 		
	}
	/*_________________________________________________*/
}	 
?>