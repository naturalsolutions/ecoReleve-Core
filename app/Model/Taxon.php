<?php
class Taxon extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'TTaxa';
	public $primaryKey = 'ID_TAXON';
	public $taxon_id= "ID_TAXON";
	public $actsAs = array('Containable');
	
	public $hasMany = array(
        'Synonymous' => array(
            'className' => 'TaxonName',
			'foreignKey' => 'FK_Taxon',
			'conditions' => "(select FK_PREFERED_NAME from TTaxa where FK_Taxon=ID_TAXON)!=ID_NAME"
        ),
		'Additional' => array(
            'className' => 'TaxonAddi',
			'foreignKey' => 'FK_ID_NAME',
        )
    );
	
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