<?php
class UserControllerTest extends ControllerTestCase {
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
		
	//test if user list not return a http error
	public function test_user_list() {
		$result = $this->testAction('/user/list?format=json', array('return' => 'view'));			
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if login not return a http error
	public function test_user_login() {
		$result = $this->testAction('/user/login?format=json', array('return' => 'view'));			
        debug($result);
		//$this->assertTrue(true);
	
	}		
}
?>