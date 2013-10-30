<?php if ($find==1):?>
	<?php echo json_encode($result)?>
<?php endif?>

<?php if($find==-1):?>
	<?php echo '[{"message":"$message"}]'?>
<?php endif?>