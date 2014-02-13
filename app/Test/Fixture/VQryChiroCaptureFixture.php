<?php
/**
 * VQryChiroCaptureFixture
 *
 */
class VQryChiroCaptureFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'V_Qry_Chiro_capture';

/**
 * Import
 *
 * @var array
 */
	public $import = array('connection' => 'ecwp_ereleve');

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'Vernacular_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'Latin_name' => array('type' => 'text', 'null' => true, 'default' => null),
		'Dead' => array('type' => 'boolean', 'null' => false, 'default' => null, 'length' => '1'),
		'Number' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Hour' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Ind_Id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'Age' => array('type' => 'string', 'null' => true, 'default' => null),
		'Sex' => array('type' => 'string', 'null' => true, 'default' => null)
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'Vernacular_name' => 'Plecotus teneriffae',
			'Latin_name' => 'Plecotus teneriffae',
			'Dead' => 0,
			'Number' => '0',
			'Hour' => '19000101 21:00:00',
			'Ind_Id' => 'ple5170907',
			'Age' => 'adult',
			'Sex' => 'female'
		)
	);

}
