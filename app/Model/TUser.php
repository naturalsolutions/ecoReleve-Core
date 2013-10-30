<?php
App::uses('TAutorisation', 'Model');
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
	
	public $hasAndBelongsToMany  = array(
        'Application' => array(
            'className' => 'TApplication',
			'joinTable' => 'TAutorisations',
			'foreignKey' => 'TAut_FK_TUse_PK_ID',
			'associationForeignKey' => 'TAut_FK_TApp_PK_ID',
			'conditions' => "((select TRol_Type from TRoles where TRol_PK_ID=[TAutorisation].TAut_FK_TRol_PK_ID)!='Interdit')"
        )
    );

}
