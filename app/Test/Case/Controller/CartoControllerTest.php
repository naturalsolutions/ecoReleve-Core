<?php
class CartoControllerTest extends ControllerTestCase {
	public $fixtures = array('app.Stationsimpleexemple');
	
	public function setUp() {
		Cache::clear();
		clearCache();
	}
	
	//test if the get station from carto return a good geojson
	public function test_valide_carto_geojson(){
		$result = $this->testAction('carto/station_get?test=1&tabletest=Stationsimpleexemples', array('return' => 'view'));	
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');	
		fwrite($fp, print_r(json_decode($this->view,true),true));
		$geojson_array=	json_decode($this->view,true);
		$this->assertArrayHasKey('type', $geojson_array);
		$this->assertArrayHasKey('features', $geojson_array);		
		debug($result);
	}	
	
	//test if the get station from carto return a revelant geojson
	public function test_revelant_carto_geojson(){
		$result = $this->testAction('carto/station_get?test=1&tabletest=Stationsimpleexemples', array('return' => 'view'));	
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');	
		$geojson_array=	json_decode($this->view,true);
		$this->assertCount(2, $geojson_array['features']);
		$p1lat=
		fwrite($fp, print_r(json_decode($this->view,true),true));
		debug($result);
	}	
}