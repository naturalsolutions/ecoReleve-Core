<?php
class TaxonName extends AppModel {
	// public $useDbConfig = 'mycoflore';
	public $useTable = 'TTaxa_Name';
	public $primaryKey = 'ID_NAME';
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
		'Taxon' => array(
			'className' => 'Taxon',
			'foreignKey' => 'FK_Taxon',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}	 
?>