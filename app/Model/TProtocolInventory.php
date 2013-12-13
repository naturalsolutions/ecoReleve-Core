<?php
App::uses('AppModel', 'Model');
App::uses('Tthesaurus', 'Model');
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
	
	/*________________VALIDATOR______________*/
	public $validate = array(
        'Name_Habitat' => array(
			'rule' => array('habitatcheck'),	   
            'message' => "Not a good 'habibat'"
        ),
		'Name_Substatum' => array(
			'rule' => array('substratscheck'),	   
            'message' => "Not a good 'substrat'"
        )
    );
	
	function habitatcheck($proto){
		//$res=true;
		//$fp = fopen("app/webroot/gps/file", 'a');
		//fwrite($fp, "proto: ".print_r($proto,true)."\n");	
		if(isset($proto['Name_Habitat'])){
			$habitat=$proto['Name_Habitat'];
			if($habitat=="habitats" || $habitat=="substrats"){
				//fwrite($fp, "falsehab: ".print_r($habitat,true)."\n");
				return false;
			}
			else if($habitat!=""){
				$thesau=new Tthesaurus();
				//fwrite($fp, "hab: ".print_r($habitat,true)."\n");
				$thesauarray=$thesau->find('first',array('conditions'=>array('Id_Type'=>'1','topic_fr'=>$habitat)));
				if(count($thesauarray)==0 || !is_array($thesauarray))
					return false;
			}
		}
		return true;	
	}
	
	function substratscheck($proto){		
		if(isset($proto['Name_Substatum'])){
			$substrat=$proto['Name_Substatum'];
			if($substrat=="substrats"){
				return false;
			}
			else if($substrat!=""){
				$thesau=new Tthesaurus();
				$thesauarray=$thesau->find('first',array('conditions'=>array('Id_Type'=>'2','topic_fr'=>$substrat)));
				if(count($thesauarray)==0 || !is_array($thesauarray))
					return false;
			}
		}
		return true;	
	}
}
