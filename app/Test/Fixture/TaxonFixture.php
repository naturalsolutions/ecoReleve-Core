<?php
/**
 * TTaxaFixture
 *
 */
class TaxonFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TTaxa';

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
		'ID_TAXON' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'FK_PREFERED_NAME' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'ID_HIGHER_TAXON' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'KINGDOM' => array('type' => 'string', 'null' => true, 'default' => null),
		'PHYLUM' => array('type' => 'string', 'null' => true, 'default' => null),
		'CLASS' => array('type' => 'string', 'null' => true, 'default' => null),
		'ORDER' => array('type' => 'string', 'null' => true, 'default' => null),
		'FAMILY' => array('type' => 'string', 'null' => true, 'default' => null),
		'RANK' => array('type' => 'string', 'null' => true, 'default' => null),
		'NAME_VALID_AUTHORITY' => array('type' => 'string', 'null' => true, 'default' => null),
		'NAME_VALID_WITH_AUTHORITY' => array('type' => 'string', 'null' => true, 'default' => null),
		'NAME_VALID_WITHOUT_AUTHORITY' => array('type' => 'string', 'null' => true, 'default' => null),
		'NAME_VERN_FR' => array('type' => 'text', 'null' => true, 'default' => null),
		'NAME_VERN_ENG' => array('type' => 'text', 'null' => true, 'default' => null),
		'TAXREF_CD_TAXSUP' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'TAXREF_CD_REF' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
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
			'ID_TAXON' => '1',
			'FK_PREFERED_NAME' => '2',
			'ID_HIGHER_TAXON' => '18852',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => 'pojpsdgorg',
			'CLASS' => null,
			'ORDER' => 'erhhtrh',
			'FAMILY' => 'ergher',
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => 'erthtrh obstrhcurosptrhorus C. Hahn',
			'NAME_VALID_WITH_AUTHORITY' => 'C. Hahn',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'htry zerztu',
			'NAME_VERN_FR' => '',
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195883',
			'TAXREF_CD_REF' => '465049'
		),
		array(
			'ID_TAXON' => '2',
			'FK_PREFERED_NAME' => '7',
			'ID_HIGHER_TAXON' => '18852',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => 'Basidiomycota',
			'CLASS' => null,
			'ORDER' => 'Boletales',
			'FAMILY' => 'Paxillaceae',
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => 'Singer',
			'NAME_VALID_WITH_AUTHORITY' => 'Paxillus polychrous Singer',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxillus polychrous',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195883',
			'TAXREF_CD_REF' => '29889'
		),
		array(
			'ID_TAXON' => '3',
			'FK_PREFERED_NAME' => '11',
			'ID_HIGHER_TAXON' => '18852',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => 'Basidiomycota',
			'CLASS' => null,
			'ORDER' => 'Boletales',
			'FAMILY' => 'Paxillaceae',
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => 'P.D. Orton',
			'NAME_VALID_WITH_AUTHORITY' => 'Paxillus rubicundulus P.D. Orton',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxillus rubicundulus',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195883',
			'TAXREF_CD_REF' => '29890'
		),
		array(
			'ID_TAXON' => '4',
			'FK_PREFERED_NAME' => '18',
			'ID_HIGHER_TAXON' => '18852',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => 'Basidiomycota',
			'CLASS' => null,
			'ORDER' => 'Boletales',
			'FAMILY' => 'Paxillaceae',
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => 'C. Hahn ',
			'NAME_VALID_WITH_AUTHORITY' => 'Paxillus validus C. Hahn',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxillus validus',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195883',
			'TAXREF_CD_REF' => '465047'
		),
		array(
			'ID_TAXON' => '5',
			'FK_PREFERED_NAME' => '19',
			'ID_HIGHER_TAXON' => '18852',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => 'Basidiomycota',
			'CLASS' => null,
			'ORDER' => 'Boletales',
			'FAMILY' => 'Paxillaceae',
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => 'Watling',
			'NAME_VALID_WITH_AUTHORITY' => 'Paxillus vernalis Watling',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxillus vernalis',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195883',
			'TAXREF_CD_REF' => '465046'
		),
		array(
			'ID_TAXON' => '6',
			'FK_PREFERED_NAME' => '20',
			'ID_HIGHER_TAXON' => '18852',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => 'Basidiomycota',
			'CLASS' => null,
			'ORDER' => 'Boletales',
			'FAMILY' => 'Paxillaceae',
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => 'Wasser',
			'NAME_VALID_WITH_AUTHORITY' => 'Paxillus zerovae Wasser',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxillus zerovae',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195883',
			'TAXREF_CD_REF' => '29894'
		),
		array(
			'ID_TAXON' => '7',
			'FK_PREFERED_NAME' => '21',
			'ID_HIGHER_TAXON' => '18974',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => null,
			'CLASS' => null,
			'ORDER' => null,
			'FAMILY' => null,
			'RANK' => 'GN',
			'NAME_VALID_AUTHORITY' => null,
			'NAME_VALID_WITH_AUTHORITY' => 'Paxina',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxina',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '187496',
			'TAXREF_CD_REF' => '195884'
		),
		array(
			'ID_TAXON' => '8',
			'FK_PREFERED_NAME' => '24',
			'ID_HIGHER_TAXON' => '7',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => null,
			'CLASS' => null,
			'ORDER' => null,
			'FAMILY' => null,
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => '(Boudier) Seaver',
			'NAME_VALID_WITH_AUTHORITY' => 'Paxina barlae (Boudier) Seaver',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Paxina barlae',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195884',
			'TAXREF_CD_REF' => '49050'
		),
		array(
			'ID_TAXON' => '9',
			'FK_PREFERED_NAME' => '30',
			'ID_HIGHER_TAXON' => '18974',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => null,
			'CLASS' => null,
			'ORDER' => null,
			'FAMILY' => null,
			'RANK' => 'GN',
			'NAME_VALID_AUTHORITY' => null,
			'NAME_VALID_WITH_AUTHORITY' => 'Peckiella',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Peckiella',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '187496',
			'TAXREF_CD_REF' => '195887'
		),
		array(
			'ID_TAXON' => '10',
			'FK_PREFERED_NAME' => '32',
			'ID_HIGHER_TAXON' => '9',
			'KINGDOM' => 'Fungi',
			'PHYLUM' => null,
			'CLASS' => null,
			'ORDER' => null,
			'FAMILY' => null,
			'RANK' => 'ES',
			'NAME_VALID_AUTHORITY' => '(Albertini & Schw.) Saccardo',
			'NAME_VALID_WITH_AUTHORITY' => 'Peckiella viridis (Albertini & Schw.) Saccardo',
			'NAME_VALID_WITHOUT_AUTHORITY' => 'Peckiella viridis',
			'NAME_VERN_FR' => null,
			'NAME_VERN_ENG' => null,
			'TAXREF_CD_TAXSUP' => '195887',
			'TAXREF_CD_REF' => '49053'
		),
	);

}
