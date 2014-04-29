<?php
App::uses('TaxrefList', 'Model');
App::uses('Taxref', 'Model');
App::uses('TaxonName', 'Model');
class Taxon extends AppModel {
	public $useDbConfig = 'taxon';
	public $useTable = 'TTaxa';
	public $primaryKey = 'ID_TAXON';
	public $actsAs = array('Containable');
	
	public $hasMany = array(
        'Synonymous' => array(
            'className' => 'TaxonName',
			'foreignKey' => 'FK_Taxon',
			'conditions' => "(select FK_PREFERED_NAME from TTaxa where FK_Taxon=ID_TAXON)!=ID_NAME"
        ),
		'Additional' => array(
            'className' => 'TaxonAddi',
			'foreignKey' => 'FK_ID_TAXON',
        )
    );
	
	public function importTaxref($count,$limit=null,$offset=null,$condition=null,$taxrefversion=null,$deletedo=null,$deletecond=null){
		if(!$limit)
			$limit=1000;
		if(!$offset)
			$offset=0;
		if(!$taxrefversion)	
			$taxrefversion="7.0";
		if(!$condition)	
			$condition=array();				
		if(!$deletedo)	
			$deletedo=1;		
		if(!$deletecond)	
			$deletecond=array();	
		$taxlist=new TaxrefList();
		$tlist=$taxlist->find("first",array(
			"conditions"=>array("Version"=>$taxrefversion)
		));
		if(count($tlist)>0){
			$taxrefname=$tlist['TaxrefList']['Name'];
			$taxref=new Taxref();
			try{
				$taxref->setSource($taxrefname);
			}catch(Exception $e){
				$tablenotfind=false;
			}	
			if(!isset($tablenotfind) || !$tablenotfind){
				if($count!=0){
					$taximport=$taxref->find("count",array(
						"conditions"=>$condition
					));
					return array("message"=>$taximport);
				}
				else{
					$options['joins'] = array(
						array('table' => 'TaxrefLabelRank',
							'alias' => 'TaxrefLabelRank',
							'type' => 'LEFT',
							'conditions' => array(
								"TaxrefLabelRank.RankName  = RANG" 
							)
						)
					);
					
					$taximport=$taxref->find("all",array(
						"limit"=>$limit,
						"offset"=>intval($offset),
						//"order"=>array("TaxrefLabelRank.Position asc"),
						"conditions"=>$condition
					)+$options);
					$taxaall=array();
					$taxanameall=array();
					//array save for taxa and taxaname
					for($i=0;$i<count($taximport);$i++){
						if($taximport[$i]['Taxref']['CD_REF']==$taximport[$i]['Taxref']['CD_NOM']){
							if($i==0 || intval($taximport[$i]['Taxref']['CD_TAXSUP']=="349525"))
								$htaxon=null;
							else	
								$htaxon=intval($taximport[$i]['Taxref']['CD_TAXSUP']);
							$taxa=array("ID_TAXON"=>intval($taximport[$i]['Taxref']['CD_NOM']),"FK_PREFERED_NAME"=>intval($taximport[$i]['Taxref']['CD_NOM']),
							"ID_HIGHER_TAXON"=>$htaxon,"KINGDOM"=>$taximport[$i]['Taxref']['REGNE'],
							"PHYLUM"=>$taximport[$i]['Taxref']['PHYLUM'],"CLASS"=>$taximport[$i]['Taxref']['CLASSE'],
							"ORDER"=>$taximport[$i]['Taxref']['ORDRE'],"FAMILY"=>$taximport[$i]['Taxref']['FAMILLE'],
							"RANK"=>$taximport[$i]['Taxref']['RANG'],"NAME_VALID_AUTHORITY"=>$taximport[$i]['Taxref']['LB_AUTEUR'],
							"NAME_VALID_WITH_AUTHORITY"=>$taximport[$i]['Taxref']['NOM_VALIDE'],"NAME_VALID_WITHOUT_AUTHORITY"=>$taximport[$i]['Taxref']['LB_NOM'],
							"NAME_VERN_FR"=>$taximport[$i]['Taxref']['NOM_VERN'],"NAME_VERN_ENG"=>$taximport[$i]['Taxref']['NOM_VERN_ENG'],
							"TAXREF_CD_TAXSUP"=>intval($taximport[$i]['Taxref']['CD_TAXSUP']),"TAXREF_CD_REF"=>intval($taximport[$i]['Taxref']['CD_NOM']));
													
							$taxaall[]=$taxa;
						}	
						$taxaname=array("FK_Taxon"=>intval($taximport[$i]['Taxref']['CD_REF']),"NAME_WITHOUT_AUTHORITY"=>$taximport[$i]['Taxref']['LB_NOM'],
						"AUTHORITY"=>$taximport[$i]['Taxref']['LB_AUTEUR'],"NAME_WITH_AUTHORITY"=>$taximport[$i]['Taxref']['NOM_VALIDE'],
						"TAXREF_CD_NOM"=>intval($taximport[$i]['Taxref']['CD_NOM']));
						$taxanameall[]=$taxaname;	
					}	
					// print_r($taxaall);
					
					//delete if asked
					if($deletedo!=0){					
						if($this->find("count",array("conditions"=>array($deletecond)))!=0){
							if(count($deletecond)==0){
								if(!$this->deleteAll(array("KINGDOM = 'Animalia' or KINGDOM='Bacteria' or KINGDOM='Chromista' or KINGDOM='Fungi' or KINGDOM='Plantae' or KINGDOM='Protozoa'"),true)){
								// if(!$this->deleteAll(array('1=1'),false)){
									return array("message"=>"Error during deleting all TTAXA");
								}
							}	
							else{									
								if(!$this->deleteAll($deletecond, true)){
									return array("message"=>"Error during deleting TTAXA");
								}
							}
						}	
					}
					//save taxa
					try{
						if(!$this->saveMany($taxaall)){
							//error save taxa
							// print_r($taxaall);
							return array("message"=>"Error during the insert on ttaxa");
						}
					}catch(Exception $e){
						//error save taxa
						// print_r($e);
						return array("message"=>"Error during the insert on TTAXA");
					}
					
					//save taxaname
					$taxanametable=new TaxonName();
					try{
						if(!$taxanametable->saveMany($taxanameall)){
							//error save taxaname
							// print_r($taxanametable->validationErrors);
							return array("message"=>"Error during the insert on ttaxaname");
						}
					}catch(Exception $e){
						//error save taxaname
						// print_r($e);
						return array("message"=>"Error during the insert on TTAXANAME");
					}
				}
			}
			else{
				//table $taxrefname not find
				return array("message"=>"Error Taxref name '$taxrefname' not found");
			}
		}
		else{
			//taxref version not found
			return array("message"=>"Error Taxref version '$taxrefversion' not found");
		}		
		return array("message"=>"success");
	}
	
	public function beforeSave($options = array()) {
		//$fp = fopen("app/webroot/gps/file", 'w');	
		//$fp2 = fopen("app/webroot/gps/file2", 'w');			
		if (isset($this->data['Additional'])) {
			$addi=$this->data['Additional'];
			foreach($addi as $key=>$ad){
				if($ad['Additional']['value']==""){
					unset($this->data['Additional'][$key]);					
				}
			}
			//fwrite($fp2, "in");	
			//fwrite($fp, print_r($this->data,true));		
		}		
		return true;
	}
	
}	 
?>