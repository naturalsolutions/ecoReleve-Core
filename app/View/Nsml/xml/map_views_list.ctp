<Views>
	<?php foreach ($views as $v): ?>
		<?php $table_name=$v['AppModel']['TSMan_sp_name'];
			//$fp = fopen($_SERVER['DOCUMENT_ROOT']."/tmp/res", 'w');		
			//fwrite($fp, print_r($table_name,true));
			if($model->column_exist($table_name,$date_name,$base) && $model->column_exist($table_name,array('LON'),$base) && $model->column_exist($table_name,array('LAT'),$base)):?>
				<view id="<?php echo $v['AppModel']['TSMan_sp_name']?>"><?php  echo str_replace("_"," ",$v['AppModel']['TSMan_Layer_Name'])?></view>
		<?php endif?>
	<?php endforeach?>
</Views>