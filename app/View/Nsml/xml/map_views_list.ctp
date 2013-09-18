<Views>
	<?php foreach ($views as $v): ?>
		<view id="<?php echo $v['AppModel']['TSMan_sp_name']?>"><?php  echo str_replace("_"," ",$v['AppModel']['TSMan_Layer_Name'])?></view>
	<?php endforeach?>
</Views>