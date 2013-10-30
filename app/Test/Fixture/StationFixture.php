<?php
/**
 * TStationFixture
 *
 */
class StationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TStations';

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
		'TSta_PK_ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'FieldWorker1' => array('type' => 'string', 'null' => true, 'default' => null),
		'FieldWorker2' => array('type' => 'string', 'null' => true, 'default' => null),
		'NbFieldWorker' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Id_FieldActivity' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Name_FieldActivity' => array('type' => 'string', 'null' => true, 'default' => null),
		'Name' => array('type' => 'string', 'null' => true, 'default' => null),
		'Area' => array('type' => 'string', 'null' => true, 'default' => null),
		'Locality' => array('type' => 'string', 'null' => true, 'default' => null),
		'DATE' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'LAT' => array('type' => 'float', 'null' => true, 'default' => null),
		'LON' => array('type' => 'float', 'null' => true, 'default' => null),
		'Precision' => array('type' => 'integer', 'null' => true, 'default' => '10', 'length' => '4'),
		'ELE' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Creator' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'Creation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Comments' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
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
			'TSta_PK_ID' => '1',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Pralognan-la-Vanoise',
			'Locality' => 'Cirque du Génépy',
			'DATE' => '19690914',
			'LAT' => '45.31980',
			'LON' => '6.71164',
			'Precision' => '10',
			'ELE' => '2200',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '2',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Pralognan-la-Vanoise',
			'Locality' => 'Lac des Assiettes',
			'DATE' => '19630826',
			'LAT' => '45.38893',
			'LON' => '6.78486',
			'Precision' => '10',
			'ELE' => '2530',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '3',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Pralognan-la-Vanoise',
			'Locality' => 'Refuge de Péclet-Polset',
			'DATE' => '19710819',
			'LAT' => '45.28940',
			'LON' => '6.65972',
			'Precision' => '10',
			'ELE' => '2500',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '4',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Bonneval-sur-Arc',
			'Locality' => 'Col de l\'Iseran',
			'DATE' => '19710819',
			'LAT' => '45.41690',
			'LON' => '7.03806',
			'Precision' => '10',
			'ELE' => '2650',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '5',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Bonneval-sur-Arc',
			'Locality' => 'Plan des Eaux',
			'DATE' => '19710822',
			'LAT' => '45.39290',
			'LON' => '7.07540',
			'Precision' => '10',
			'ELE' => '2700',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '6',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Bonneval-sur-Arc',
			'Locality' => 'Combe des Reys',
			'DATE' => '19820819',
			'LAT' => '45.39665',
			'LON' => '7.09086',
			'Precision' => '10',
			'ELE' => '2700',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '7',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Bonneval-sur-Arc',
			'Locality' => 'Combe des Reys',
			'DATE' => '19830903',
			'LAT' => '45.39665',
			'LON' => '7.09086',
			'Precision' => '10',
			'ELE' => '2700',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '8',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Bonneval-sur-Arc',
			'Locality' => 'Plan des Évettes',
			'DATE' => '19700818',
			'LAT' => '45.36300',
			'LON' => '7.10750',
			'Precision' => '10',
			'ELE' => '2300',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '9',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Bessans',
			'Locality' => 'Refuge d’Avérole',
			'DATE' => '19700426',
			'LAT' => '45.29738',
			'LON' => '7.08440',
			'Precision' => '10',
			'ELE' => '2230',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '10',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Termignon',
			'Locality' => 'Plan de Bellecombe',
			'DATE' => '19700823',
			'LAT' => '45.32780',
			'LON' => '6.82370',
			'Precision' => '10',
			'ELE' => '2300',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '11',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Termignon',
			'Locality' => 'Plan de Bellecombe',
			'DATE' => '19820829',
			'LAT' => '45.32780',
			'LON' => '6.82370',
			'Precision' => '10',
			'ELE' => '2300',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
		array(
			'TSta_PK_ID' => '12',
			'FieldWorker1' => 'R. Kühner',
			'FieldWorker2' => null,
			'NbFieldWorker' => null,
			'Id_FieldActivity' => null,
			'Name_FieldActivity' => null,
			'Name' => null,
			'Area' => 'Pralognan-la-Vanoise',
			'Locality' => 'Le Moriond',
			'DATE' => '19630726',
			'LAT' => '45.38676',
			'LON' => '6.76017',
			'Precision' => '10',
			'ELE' => '2150',
			'Creator' => null,
			'Creation_date' => null,
			'Comments' => null
		),
	);

}
