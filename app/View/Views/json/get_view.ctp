<?php if($find==0):?>
	[{"error":<?php echo "Missing 'table_name' parameter";?>}]
<?php endif?>
<?php if($find==-1):?>
	[{"error":<?php echo "'table_name' parameter wrong value";?>}]
<?php endif?>
<?php if($find==-2):?>
	[{"error":<?php echo "Column '$inexistant' unknown";?>}]
<?php endif?>
<?php if($find==1):?>
	<?php echo json_encode($result)?>
<?php endif?>
<?php if($find==2):?>
	[{"count":<?php echo $result;?>}]
<?php endif?>
