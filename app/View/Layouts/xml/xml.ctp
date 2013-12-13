<?php  
	header("Access-Control-Allow-Credentials: true");	
	if(isset($origin)){
		header("Access-Control-Allow-Origin: $origin");	
	}	
	else
		header("Access-Control-Allow-Origin: *");	
	//header("content-type: application/xml"); 
	header("Access-Control-Allow-Headers: x-requested-With");		
			
?>
<?php echo $this->fetch('content');?>