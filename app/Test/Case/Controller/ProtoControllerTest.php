<?php
class ProtoControllerTest extends ControllerTestCase {
	//public $fixtures = array('app.Protocolelistallactive','app.Stationsimpleexemple','app.Protocolelistwithtaxon','app.R2');
	public $autoFixtures = false;	
	
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
	
	
	//test if list protocole webservice return revelant data
	public function test_revelant_proto_list() {
		//$this->loadFixtures('Protocolelistallactive');
		$result1 = $this->testAction('protocole/list', array('return' => 'view'));		
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$protocolenodes=$xml->getElementsByTagName("protocole");
		$this->assertEquals($protocolenodes->length,21); //right length test
		//$this->assertCount(0, array('foo')); //marche que pour les array				
        debug($result1);
		//$this->assertTrue(true);	
	}
	
	//check if its a right xml returning by protocolistlist webservice using a schema validator	
	public function test_valide_proto_list() {
		$result2 = $this->testAction('protocole/list', array('return' => 'view'));
		$dom = new DOMDocument;		
		try{
			$doc = $dom->loadXML($this->view);
			$dom->schemaValidate('Protocole_list.xsd');
			$this->assertTrue(true);
		}catch(Exception $e){
			$this->assertTrue(false);
		} 
		debug($result2);
	}
	
	//check if taxon protocole list service return a good xml
	public function test_valide_proto_taxon_list() {
		$result2 = $this->testAction('protocole/taxon/list?id_proto=12', array('return' => 'view'));	
		$dom = new DOMDocument;	
		try{
			$doc = $dom->loadXML($this->view);
			$dom->schemaValidate('Proto_taxons.xsd');
			$this->assertTrue(true);
		}catch(Exception $e){
			$this->assertTrue(false);
		}
		debug($result2);	
	}
	
	//check if taxon protocole list service return relevant data
	public function test_revelant_proto_taxon_list(){
		$result2 = $this->testAction('proto/proto_taxon_get?id_proto=12', array('return' => 'view'));
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$taxonnodes=$xml->getElementsByTagName("taxon");		
		$this->assertEquals($taxonnodes->length,2);
				
        debug($result2);	
	}
	
	
}
?>