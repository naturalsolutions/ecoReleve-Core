<?php
class Table_Import extends AppModel {
	public $useDbConfig = 'mycoflore';
	public $useTable = 'Table_Import';
	public $primaryKey = 'ID';
	public $actsAs = array('Containable');		
}	 
?>