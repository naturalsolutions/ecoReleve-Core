<?php
/**
 * TUserFixture
 *
 */
class TUserFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'TUsers';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'TUse_Pk_ID' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'TUse_Nom' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '100'),
		'TUse_Prenom' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '100'),
		'TUse_Actif' => array('type' => 'boolean', 'null' => true, 'default' => null, 'length' => '1'),
		'TUse_DateCreation' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'TUse_Login' => array('type' => 'string', 'null' => true, 'default' => null),
		'TUse_Password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '50'),
		'TUse_Departement' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'TUse_Language' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '5'),
		'TUse_DateModif' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => '4'),
		'TUse_Observateur' => array('type' => 'boolean', 'null' => true, 'default' => null, 'length' => '1'),
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
			'TUse_Pk_ID' => 1,
			'TUse_Nom' => 'Lorem ipsum dolor sit amet',
			'TUse_Prenom' => 'Lorem ipsum dolor sit amet',
			'TUse_Actif' => 1,
			'TUse_DateCreation' => '2013-10-29 14:43:52',
			'TUse_Login' => 'Lorem ipsum dolor sit amet',
			'TUse_Password' => 'Lorem ipsum dolor sit amet',
			'TUse_Departement' => 'Lorem ipsum dolor sit amet',
			'TUse_Language' => 'Lor',
			'TUse_DateModif' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'TUse_Observateur' => 1
		),
	);

}
