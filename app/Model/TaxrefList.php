<?php
App::uses('AppModel', 'Model');
class TaxrefList extends AppModel {
	public $useDbConfig = 'taxon';
	public $useTable = 'TaxrefList';
	public $primaryKey = 'ID';	
	
}	