<?php
App::uses('TaxonName', 'Model');
App::uses('TProtocolInventory', 'Model');
class Station extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'TStations';
	public $primaryKey = 'TSta_PK_ID';
	//public $actsAs = array('Containable');
	
	public $hasMany = array(
        'Additionnal' => array(
            'className' => 'StationAddi',
			'foreignKey' => 'FK_TSta_ID',
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
	
	
	
	/*_____________________IMPORTCSV___________________*/
	function importcsv($filename) {
 		$taxonname=new TaxonName();
		$ttaxon=new Taxon();	
		$fieldname=array("TAXON","NOM ORIGINE","REMARQUE","DEPT","COMMUNE"
		,"LIEU-DIT","LIEU-DIT 2","ALT","LAT"
		,"LNG","NOTE LOCALISATION","DATE"
		,"RECOLTEUR","DETERMINATEUR","SOURCE","HABITAT","SUBSTRAT","HOTE","CODE HERBIER","NO EXSICCATUM"
		);
		
		$fieldname1=array("TAXON","NOM ORIGINE","REMARQUE","DEPT","COMMUNE"
		,"LIEU-DIT","LIEU-DIT 2","ALT","LAT"
		,"LNG","NOTE LOCALISATION","DATE"
		,"RECOLTEUR","DETERMINATEUR","SOURCE","HABITAT","SUBSTRAT","HOTE","CODE HERBIER","NO EXSICCATUM"
		);
		
		$fieldname2=array("TAXON","DEPT","COMMUNE"
		,"Lieu-dit","ALT","LAT"
		,"LNG","DATE"
		,"RECOLTEUR","DETERMINATEUR","SOURCE","HABITAT","SUBSTRAT","HOTE","CODE HERBIER","NO EXSICCATUM","PHOTO"
		);
		
			
		$fieldnamereal=array("TAXON"=>"Original_Name","NOM ORIGINE"=>"Original_Name",
		"REMARQUE"=>"Comments","DEPT"=>"DEPT","COMMUNE"=>"Area"
		,"LIEU-DIT"=>"Locality","Lieu-dit"=>"Locality","LIEU-DIT 2"=>"LIEU-DIT2","ALT"=>"ELE","LAT"=>"LAT"
		,"LNG"=>"LON","NOTE LOCALISATION"=>"Comments","DATE"=>"DATE"
		,"RECOLTEUR"=>"FieldWorker1","DETERMINATEUR"=>"FieldWorker2","SOURCE"=>"SOURCE","HABITAT"=>"Name_Habitat"
		,"SUBSTRAT"=>"Name_Substatum","HOTE"=>"Host","CODE HERBIER"=>"Herbarium_code","NO EXSICCATUM"=>"Exsiccatum_num"
		);
		$fieldt1=array("COMMUNE","LIEU-DIT","ALT","LAT","LNG","NOTE LOCALISATION","DATE","RECOLTEUR","DETERMINATEUR");
		$fieldt11=array("DEPT","LIEU-DIT 2","SOURCE");
		$fieldt2=array("REMARQUE"
		,"HABITAT","SUBSTRAT","HOTE","CODE HERBIER","NO EXSICCATUM");	
		$specialfield=array("TAXON");
		$uniquefield=array("LAT","LNG","DATE","ALT");	
		$nametable1='Station';
		$nametable2='StationProtocoles';
		$nametable3='Additionnal';
		// open the file
 		$handle = fopen($filename, "r");
 		//$handle = $this->utf8_fopen_read($filename);
 		// read the 1st row as headings
 		$header = fgetcsv($handle);
 		
		// create a message container
		$return = array(
			'messages' => array(),
			'errors' => array(),
			'warning' => array()
		);
		
				
		/*_____________header check____________*/
		$header_array=split(";",$header[0]);
		$field=array();
		$inisize=count($header_array);
		in_array('PHOTO',$header_array) ? $fieldname=$fieldname2 : $fieldname=$fieldname1;
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
			
		
		$i=0;
 		/*___________read each data row in the file_________*/
 		while (($row = fgets($handle)) !== FALSE) {			
 			$i++;
 			$data = array($nametable1=>array(),$nametable2=>array(array()),$nametable3=>array());
			$rowarray=split(";",$row);			
			$dospecial=false;			
			$unicond=array();			
			if($inisize==count($rowarray)){//check if the number of field is correct
				$mess="";
				//check if station already exist
				$empty=false;
				foreach($uniquefield as $f){
					$unindex=array_search($f, $field);				
					$unival=$rowarray[$unindex];
					$unival=iconv(mb_detect_encoding($unival),"ASCII//IGNORE",$unival);
					$realname=$fieldnamereal[$f];
					
					if($realname=="ELE" && !ctype_digit($unival)){
						$mess=="" ? $mess.="ELE must be a int and not empty: '$unival'. " : $mess.=" ELE must be a int and not empty: '$unival'. ";
					}
					
					if($realname=="DATE"){
						if(!preg_match("^\d{1,2}/\d{2}/\d{4}^", $unival))
							$mess=="" ? $mess.="Incorrect date: '$unival' " : $mess.=" Incorrect date: '$unival' ";
						/*$patterns = array ('/(\d{1,2})\/(\d{1,2})\/(19|20)(\d{2})/');
						$replace = array ('\3\4\2\1');
						$unival=preg_replace($patterns, $replace, $unival);*/
						$realname='CONVERT(varchar(255), DATE, 103)';
					}					
					if($realname=="LAT" || $realname=="LON"){	
						$unival=str_replace(",", ".", $unival);
						if(!filter_var($unival, FILTER_VALIDATE_FLOAT))
							$mess.=" $realname must be a float and not empty: '$unival'.";
					}
					$unicond[]=array("$realname = '$unival'");
				}
				if($mess!=""){
					$return['errors'][] = __(sprintf("Row %d failed to save.".$mess ,$i), true);
					continue;
				}
								
				$unifind=$this->find("all",array(   
					'recursive'=> -1,
					'fields'=>'TSta_PK_ID',
					'conditions'=> $unicond
				));	
				
				if(count($unifind)<1){
					//create the model to save
					foreach($fieldname as $ft1){				
						$index=array_search($ft1, $field);				
						$val=$rowarray[$index];						
						$val=@iconv (mb_detect_encoding($val),"ASCII//IGNORE",$val);
						if(!in_array($ft1,$specialfield)){
							if(in_array($ft1,$fieldt1)){           //save for this model
								$ft1=$fieldnamereal[$ft1];
								if($ft1=="LAT" || $ft1=="LON"){
									$val= floatval(str_replace(",",".",$val));							
								}
								if($ft1=="NOM ORIGINE"){
									continue;
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
								//$data[$nametable3]+=array('type'=>$ft1,'value'=>$val);
							}	
						}
					}
					
					/*if(stristr($_SERVER["SERVER_SOFTWARE"], 'apache')){
						$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res2", 'a');			
						fwrite($fp, " $i ".print_r($data ,true));
					}*/
					
					if(!$dospecial){ //FINDING THE ID_TAXON
						$taxon=$rowarray[array_search("TAXON", $field)];
						$taxon=@iconv (mb_detect_encoding($taxon),"ASCII//IGNORE",$taxon);
						$idtaxon=array();
						$name='';
						$idtaxon=$taxonname->find("all",array(  
							'recursive'=> -1,
							'fields'=>array('FK_Taxon','NAME_WITH_AUTHORITY'),
							'conditions'=> array("NAME_WITHOUT_AUTHORITY"=>$taxon),
							//'group'=>'NAME_WITHOUT_AUTHORITY'
						));				
						
						if(count($idtaxon)>0){
							$data[$nametable2][0]+=array('Id_Taxon'=>$idtaxon[0]['TaxonName']['FK_Taxon']);
							$rttaxon=$ttaxon->find('first',array(   
								'recursive'=> -1,
								'fields'=>'NAME_VALID_WITH_AUTHORITY',
								'conditions'=> array("ID_TAXON"=>$idtaxon[0]['TaxonName']['FK_Taxon'])
							));
							if(count($idtaxon)>1){
								$str="";
								foreach($idtaxon as $t){
									$str.=" - '".$t['TaxonName']['NAME_WITH_AUTHORITY']."'";
								}
								$str.=". '".$idtaxon[0]['TaxonName']['NAME_WITH_AUTHORITY']."' have been chosen";
								$return['warning'][] = __(sprintf("Row %d warning. Multiple choose possible for '$taxon' : ".$str,$i), true);
							}
							$data[$nametable2][0]+=array('Name_Taxon'=>$idtaxon[0]['TaxonName']['NAME_WITH_AUTHORITY']);
							$data[$nametable2][0]+=array('Original_Name'=>$taxon);
							$data[$nametable2][0]+=array('Identity_sure'=>0);	
						}
						else{
							$return['errors'][] = __(sprintf("Row %d failed to save. Taxon not find for '".$taxon."'",$i), true);
							continue;
						}
						$dospecial=true;
					}					
					// validate the row			
					$this->set($data);					
					$this->create();				
					
					if (!$this->validates()){
						//$this->_flash(,'warning');
						$return['errors'][] = __(sprintf('Row %d failed to validate. Error: '.
						print_r($this->validationErrors,true),$i), true);					
					}				
					// save the row
					else{
						try{
							$isnotcatch=true;
							$issave=$this->saveAssociated($data);
							try{
							}catch(Exception $e){	
								$return['errors'][] = __(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
								$issave=false;
								$isnotcatch=true;
							}
						}catch(Exception $e){	
							$return['errors'][] = __(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
							$issave=false;
						}	
						if (!$issave && $isnotcatch){
							$return['errors'][] = __(sprintf('Row %d failed to save.'.print_r($this->validationErrors,true),$i), true);
							$issave=false;
						}	
						else{	
							// success message!
							$return['messages'][] = __(sprintf('Row %d was saved.',$i), true);			
						}	
					}
				}
				else{
					$protomodel=new TProtocolInventory();
					$dataproto=array();
					foreach($fieldt2 as $ft1){
						$index=array_search($ft1, $field);				
						$val=$rowarray[$index];
						$val=@iconv (mb_detect_encoding($val),"ASCII//IGNORE",$val);
						if($ft1=="NOM ORIGINE")	continue;
						$ft1=$fieldnamereal[$ft1];							
						$dataproto+=array($ft1=>$val);
					}
					$dataproto+=array('FK_TSta_ID'=>$unifind[0]['Station']['TSta_PK_ID']);
										
					$taxon=$rowarray[array_search("TAXON", $field)];
					
					$taxon=@iconv (mb_detect_encoding($taxon),"ASCII//IGNORE",$taxon);
					$idtaxon=array();
					$name='';
					
					/*if($i>1270){
						$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res3", 'a');			
						fwrite($fp, " $i $taxon\n");
					}*/
									
					$idtaxon=$taxonname->find("all",array(  
						'recursive'=> -1,
						'fields'=>array('FK_Taxon','NAME_WITH_AUTHORITY'),
						'conditions'=> array("NAME_WITHOUT_AUTHORITY"=>$taxon),
					));	
					/*
					if($i>1270){
						$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res3", 'a');			
						fwrite($fp, " $i ".print_r($taxon ,true)."\n");
					}*/	
							
					if(count($idtaxon)>0){
						$dataproto+=array('Id_Taxon'=>$idtaxon[0]['TaxonName']['FK_Taxon']);
						$rttaxon=$ttaxon->find('first',array(   
							'recursive'=> -1,
							'fields'=>'NAME_VALID_WITH_AUTHORITY',
							'conditions'=> array("ID_TAXON"=>$idtaxon[0]['TaxonName']['FK_Taxon'])
						));
						if(count($idtaxon)>1){
							$str="";
							foreach($idtaxon as $t){
								$str.=" - '".$t['TaxonName']['NAME_WITH_AUTHORITY']."'";
							}
							$str.=". '".$idtaxon[0]['TaxonName']['NAME_WITH_AUTHORITY']."' have been chosen";
							$return['warning'][] = __(sprintf("Row %d warning. Multiple choose possible for '$taxon' : ".$str,$i), true);
						}
						$dataproto+=array('Name_Taxon'=>$idtaxon[0]['TaxonName']['NAME_WITH_AUTHORITY']);
						$dataproto+=array('Original_Name'=>$taxon);
						$dataproto+=array('Identity_sure'=>0);	
					}
					else{
						$return['errors'][] = __(sprintf("Row %d failed to save. Taxon not find for '".$taxon."'",$i), true);
						continue;
					}
					
					$protomodel->create();				
					// validate the row			
					$protomodel->set($data);
					if (!$protomodel->validates()){
						//$protomodel->_flash(,'warning');
						$return['errors'][] = __(sprintf('Row %d failed to validate. Error: '.
						print_r($protomodel->validationErrors,true),$i), true);					
					}				
					// save the row
					else{
						try{
							$isnotcatch=true;
							$issave=$protomodel->save($dataproto);
						}catch(Exception $e){							
							$issave=false;
							$isnotcatch=false;
							$return['errors'][] = __(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
						}	
						if (!$issave && $isnotcatch){
							$return['errors'][] = __(sprintf('Row %d failed to save. Error :'.$e->getMessage(),$i), true);
						}	
						else{	
						// success message!
							$return['messages'][] = __(sprintf('Row %d was saved. Station already exist so only the protocole has been added.',$i), true);			
						}	
					}
					
				}
				//if($i==1500)break;				
			}
			else{
				$return['errors'][] = __(sprintf('Row %d failed to save. Row field count error',$i), true);
				continue;
			}	
 		}
 		/*____________________________________*/
		
		if($i==0){
			$return['errors'][] = __(sprintf('No file or file empty',$i), true);
		}
		
 		// close the file
 		fclose($handle);
 		
 		// return the messages
 		return $return;
 		
	}
	/*_________________________________________________*/
}	 
?>