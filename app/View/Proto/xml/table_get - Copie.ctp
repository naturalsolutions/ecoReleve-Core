<?xml version="1.0" encoding="utf-8"?>
<table name="<?php echo $nom?>">
<?php //print_r($c);?>
	<?php if($find == 1):?>
		<?php $i=1; foreach ($table as $t): ?>
			<tableval id="<?php echo $i?>">
				<?php foreach ($t['AppModel'] as $key=>$val): ?>
					<?php if(!$column_find || in_array($key,$schema)):?>
						<<?php echo htmlspecialchars($key);?> type="<?php echo $model->getColumnType($key) ?>">
						<?php echo htmlspecialchars($val);?>
						</<?php echo $key;?>>
					<?php endif?>					
				<?php endforeach?>
				<?php $i++?>
			</tableval>
		<?php endforeach; ?>
	<?php endif?>
	<?php if($find == 0):?>	
		Aucun protocole désigné. Veuillez indiquer le nom de la table sur un parametre ?table_name="nom_table".
	<?php endif?>
	<?php if($find == -1):?>
		Cette table n'existe pas.
	<?php endif?>	
	<?php if($find == -2):?>
		Une(ou des) des colonnes est inexistante.
	<?php endif?>
	<?php if($find == -3):?>
		Aucun format de sortie désigné ou format non pris en compte(format pris en compte json et xml). Veuillez indiquer le format souhaité sur un parametre ?format="nom_format".
	<?php endif?>
</table>