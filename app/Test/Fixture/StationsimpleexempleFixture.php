<?php
	class StationsimpleexempleFixture extends CakeTestFixture {
		
		/* Optionel. Définir cette propriété pour charger les fixtures dans une source de données de test différente */
		public $useDbConfig = 'test';		
		public $fields = array(
			'TSta_PK_ID' => array('type' => 'integer', 'key' => 'primary'),
			'Caption' => array('type' => 'string', 'length' => 255, 'null' => false),
			'Name' => array('type' => 'string', 'length' => 255, 'null' => false),
			'FieldActivity_Name' => array('type' => 'string', 'length' => 255, 'null' => false),
			'Region' => array('type' => 'string', 'length' => 255, 'null' => false),
			'Place' => array('type' => 'string', 'length' => 255, 'null' => false),
			'DATE' => array('type' => 'string', 'length' => 255, 'null' => false),
			'LAT' => array('type' => 'float',  'null' => false),
			'LON' => array('type' => 'float', 'null' => false)
		);	
		
		public $records = array(
			  array('TSta_PK_ID' => 1, 'Caption' => 'C1', 'Name' => 'N1', 'FieldActivity_Name' => 'F1', 'Region' => 'R1',
			  'Place' => 'P1','DATE' => 'D1','LAT' => 30.124,'LON' => 40.321),
			  array('TSta_PK_ID' => 2, 'Caption' => 'C2', 'Name' => 'N2', 'FieldActivity_Name' => 'F2', 'Region' => 'R2',
			  'Place' => 'P2','DATE' => 'D2','LAT' => 50.327,'LON' => 74.123)			  
		);
		
	}
?>