<?php
App::uses('AppModel', 'Model');
/**
 * TAutorisation Model
 *
 */
class TAutorisation extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'user';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'TAutorisations';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'TAut_PK_ID';

	
}
