<?php
class ProtoControllerTest extends ControllerTestCase {
	public $fixtures = array('app.Protocolelistallactive','app.Stationsimpleexemple','app.Protocolelistwithtaxon','app.R2');
	//public $autoFixtures = false;	
	
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
	
	
	//test if list protocole webservice return revelant data
	public function test_revelant_proto_list() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('proto/proto_list?test=1&tabletest=Protocolelistallactives', array('return' => 'view'));		
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$protocolenodes=$xml->getElementsByTagName("protocole");
		$this->assertEquals($protocolenodes->length,3); //right length test
		//$this->assertCount(0, array('foo')); //marche que pour les array
		for($i=0;$i<$protocolenodes->length;$i++){
			$protocol=$protocolenodes->item($i);
			$protoval=str_replace(array(" ","	","\n"),array("","",""),$protocol->nodeValue);
			$this->assertEquals("C".($i+1), $protoval);	//right value test 		
		}		
        debug($result);
		//$this->assertTrue(true);
	}
	
	//check if return a good json for a datatable js
	public function test_station_get_is_json_datatable() {
		//$this->loadFixtures('Stationsimpleexemple');
		$result = $this->testAction('proto/station_get?test=1&tabletest=Stationsimpleexemples', array('return' => 'view'));	
		$Stations_json_array=json_decode($this->view,true);
		
		$this->assertArrayHasKey('sEcho', $Stations_json_array);
		$this->assertArrayHasKey('iTotalRecords', $Stations_json_array);
		$this->assertArrayHasKey('iTotalDisplayRecords', $Stations_json_array);
		$this->assertArrayHasKey('aaData', $Stations_json_array);
		$this->assertArrayHasKey('aoColumns', $Stations_json_array);
		
		debug($result);
	}
	
	////test if station get webservice return revelant data without filter
	public function test_relevant_station_get() {
		//$this->loadFixtures('Stationsimpleexemple');
		$result = $this->testAction('proto/station_get?test=1&tabletest=Stationsimpleexemples', array('return' => 'view'));	
		$Stations_json_array=json_decode($this->view,true);
		$this->assertEquals($Stations_json_array['iTotalDisplayRecords'], 2);
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r(json_decode($this->view,true),true));
		debug($result);
	}
	
	//check if its a right xml returning by protocolistlist webservice using a schema validator	
	public function test_valide_proto_list() {
		$result = $this->testAction('proto/proto_list?test=1&tabletest=TProtocole', array('return' => 'contents'));
		$dom = new DOMDocument;
		
		try{
			$doc = $dom->loadXML($this->contents);
			$dom->schemaValidate('Protocole_list.xsd');
			$this->assertTrue(true);
		}catch(Exception $e){
			$this->assertTrue(false);
		} 
		debug($result);
	}
	
	//check if taxon protocole list service return a good xml
	public function test_valide_taxon_list() {
		$result = $this->testAction('proto/proto_taxon_get?id_proto=2&test=1&tabletest=Protocolelistwithtaxons', array('return' => 'contents'));	
		$dom = new DOMDocument;	
		try{
			$doc = $dom->loadXML($this->contents);
			$dom->schemaValidate('Proto_taxons.xsd');
			$this->assertTrue(true);
		}catch(Exception $e){
			$this->assertTrue(false);
		}
		debug($result);	
	}
	
	//check if taxon protocole list service return relevant data
	public function test_revelant_proto_taxon_list() {
		$result = $this->testAction('proto/proto_taxon_get?id_proto=2&test=1&tabletest=Protocolelistwithtaxons', array('return' => 'contents'));
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$taxonnodes=$xml->getElementsByTagName("taxon");
		$this->assertEquals($taxonnodes->length,3);
		for($i=0;$i<$taxonnodes->length;$i++){
			$taxon=$taxonnodes->item($i);
			$taxon=str_replace(array(" ","	","\n"),array("","",""),$taxon->nodeValue);
			$this->assertEquals("T".($i+1), $taxon);	//right value test 		
		}		
        debug($result);	
	}
	
	
	
	/*public function test_valide_protocole_struture() {
		$dom = new DOMDocument;
		//$dom->load('/path/to/your/phpunit.xml');
		$result = $this->testAction('protocole/structure?id_proto=28', array('return' => 'contents'));
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');
		//fwrite($fp, $this->contents);
		$doc = $dom->loadXML($this->contents);
		//$this->assertTrue($dom->schemaValidate('Pocket_XSD_V3-1.xsd'));
	}
	
	/**
	$this->testAction('/posts/add', array(
		'data' => array(
		'Post' => array('name' => 'New Post')
		)
	));*/
}
?>