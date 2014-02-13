<?php
class StationControllerTest extends ControllerTestCase {
	public $fixtures = array('app.Stationsimpleexemple');
	
	public function setUp() {
		Cache::clear();
		clearCache();
	}
	
	//check if return a good json for a datatable js
	public function test_station_get_is_json_datatable() {
		//$this->loadFixtures('Stationsimpleexemple');
		$result = $this->testAction('/station/list?iDisplayLength=2&limit=2', array('return' => 'view'));	
		$Stations_json_array=json_decode($this->view,true);
		
		$this->assertArrayHasKey('sEcho', $Stations_json_array);
		$this->assertArrayHasKey('iTotalRecords', $Stations_json_array);
		$this->assertArrayHasKey('iTotalDisplayRecords', $Stations_json_array);
		$this->assertArrayHasKey('aaData', $Stations_json_array);
		$this->assertArrayHasKey('aoColumns', $Stations_json_array);
		
		debug($result);
	}
	
	//test if station list from new ereleve tables not return a http error
	public function test_station_list2() {
		$result = $this->testAction('/station/list2?limit=2&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);	
	}	
	
	//test if station carto from old ereleve tables not return a http error
	public function test_station_carto() {
		$result = $this->testAction('/station/carto?limit=2', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);	
	}	
	
	//test if station carto from new ereleve tables not return a http error
	public function test_station_carto2() {
		$result = $this->testAction('/station/carto2?limit=2', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);	
	}

	//test if station carto from new ereleve tables not return a http error
	public function test_station_importcsv() {
		$result = $this->testAction('/station/import_csv', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);	
	}		
}