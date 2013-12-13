<themes>
	<?php foreach ($views as $v): ?>					
		<theme id="<?php echo $v['MapSelectionManager']['TProt_PK_ID']?>"><?php  echo str_replace("_"," ",$v['MapSelectionManager']['Caption'])?></theme>
	<?php endforeach?>
</themes>