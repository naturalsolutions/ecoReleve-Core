<?php
App::uses('AppModel', 'Model');
/**
 * TProtocolInventory Model
 *
 * @property TTaxa $ProtocoleTaxon
 */
class TProtocolInventory extends AppModel {

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
	public $useTable = 'TProtocol_Inventory';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'PK';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ProtocoleTaxon' => array(
			'className' => 'Taxon',
			'foreignKey' => 'Id_Taxon',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)/*,
		'ProtocoleStation' => array(
			'className' => 'Station',
			'foreignKey' => 'FK_TSta_ID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);
}
