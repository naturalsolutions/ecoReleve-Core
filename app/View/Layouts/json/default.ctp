<?php
	
	if(isset($origin)){
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Allow-Origin: $origin");	
	}	
	else
		header("Access-Control-Allow-Origin: *");
	
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
	header('Content-Type: text/x-json');

echo $content_for_layout;
?>