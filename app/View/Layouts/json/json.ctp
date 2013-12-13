<?php 
if(!isset($test)){
	header("Access-Control-Allow-Credentials: true");	
	if(isset($origin)){
		header("Access-Control-Allow-Origin: $origin");	
	}	
	else
		header("Access-Control-Allow-Origin: *");	
	//header('Content-Type: text/x-json'); 
	header("Access-Control-Allow-Headers: x-requested-With");
}
?>
<?php echo $this->fetch('content');?>