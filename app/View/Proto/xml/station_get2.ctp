<Stations>
	<?php foreach($result as $s):?>
		<Station>
			<?php foreach($s as $s2):?>
				<?php foreach($s2 as $key=>$val):?>
					<<?php echo $key?>>
						<?php echo $val?>
					</<?php echo $key?>>
				<?php endforeach?>
			<?php endforeach?>
		</Station>
	<?php endforeach?>
</Stations>
