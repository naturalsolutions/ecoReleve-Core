<?php if ($find==1):?>
	<?php echo html_entity_decode(json_encode($result))?>
<?php endif?>
<?php if($find==2):?>
	[{"count":<?php echo $result;?>}]
<?php endif?>
<?php if($find==-1):?>
	<?php echo '[{"message":"$message"}]'?>
<?php endif?>