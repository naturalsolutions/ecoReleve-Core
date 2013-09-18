<protocoles>
<?php foreach ($protos as $p): ?>	
	<protocole id="<?php if(isset($p['AppModel']['TTheEt_PK_ID']))echo $p['AppModel']['TTheEt_PK_ID'];
						else if(isset($p['AppModel']['ttheEt_PK_ID'])) echo $p['AppModel']['ttheEt_PK_ID']?>">
							<?php echo $p['AppModel']['Caption'];?></protocole>		
<?php endforeach; ?>
</protocoles>


