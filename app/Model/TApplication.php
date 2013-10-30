<?php
App::uses('AppModel', 'Model');
/**
 * TApplication Model
 *
 */
class TApplication extends AppModel {

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
	public $useTable = 'TApplications';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'TApp_PK_ID';
	
	public $hasAndBelongsToMany  = array(
        'User' => array(
            'className' => 'TUser',
			'joinTable' => 'TAutorisations',
			'associationForeignKey' => 'TAut_FK_TUse_PK_ID',
			'foreignKey' => 'TAut_FK_TApp_PK_ID',
			'conditions' => "((select TRol_Type from TRoles where TRol_PK_ID=[TAutorisation].TAut_FK_TRol_PK_ID)!='Interdit')"
        )
    );

}
