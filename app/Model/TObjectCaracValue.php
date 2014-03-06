<?php
App::uses('AppModel', 'Model');
class TObjectCaracValue extends AppModel {
	public $useTable = 'TObj_Carac_value';
	public $primaryKey = 'Carac_value_Pk';
	
	public $belongsTo = array(
        'Object' => array(
            'className' => 'TObject',
            'foreignKey' => 'fk_object'
        ),
		'Indiv' => array(
			'className' => 'TViewIndividual',
            'foreignKey' => 'fk_object'
		)
    );
}