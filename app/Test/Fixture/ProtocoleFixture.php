<?php
/**
 * TProtocoleFixture
 *
 */
class ProtocoleFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TProtocole';

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
		'Relation' => array('type' => 'string', 'null' => true, 'default' => null),
		'Caption' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'Description' => array('type' => 'string', 'null' => true, 'default' => null),
		'Active' => array('type' => 'boolean', 'null' => false, 'default' => null, 'length' => '1'),
		'Creation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Creator' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'Support' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'ttheEt_PK_ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '4'),
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
			'Relation' => 'Simpitat',
			'Caption' => 'Simpbitat',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => null,
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '1'
		),
		array(
			'Relation' => 'Nest_Deion',
			'Caption' => 'Nt and clption',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '2'
		),
		array(
			'Relation' => 'Stription',
			'Caption' => 'Statscription',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '3'
		),
		array(
			'Relation' => 'Vertendividual',
			'Caption' => 'Ind',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '5'
		),
		array(
			'Relation' => 'Tck_Cue',
			'Caption' => 'Tra Clues',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '6'
		),
		array(
			'Relation' => 'Sighnditions',
			'Caption' => 'Siging itions',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '7'
		),
		array(
			'Relation' => 'Buildind_Acties',
			'Caption' => 'Builand Acities',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '10'
		),
		array(
			'Relation' => 'Transescription',
			'Caption' => 'Transects',
			'Description' => null,
			'Active' => 0,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '15'
		),
		array(
			'Relation' => 'VertebraGroup',
			'Caption' => 'Vertete group',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '16'
		),
		array(
			'Relation' => 'Bi Biometry',
			'Caption' => 'Biometry',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '17'
		),
		array(
			'Relation' => 'CapreGroup',
			'Caption' => 'VertebCature',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '18'
		),
		array(
			'Relation' => 'Verteividuath',
			'Caption' => 'Vertebe Individuth',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090127 11:10:06',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '20'
		),
		array(
			'Relation' => 'ArosDaS',
			'Caption' => 'Ar Data',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090620 15:33:07',
			'Creator' => '483',
			'Support' => null,
			'ttheEt_PK_ID' => '21'
		),
		array(
			'Relation' => 'Vertebrate_Interview',
			'Caption' => 'Vertebrate inquiry',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090623 15:05:59',
			'Creator' => '484',
			'Support' => null,
			'ttheEt_PK_ID' => '22'
		),
		array(
			'Relation' => 'ArgaArgos',
			'Caption' => 'Ar: ArData',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => null,
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '24'
		),
		array(
			'Relation' => 'ProtocoleTaxon',
			'Caption' => 'Vertebralease',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => null,
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '28'
		),
		array(
			'Relation' => 'Tribaquiry',
			'Caption' => 'Trl inqry',
			'Description' => null,
			'Active' => 1,
			'Creation_date' => '20090911 15:33:07',
			'Creator' => null,
			'Support' => null,
			'ttheEt_PK_ID' => '29'
		),
	);

}
