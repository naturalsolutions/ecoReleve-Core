<?php if(is_array($result)):?>
[
<?php $i=0;foreach($result as $c):?>
	{"<?php echo $field;?>": "<?php echo $c['TaxonFamilyCount'][$field];?>",
	"value": "<?php echo $c[0]['nb'];?>"
	}
	<?php $i++?>
	<?php if($i<count($result)) echo ",";?>	
<?php endforeach?>      
]   
<?php endif?>
<?php if(!is_array($result)):?>
<?php echo $result?>
<?php endif?>