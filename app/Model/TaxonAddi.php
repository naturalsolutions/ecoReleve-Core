<?php
class TaxonAddi extends AppModel {
	public $useDbConfig = 'taxon';
	public $useTable = 'TTaxa_additional_values';	
	public $primaryKey = 'aditional_value_Pk';

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			if (isset($val['Additional']['value_precision'])) {
				$aut=json_decode($val['Additional']['value_precision'],true);
				$results[$key]['Additional']['value_precision'] = $aut[0]['Author'];
			}
		}
		return $results;
	}	
	
	public function beforeSave($options = array()) {
		/*$fp = fopen("app/webroot/gps/file", 'w');	
		$fp2 = fopen("app/webroot/gps/file2", 'w');	
		if (isset($this->data['Additional']['value_precision'])) {
			$this->data['Additional']['value_precision'] = '[{"Author":"'.$this->data['Additional']['value_precision'].'"}]';
		}
		if($this->data['Additional']['value']==""){
			fwrite($fp, print_r($this->data,true));
			$this->data['Additional']=array();
			fwrite($fp2, print_r($this->data,true));
		}*/	
		
		return true;
	}
}	 
?>