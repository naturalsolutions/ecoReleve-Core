<protocoles>
<?php foreach ($protos as $p): ?>	
	<protocole id="<?php if(isset($p['Protocole']['TTheEt_PK_ID']))echo $p['Protocole']['TTheEt_PK_ID'];
						else if(isset($p['Protocole']['ttheEt_PK_ID'])) echo $p['Protocole']['ttheEt_PK_ID']?>">
							<?php echo $p['Protocole']['Caption'];?></protocole>		
<?php endforeach; ?>
</protocoles>


