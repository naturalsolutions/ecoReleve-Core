<?xml version="1.0"?>
<protocole name="<?php echo $nom?>">
	<?php if($find == 1):?>
		<?php foreach ($table as $t): ?>
			<protocolval>
				<?php while($champs_proto = current($t['Model'])):?>
					<<?php echo key($t['Model']);?> type="<?php echo $model->getColumnType(key($t['Model'])) ?>">
					<?php echo $champs_proto?>
					</<?php echo key($t['Model']);?>>
					<?php next($t['Model']);?>
				<?php endwhile?>
				
			</protocolval>
		<?php endforeach; ?>
		<?php endif?>
		<?php if($find == 0):?>	
		Aucun protocole désigné. Veuillez indiquer le nom du protocole sur un parametre ?proto_name="nom protocole".
	<?php endif?>
	<?php if($find == -1):?>
		Ce protocole n'existe pas.
	<?php endif?>	
</protocole>