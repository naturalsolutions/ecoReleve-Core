<?php
/**
 * TStationsAdditonalValueFixture
 *
 */
class StationAddiFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TStations_additonal_values';

/**
 * Import
 *
 * @var array
 */
	public $import = array('connection' => 'mycoflore');

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'aditional_value_Pk' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'FK_TSta_ID' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'FK_value_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250),
		'value' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250),
		'value_precision' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000),
		'comments' => array('type' => 'string', 'null' => true, 'default' => null),
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
			'aditional_value_Pk' => '1',
			'FK_TSta_ID' => '1',
			'FK_value_type' => 'DEPT',
			'value' => '73',
			'value_precision' => null,
			'comments' => null
		),
		array(
			'aditional_value_Pk' => '2',
			'FK_TSta_ID' => '2',
			'FK_value_type' => 'DEPT',
			'value' => '73',
			'value_precision' => null,
			'comments' => null
		),
		array(
			'aditional_value_Pk' => '3',
			'FK_TSta_ID' => '3',
			'FK_value_type' => 'DEPT',
			'value' => '73',
			'value_precision' => null,
			'comments' => null
		),
		array(
			'aditional_value_Pk' => '4',
			'FK_TSta_ID' => '52',
			'FK_value_type' => 'DEPT',
			'value' => '73',
			'value_precision' => null,
			'comments' => null
		),
	);

}
