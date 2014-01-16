REPORT:
<?php if ($find==1):?>
<?php if ($nb_error>0):?>
STATE : ERROR
<?php if (isset($result['num_import'])):?>
Number of errors : <?php echo $nb_error.'
'?>
Import number for the sql error log table: <?php echo $result['num_import']?>	
<?php endif?>
<?php if($nb_error>10):?>
10 first error<?php endif?><?php for($i=0;$i<count($result['errors']) && $i<10;$i++):?>
<?php echo "
".$result['errors'][$i];?>
<?php endfor?>
<?php endif?>
<?php if ($nb_error==0):?>
STATE : SUCCESS 
Number of success import: <?php echo $nb_success.'
'?>		
<?php endif?>
<?php endif?>

<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>