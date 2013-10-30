<?php
/**
 * TApplicationFixture
 *
 */
class TApplicationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TApplications';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'TApp_PK_ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'TApp_Nom' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'TApp_ApplicationPath' => array('type' => 'string', 'null' => true, 'default' => null),
		'TApp_Description' => array('type' => 'string', 'null' => true, 'default' => null),
		'TApp_ImagePath' => array('type' => 'string', 'null' => true, 'default' => null),
		'TApp_Couleur' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '10'),
		'TApp_IconePath' => array('type' => 'string', 'null' => true, 'default' => null),
		'TApp_Ordre' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'TApp_PK_ID' => 1,
			'TApp_Nom' => 'Lorem ipsum dolor sit amet',
			'TApp_ApplicationPath' => 'Lorem ipsum dolor sit amet',
			'TApp_Description' => 'Lorem ipsum dolor sit amet',
			'TApp_ImagePath' => 'Lorem ipsum dolor sit amet',
			'TApp_Couleur' => 'Lorem ip',
			'TApp_IconePath' => 'Lorem ipsum dolor sit amet',
			'TApp_Ordre' => 1
		),
	);

}
