<?php
	App::uses('Model', 'Model');
	class MyShell extends AppShell {
		public function main() {
			$this->out('Hello world.');
		}

		public function proto_list() {
			$proto=new Model('TProtocole','TProtocole','ereleve');
			$this->out('Proto list: ' . print_r($proto->find('all'),true));
		}
	}
?>