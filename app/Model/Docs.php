<?php
App::uses('AppModel', 'Model');
/**
 * TApplication Model
 *
 */
class Docs extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'mycoflore';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Docs';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';
}
