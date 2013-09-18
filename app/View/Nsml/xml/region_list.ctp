<?php echo $debug?>
<Regions>
	<?php $i=0;foreach ($region as $r): ?>
		<region id="<?php echo $i?>"><?php  echo htmlspecialchars($r['AppModel']['Region']);?></region>
		<?php $i++?>
	<?php endforeach?>
</Regions>