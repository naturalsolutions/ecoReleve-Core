<?php
App::uses('AppModel', 'Model');
/**
 * TUser Model
 *
 */
class TUser extends AppModel {

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
	public $useTable = 'TUsers';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'TUse_Pk_ID';
	
	
	
	public $hasMany = array(
        'Autorisations' => array(
            'className' => 'TAutorisation',
			'foreignKey' => 'TAut_FK_TUse_PK_ID'
        )
	);
	
	public $validate = array(
        'TUse_Login' => array(
			'rule' => 'notEmpty'
        ),
		 'TUse_Password' => array(
			'rule' => 'notEmpty'
        )
    );
	
	public function beforeSave($options = array()) {
		if (!empty($this->data['TUser']['TUse_DateCreation'])) {
			$this->data['TUser']['TUse_DateCreation'] = str_replace("-","",$this->data['TUser']['TUse_DateCreation']);			
		}
		return true;
	}

	
}
