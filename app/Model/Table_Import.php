<?php
class Table_Import extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'Table_Import_Error';
	public $primaryKey = 'ID';
	public $actsAs = array('Containable');		
}	 
?>