<?php
class Taxon extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'TTaxa';
	public $primaryKey = 'ID_TAXON';
	public $taxon_id= "ID_TAXON";
	
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
	
	
}	 
?>