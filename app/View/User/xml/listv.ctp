<Users>
	<?php  for($i=0;$i<sizeof($v);$i++):?>
		<User>
			<id><?php echo $v[$i]['User']['TUse_Pk_ID']?></id>
			<nom><?php echo $v[$i]['User']['TUse_Nom']?></nom>
			<prenom><?php echo $v[$i]['User']['TUse_Prenom']?></prenom>
			<role><?php echo $v[$i]['Roles']['TRol_Type']?></role>
		</User>
	<?php endfor?>
</Users>

