<Views>
	<?php foreach ($views as $v): ?>					
		<view id="<?php echo str_replace(" ","",$v['MapSelectionManager']['TSMan_sp_name'])?>"><?php  echo str_replace("_"," ",$v['MapSelectionManager']['TSMan_Layer_Name'])?></view>
	<?php endforeach?>
</Views>