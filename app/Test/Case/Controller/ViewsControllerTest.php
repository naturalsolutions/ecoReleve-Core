<?php
class ViewsControllerTest extends ControllerTestCase {
	public $fixtures = array('app.VQryChiroCapture');
	public $autoFixtures = false;
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
		
	//test if views list not return a http error
	public function test_view_list() {
		$result = $this->testAction('/view/list?format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if views theme get not return a http error
	public function test_view_theme_list() {
		$result = $this->testAction('/view/theme/list?format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	

	//test if view get not return a http error
	public function test_view_get() {
		$result = $this->testAction('/view/get/V_Qry_Chiro_capture?limit=2&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}

	//test if view carto not return a http error
	public function test_view_carto() {
		$result = $this->testAction('/view/carto/V_Qry_Chiro_capture?limit=2&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	

	//test if view get count not return a http error
	public function test_view_get_count() {
		$result = $this->testAction('/view/get/V_Qry_Chiro_capture/count?limit=2&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	

	//test if view detail not return a http error
	public function test_view_detail() {
		$this->loadFixtures('VQryChiroCapture');
		$result = $this->testAction('/view/detail/V_Qry_Chiro_capture?limit=2&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}		
}
?>