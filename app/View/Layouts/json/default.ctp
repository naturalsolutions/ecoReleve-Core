<?php
if(!isset($test)){
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
	header('Content-Type: text/x-json');
	header("Access-Control-Allow-Credentials: true");	
	if(isset($origin)){
		header("Access-Control-Allow-Origin: $origin");	
	}	
	else
		header("Access-Control-Allow-Origin: *");
} 
echo $content_for_layout;
?>