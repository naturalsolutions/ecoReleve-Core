<?php if ($find==1):?>
	<<?php echo strtolower($table_name)?> nb="<?php echo $nb?>" total="<?php echo $total?>">
		<?php foreach($result as $mresult):?>
			<?php foreach($mresult as $fresult):?>
				<<?php echo strtolower($column_name)?>>
					<?php echo htmlspecialchars($fresult[$column_name])?>
				</<?php echo strtolower($column_name)?>>
			<?php endforeach?>
		<?php endforeach?>
	</<?php echo strtolower($table_name)?>>
<?php endif?>

<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>