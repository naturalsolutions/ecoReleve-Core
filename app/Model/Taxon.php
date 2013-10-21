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
        ),
		'Additional' => array(
            'className' => 'TaxonAddi',
			'foreignKey' => 'FK_ID_NAME',
        )
    );
	
	
}	 
?>