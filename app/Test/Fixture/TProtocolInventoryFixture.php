<?php
/**
 * TProtocolInventoryFixture
 *
 */
class TProtocolInventoryFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TProtocol_Inventory';

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
		'PK' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'FK_TSta_ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '4'),
		'Id_Taxon' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '4'),
		'Name_Taxon' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'Original_Name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'Identity_sure' => array('type' => 'boolean', 'null' => true, 'default' => null, 'length' => '1'),
		'Id_Habitat' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Name_Habitat' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'Id_Substatum' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Name_Substatum' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'Host' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'Herbarium_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'Exsiccatum_num' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'Comments' => array('type' => 'string', 'null' => true, 'default' => null),
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
			'PK' => '915',
			'FK_TSta_ID' => '1',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus arvernensis',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => 'Helianthemum grandiflorum',
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '916',
			'FK_TSta_ID' => '2',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => 'Alchemilla pentaphyllea',
			'Herbarium_code' => 'G',
			'Exsiccatum_num' => 'K.63-193',
			'Comments' => null
		),
		array(
			'PK' => '917',
			'FK_TSta_ID' => '3',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '918',
			'FK_TSta_ID' => '52',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '919',
			'FK_TSta_ID' => '5',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '920',
			'FK_TSta_ID' => '6',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '921',
			'FK_TSta_ID' => '7',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '922',
			'FK_TSta_ID' => '8',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '923',
			'FK_TSta_ID' => '9',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
		array(
			'PK' => '924',
			'FK_TSta_ID' => '76',
			'Id_Taxon' => '18978',
			'Name_Taxon' => 'Agaricus campestris',
			'Original_Name' => null,
			'Identity_sure' => 0,
			'Id_Habitat' => null,
			'Name_Habitat' => 'Prairie alpine/subalpine',
			'Id_Substatum' => null,
			'Name_Substatum' => 'Humus, sol',
			'Host' => null,
			'Herbarium_code' => null,
			'Exsiccatum_num' => null,
			'Comments' => null
		),
	);

}
