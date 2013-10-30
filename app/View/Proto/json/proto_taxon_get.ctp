<?php if($find==1):?>
<?php 
	echo json_encode($taxons);
?>
<?php endif?>
<?php if($find==0):?>
	<?php echo '[{"message":"Argument id_proto not set"}]'?>
<?php endif?>
<?php if($find==-1):?>
	<?php echo '[{"message":"This table does not exist"}]'?>
<?php endif?>
<?php if($find==-2):?>
	<?php echo '[{"message":"This table has not taxon field"}]'?>
<?php endif?>