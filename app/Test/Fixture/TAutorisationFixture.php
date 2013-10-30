<?php
/**
 * TAutorisationFixture
 *
 */
class TAutorisationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TAutorisations';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'TAut_PK_ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'TAut_FK_TUse_PK_ID' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
		'TAut_FK_TRol_PK_ID' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => '4'),
		'TAut_FK_TApp_PK_ID' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => '4'),
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
			'TAut_PK_ID' => 1,
			'TAut_FK_TUse_PK_ID' => 1,
			'TAut_FK_TRol_PK_ID' => 1,
			'TAut_FK_TApp_PK_ID' => 1
		),
	);

}
