REPORT:
<?php if ($find==1):?>
<?php if ($nb_error>0):?>
ERROR
<?php if (isset($result['num_import'])):?>
Nb error : <?php echo $nb_error.'
'?>
Num import error: <?php echo $result['num_import']?>	
<?php endif?>
<?php if($nb_error>10):?>
10 first error<?php endif?><?php for($i=0;$i<10;$i++):?>
<?php echo "
".$result['errors'][$i];?>
<?php endfor?>
<?php endif?>
<?php if ($nb_error==0):?>
SUCCESS 
Nb success : <?php echo $nb_success.'
'?>		
<?php endif?>
<?php endif?>

<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>