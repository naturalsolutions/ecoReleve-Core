<?php if ($find==1):?>
<?php //echo json_encode($result);?>
<?php
$num_import="";
if(isset($result['num_import']))
$num_import=',"num_import":"'.$result['num_import'].'"'
?>
<?php echo '[{"nbsuccess":"'.$nb_success.'","error":'.json_encode($result['errors']).$num_import.',"warning":'.json_encode($result['warning']).'}]'?>
<?php endif?>

<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>