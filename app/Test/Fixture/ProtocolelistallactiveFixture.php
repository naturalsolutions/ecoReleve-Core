<?php
	class ProtocolelistallactiveFixture extends CakeTestFixture {

		  /* Optionel. Définir cette propriété pour charger les fixtures dans une source de données de test différente */
		  public $useDbConfig = 'test';
		  public $fields = array(
			  'ttheEt_PK_ID' => array('type' => 'integer', 'key' => 'primary'),
			  'Relation' => array('type' => 'string', 'length' => 255, 'null' => false),
			  'Caption' => array('type' => 'string', 'length' => 255, 'null' => false),
			  'Description' => array('type' => 'string', 'length' => 255, 'null' => false),
			   'Active' => array('type' => 'integer', 'null' => false)
		  );
		  public $records = array(
			  array('ttheEt_PK_ID' => 1, 'Caption' => 'C1', 'Relation' => 'R1', 'Description' => 'D1', 'Active' => 1),
			  array('ttheEt_PK_ID' => 2, 'Caption' => 'C2', 'Relation' => 'R2', 'Description' => 'D2', 'Active' => 1),
			  array('ttheEt_PK_ID' => 3, 'Caption' => 'C3', 'Relation' => 'R3', 'Description' => 'D3', 'Active' => 1)
		  );
	}
 ?>