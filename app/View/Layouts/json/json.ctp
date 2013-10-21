<?php 
if(!isset($test)){
	//header("Access-Control-Allow-Origin: *");
	//header('Content-Type: text/x-json'); 
	header("Access-Control-Allow-Headers: x-requested-With");
}
?>
<?php echo $this->fetch('content');?>