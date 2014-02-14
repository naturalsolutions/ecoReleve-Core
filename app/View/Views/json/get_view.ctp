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
{"count":"<?php echo $totaldisplay?>","values":[<?php $i=0; foreach ($result as $t): ?>
{<?php $j=0;foreach($t[$ModelName] as $key=>$val): ?><?php echo '"'.$key.'":"'.$val.'"';?><?php if($j<sizeof($t[$ModelName])-1)echo ",";?>
<?php $j++;?>
<?php endforeach?>}<?php if($i<sizeof($result)-1)echo ",";?><?php $i++;?>	
<?php endforeach?>
]}
<?php endif?>
<?php if($find==2):?>
	[{"count":<?php echo $result;?>}]
<?php endif?>
