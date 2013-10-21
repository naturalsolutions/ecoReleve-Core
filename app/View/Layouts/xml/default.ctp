<?php
 if(!isset($test)){
	header("content-type: application/xml"); 
 }
 ?>
<?php echo $this->fetch('content'); ?>
