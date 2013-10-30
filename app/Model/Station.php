<?php
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
	
}	 
?>