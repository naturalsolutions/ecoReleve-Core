<?php if ($find==1):?>
<?php 
if(isset($result[0]['Value']))
	$modelname='Value';
else 
	$modelname=0;			
?>
{"count":"<?php echo $totaldisplay?>","values":[<?php $i=0; foreach ($result as $t): ?>
{<?php $j=0;foreach($t[$modelname] as $key=>$val): ?><?php echo '"'.$key.'":"'.$val.'"';?><?php if($j<sizeof($t[$modelname])-1)echo ",";?>
<?php $j++;?>
<?php endforeach?>}<?php if($i<sizeof($result)-1)echo ",";?><?php $i++;?>	
<?php endforeach?>
]}	
<?php endif?>
<?php if($find==2):?>
	[{"count":<?php echo $result;?>}]
<?php endif?>
<?php if($find==-1):?>
	<?php echo '[{"message":"$message"}]'?>
<?php endif?>