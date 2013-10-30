<?php
class ProtoControllerTest extends ControllerTestCase {
	public $fixtures = array('app.Taxon','app.TaxonName','app.TaxonAddi','app.Station','app.StationAddi'
	,'app.TProtocolInventory','app.Protocole','app.ProtocoleTaxon');
	//public $autoFixtures = false;	
	
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
		
		$this->column_detail= array("PK" => Array("cd" => "","td" => "Release Group,mot1,mot2,mot3,mot4" ),
							"FK_TSta_ID" => Array("cd" =>"","td" => "Release Group,mot1,mot2,mot3,mot4"),
							"Id_Taxon" => Array("cd" =>"","td" => "Release Group,mot1,mot2,mot3,mot4"),
							"Name_Taxon" => Array("cd" => "list:item1,item2,item3","td" => "Release Group,mot1,mot2,mot3,mot4"),
							"Id_Release_Method" => Array("cd" =>"","td" => "Release Group,mot1,mot2,mot3,mot4"),
							"Name_Release_Method" => Array("cd" => "list:item4,item5","td" => "Release Group,mot1,mot2,mot3,mot4"),
							"Comments" => Array("cd" => "text","td" => "Release Group,mot1,mot2,mot3,mot4")
							);		
	}
	
	public function test_revelant_taxon_get_xml(){
		$result = $this->testAction('proto/taxon_get?format=xml', array('return' => 'view'));		
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$taxonnodes=$xml->getElementsByTagName("taxonval");
		$this->assertEquals($taxonnodes->length,10);
        debug($result);
		//$this->assertTrue(true);
	}
	
	public function test_revelant_taxon_get_json(){
		$result = $this->testAction('proto/taxon_get?format=json', array('return' => 'view'));		
		$Taxon_json_array=json_decode($this->view,true);
		$this->assertEquals(count($Taxon_json_array),10);
       // debug($result);
		//$this->assertTrue(true);
	}
	
	public function test_revelant_taxon_name_list_json(){
		$result = $this->testAction('proto/column_list?format=json&table_name=TTaxa_name&column_name=NAME_WITHOUT_AUTHORITY', array('return' => 'view'));		
		$Name_list_json_array=json_decode($this->view,true);
		$this->assertEquals(count($Name_list_json_array),3);
       // debug($result);
		//$this->assertTrue(true);
	}
	
	public function test_revelant_station_json(){
		$result = $this->testAction('proto/station_get2?format=json', array('return' => 'view'));		
		$Station_json_array=json_decode($this->view,true);
		$this->assertEquals(count($Station_json_array),12);
        debug($result);
		//$this->assertTrue(true);
	}
	
	public function test_revelant_station_geojson(){
		$result = $this->testAction('proto/station_get2?format=geojson', array('return' => 'view'));		
		$geojson_array=	json_decode($this->view,true);
		$features = $geojson_array['features'];
		$this->assertEquals(count($features),12);
		$this->assertArrayHasKey('type', $geojson_array);
		$this->assertArrayHasKey('features', $geojson_array);
        debug($result);
		//$this->assertTrue(true);
	}
	
	public function test_revelant_station_datatablejs(){
		$result = $this->testAction('proto/station_get2?format=datatablejs&sEcho=1', array('return' => 'view'));		
		$Stations_json_array=json_decode($this->view,true);		
		$this->assertArrayHasKey('sEcho', $Stations_json_array);
		$this->assertArrayHasKey('iTotalRecords', $Stations_json_array);
		$this->assertArrayHasKey('iTotalDisplayRecords', $Stations_json_array);
		$this->assertArrayHasKey('aaData', $Stations_json_array);
		$this->assertArrayHasKey('aoColumns', $Stations_json_array);
        debug($result);
		//$this->assertTrue(true);
	}
	
	//test if list protocole webservice return revelant data
	public function test_revelant_proto_list() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('proto/proto_list', array('return' => 'view'));		
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$protocolenodes=$xml->getElementsByTagName("protocole");
		//$this->assertEquals($protocolenodes->length,16); //right length test
		
        debug($result);
		//$this->assertTrue(true);
	}
	
	//check if its a right xml returning by protocolistlist webservice using a schema validator	
	public function test_valide_proto_list() {
		$result = $this->testAction('proto/proto_list', array('return' => 'contents'));
		$dom = new DOMDocument;
		
		try{
			$doc = $dom->loadXML($this->contents);
			$dom->schemaValidate('Protocole_list.xsd');
			$this->assertTrue(true);
		}catch(Exception $e){
			$this->assertTrue(false);
		} 
		//debug($result);
	}
	
	//check if taxon protocole list service return a good xml
	public function test_valide_proto_taxon_list() {
		$result = $this->testAction('proto/proto_taxon_get?id_proto=28', array('return' => 'contents'));	
		$dom = new DOMDocument;	
		try{
			$doc = $dom->loadXML($this->contents);
			$dom->schemaValidate('Proto_taxons.xsd');
			$this->assertTrue(true);
		}catch(Exception $e){
			$this->assertTrue(false);
		}
		//debug($result);	
	}
	
	//check if taxon protocole list service return relevant data
	public function test_revelant_proto_taxon_list() {
		$result = $this->testAction('proto/proto_taxon_get?id_proto=28', array('return' => 'contents'));
		$xml = new DOMDocument;
		$xml->loadXML($this->view);
		$taxonnodes=$xml->getElementsByTagName("taxon");
		$this->assertEquals($taxonnodes->length,1);
		
        debug($result);	
	}
	
	public function test_valide_protocole_struture() {
		$this->autoMock =true;
		//create a mock for the description column methode
		$Proto=$this->generate('Proto', array(
			'methods' => array(
				'get_description_col'
			)
		));
		//$Proto= $this->getMock('ProtoController');
		$Proto->expects($this->any())
		  ->method('get_description_col')
		  ->will($this->returnValue($this->column_detail));
		
		
		//$this->controller=$Proto;
		$dom = new DOMDocument;
		//$dom->load('/path/to/your/phpunit.xml');
		$result = $this->testAction('proto/proto_get?id_proto=28', array('return' => 'contents'));
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');
		//fwrite($fp, $this->contents);
		$doc = $dom->loadXML($this->contents);
		debug($result);
		//$this->assertTrue($dom->schemaValidate('Pocket_XSD_V3-1.xsd'));
	}
	
	
}
?>