<?php
class ERExplorerControllerTest extends ControllerTestCase {
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
		
	//test if nsml get not return a http error
	public function test_nsml_get() {
		$result = $this->testAction('/nsml/get?table=V_Qry_Chiro_capture', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if nsml count not return a http error
	public function test_nsml_count() {
		$result = $this->testAction('/nsml/get/count?table=V_Qry_Chiro_capture', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if place list not return a http error
	public function test_place_autocomplete() {
		$result = $this->testAction('/place/list/autocomplete', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if region list not return a http error
	public function test_region_autocomplete() {
		$result = $this->testAction('/region/list/autocomplete', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if fieldactivity list not return a http error
	public function test_fieldactivity_autocomplete() {
		$result = $this->testAction('/fieldactivity/list/autocomplete', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
}
?>