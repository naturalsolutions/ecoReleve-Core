<?php
App::uses('AppModel', 'Model');
/**
 * TAutorisation Model
 *
 */
class TRole extends AppModel {

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
	public $useTable = 'TRoles';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'TRol_PK_ID';

	
}
