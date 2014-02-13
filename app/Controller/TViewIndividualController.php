<?php
	App::uses('AppController','Controller');
	class TViewIndividualController extends AppController{
		var $helpers = array('Xml', 'Text','form','html','Cache','Json');
		public $components = array('RequestHandler');
		public $cacheAction = array(  //set the method(webservice) with a cached result
		
			//'proto_list' => cache_time
		);
		
		function index(){
			
		}			
	}

?>