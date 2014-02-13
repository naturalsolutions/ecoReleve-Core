<?php
class TaxonControllerTest extends ControllerTestCase {
	public function setUp() {
		//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
		//fwrite($fp, print_r("clear",true));
		Cache::clear();
		clearCache();
	}
	
	
	//test if taxon get not return a http error
	public function test_taxon_get() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('taxon/get/14111111?format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	
	
	//test if taxon autocomplete list not return a http error
	public function test_taxon_autocomplete() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('/taxon/list/autocomplete?filter=coll dry&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}
	
	//test if taxon list for a table not return a http error
	public function test_taxon_list() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('/taxon/list?filter=coll dry&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	
	
	//test if taxon count not return a http error
	public function test_taxon_count() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('/taxon/list/count?filter=coll dry&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	
	
	//test if vernacular autocomplete not return a http error
	public function test_vernacular_autocomplete() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('/vernacular/list/autocomplete?filter=col&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	
	
	//test if vernacular list for a table not return a http error
	public function test_vernacular_list() {
		//$this->loadFixtures('Protocolelistallactive');
		$result = $this->testAction('/vernacular/list?filter=col&format=json', array('return' => 'view'));		
		
        debug($result);
		//$this->assertTrue(true);
	
	}	
	
}
?>