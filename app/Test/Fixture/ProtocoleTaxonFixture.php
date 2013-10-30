<?php
/**
 * TProtocolReleaseGroupFixture
 *
 */
class ProtocoleTaxonFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TProtocol_ProtocoleTaxon';

/**
 * Import
 *
 * @var array
 */
	public $import = array('connection' => 'narc_ereleve');

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'PK' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'FK_TSta_ID' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Id_Taxon' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Name_Taxon' => array('type' => 'string', 'null' => true, 'default' => null),
		'Id_Release_Method' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Name_Release_Method' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
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
			'PK' => '1',
			'FK_TSta_ID' => '77',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '2',
			'FK_TSta_ID' => '78',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '3',
			'FK_TSta_ID' => '79',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '4',
			'FK_TSta_ID' => '143',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '5',
			'FK_TSta_ID' => '144',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '6',
			'FK_TSta_ID' => '145',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '7',
			'FK_TSta_ID' => '146',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '8',
			'FK_TSta_ID' => '147',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '9',
			'FK_TSta_ID' => '148',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '10',
			'FK_TSta_ID' => '238',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '11',
			'FK_TSta_ID' => '257',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '12',
			'FK_TSta_ID' => '258',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '13',
			'FK_TSta_ID' => '259',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000014',
			'Name_Release_Method' => 'Direct release',
			'Comments' => null
		),
		array(
			'PK' => '14',
			'FK_TSta_ID' => '868',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
		array(
			'PK' => '15',
			'FK_TSta_ID' => '869',
			'Id_Taxon' => '15891',
			'Name_Taxon' => 'Asian Houbara Bustard',
			'Id_Release_Method' => '1000015',
			'Name_Release_Method' => 'Cage release',
			'Comments' => null
		),
	);

}
