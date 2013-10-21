<?php
	//Protocole Fixture
	class R2Fixture extends CakeTestFixture {
		 public $useDbConfig = 'test';
		 public $fields = array(
			  'PKs' => array('type' => 'integer', 'key' => 'primary'),
			  'FK_TSta_ID' => array('type' => 'integer', 'null' => false),
			  'Name_Taxon' => array('type' => 'string', 'length' => 255, 'null' => false)			  
		  );
		  public $records = array(
			  array('PKs' => 1, 'FK_TSta_ID' => 1, 'Name_Taxon' => 'T1'),
			  array('PKs' => 2, 'FK_TSta_ID' => 2, 'Name_Taxon' => 'T2'),
			  array('PKs' => 3, 'FK_TSta_ID' => 1, 'Name_Taxon' => 'T3')
		  );
	}
?>	