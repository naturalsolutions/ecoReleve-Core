<?php if ($find==1):?>
	<?php //echo json_encode($result);?>
	<?php
		$num_import="";
		if(isset($result['num_import']))
			$num_import=',"num_import":"'.$result['num_import']
	?>
	<?php echo '[{"nbsuccess":"'.$nb_success.'","nberror":"'.$nb_error.'","nbwarning":"'.$nb_warning.$num_import.'"}]'?>
<?php endif?>

<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>