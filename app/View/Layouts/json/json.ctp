<?php 

	header("Access-Control-Allow-Credentials: true");
	
	if(isset($origin)){
		header("Access-Control-Allow-Origin: $origin");	
	}	
	else
		header("Access-Control-Allow-Origin: *");	
	
	header("Access-Control-Allow-Headers: x-requested-With");
	//header("Access-Control-Allow-Origin: http://localhost:81");	
	//header("Access-Control-Allow-Origin: file://");	
	//header('Content-Type: text/x-json'); 

?>
<?php echo $this->fetch('content');?>