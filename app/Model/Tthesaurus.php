<?php
App::uses('AppModel', 'Model');
/**
 * TProtocolInventory Model
 *
 * @property TTaxa $ProtocoleTaxon
 */
class Tthesaurus extends AppModel {

	public $actsAs = array('Containable');
	
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
	public $useTable = 'Tthesaurus';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'PK';
}
