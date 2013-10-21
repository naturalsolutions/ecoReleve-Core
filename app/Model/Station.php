<?php
class Station extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'TStations';
	public $primaryKey = 'TSta_PK_ID';
	
	public $hasMany = array(
        'Additionnal' => array(
            'className' => 'StationAddi',
			'foreignKey' => 'FK_TSta_ID',
        )
	);	
	
}	 
?>