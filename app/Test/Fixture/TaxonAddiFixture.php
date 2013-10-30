<?php
/**
 * TTaxaAdditonalValueFixture
 *
 */
class TaxonAddiFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TTaxa_additonal_values';

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
		'FK_ID_NAME' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
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
			'FK_ID_NAME' => '7',
			'FK_value_type' => 'image_url',
			'value' => './url',
			'value_precision' => null,
			'comments' => null
		),
		array(
			'aditional_value_Pk' => '2',
			'FK_ID_NAME' => '7',
			'FK_value_type' => 'additional',
			'value' => 'additional_val',
			'value_precision' => null,
			'comments' => null
		),
		array(
			'aditional_value_Pk' => '3',
			'FK_ID_NAME' => '1',
			'FK_value_type' => 'additional2',
			'value' => 'additional2_val',
			'value_precision' => null,
			'comments' => null
		),
		array(
			'aditional_value_Pk' => '4',
			'FK_ID_NAME' => '20',
			'FK_value_type' => 'additional3',
			'value' => 'additional3_val',
			'value_precision' => null,
			'comments' => null
		),
	);

}
