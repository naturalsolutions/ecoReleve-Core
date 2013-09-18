<?php echo $debug?>
<Places>
	<?php $i=0;foreach ($place as $p): ?>
		<place id="<?php echo $i?>"><?php  echo htmlspecialchars($p['AppModel']['Place']);?></place>
		<?php $i++?>
	<?php endforeach?>
</Places>