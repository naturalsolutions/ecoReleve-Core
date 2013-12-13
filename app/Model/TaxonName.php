<?php
class TaxonName extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'TTaxa_name';
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