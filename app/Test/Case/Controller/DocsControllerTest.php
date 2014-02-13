<?php
class DocsControllerTest extends ControllerTestCase {
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
		
	//test if taxon get not return a http error
	public function test_doc_list() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('/doc/list?format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}		
}
?>