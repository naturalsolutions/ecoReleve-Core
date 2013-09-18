<?php echo $debug?>
<FAs>
	<?php $i=0;foreach ($FA as $f): ?>
		<FA id="<?php echo $i?>"><?php  echo htmlspecialchars($f['AppModel']['FieldActivity_Name']);?></FA>
		<?php $i++?>
	<?php endforeach?>
</FAs>