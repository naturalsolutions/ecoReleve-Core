<?php
/**
 * TTaxaNameFixture
 *
 */
class TaxonNameFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TTaxa_name';

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
		'ID_NAME' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'FK_Taxon' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'NAME_WITHOUT_AUTHORITY' => array('type' => 'string', 'null' => true, 'default' => null),
		'AUTHORITY' => array('type' => 'string', 'null' => true, 'default' => null),
		'NAME_WITH_AUTHORITY' => array('type' => 'string', 'null' => true, 'default' => null),
		'TAXREF_CD_NOM' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
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
			'ID_NAME' => '1',
			'FK_Taxon' => '18854',
			'NAME_WITHOUT_AUTHORITY' => 'setre leptopus',
			'AUTHORITY' => '(Scop.) etyerty',
			'NAME_WITH_AUTHORITY' => 'zert erty (Scop.) Gillet',
			'TAXREF_CD_NOM' => '29893'
		),
		array(
			'ID_NAME' => '39529',
			'FK_Taxon' => '18854',
			'NAME_WITHOUT_AUTHORITY' => 'zyrzt zertyzer',
			'AUTHORITY' => '(Scop.) Fr.',
			'NAME_WITH_AUTHORITY' => 'cvwxvd qdsfg (Scop.) Fr.',
			'TAXREF_CD_NOM' => '29891'
		),
		array(
			'ID_NAME' => '39536',
			'FK_Taxon' => '18854',
			'NAME_WITHOUT_AUTHORITY' => 'qsegte zqet var. leptopus',
			'AUTHORITY' => '(Fr.) Quélet',
			'NAME_WITH_AUTHORITY' => 'wxdfq qfez var. qsdfe (Fr.) Quélet',
			'TAXREF_CD_NOM' => '29892'
		),
	);

}
