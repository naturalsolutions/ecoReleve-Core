<?php if($find == 1):?>
{
"aaData":[
<?php $i=0; foreach ($table as $t): ?>
[
<?php $j=0;foreach($t['Model'] as $key=>$val): ?>
"<?php echo $val?>"<?php if($j<sizeof($t['Model'])-1)echo ",";?>
<?php $j++;?>
<?php endforeach?>
]<?php if($i<sizeof($table)-1)echo ",";?>	
<?php $i++;?>
<?php endforeach?>
],
"aoColumns": [
<?php $i=0; foreach($schema as $key=>$val): ?>
{"sTitle":"<?php echo $val?>"}<?php if($i<sizeof($schema)-1)echo ",";?>	
<?php $i++;?>
<?php endforeach?>
]
}
<?php endif?>
<?php if($find == 0):?>	
<?php echo json_encode(array('erreur'=>'Aucun protocole désigné. Veuillez indiquer le nom de la table sur un parametre ?table_name="nom table".'))?>
<?php endif?>
<?php if($find == -1):?>	
<?php echo json_encode(array('erreur'=>"Cette table n'existe pas."))?>
<?php endif?>
<?php if($find == -2):?>	
<?php echo json_encode(array('erreur'=>'Une(ou des) colonne(s) est(sont) inexistante(s).'))?>
<?php endif?>