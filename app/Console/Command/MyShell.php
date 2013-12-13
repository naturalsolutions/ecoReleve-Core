<?php
	App::uses('Model', 'Model');
	App::uses('MapSelectionManager', 'Model');
	
	class MyShell extends AppShell {
		public function main() {
			$this->out('Hello world.');
		}

		public function proto_list() {
			$proto=new Model('TProtocole','TProtocole','ereleve');
			$this->out('Proto list: ' . print_r($proto->find('all'),true));
		}
		
		public function gwrite_test() {
			$file_name="gwrite_test";
			$fp = fopen("$file_name.gpx", 'w');			
			fwrite($fp, print_r("blabla",true));
			//$this->out();
		}
	}
?>