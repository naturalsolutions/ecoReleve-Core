<schema view="<?php echo $table_name;?>">
	<?php foreach($schema as $hkey=>$types):?>
		<field name="<?php echo $hkey?>">
			<?php foreach($types as $htypes=>$val):?>
				<<?php echo $htypes?>><?php echo $val;?></<?php echo $htypes?>>
			<?php endforeach?>
		</field>
	<?php endforeach?>
</schema> 