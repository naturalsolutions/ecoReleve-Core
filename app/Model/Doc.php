<?php
App::uses('AppModel', 'Model');

class Doc extends AppModel {

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
