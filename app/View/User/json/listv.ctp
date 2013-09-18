[<?php  for($i=0;$i<sizeof($v);$i++):?>
{"id":"<?php echo $v[$i]['Model']['TUse_Pk_ID']?>","Nom":"<?php echo $v[$i]['Model']['TUse_Nom']?>","Prenom":"<?php echo $v[$i]['Model']['TUse_Prenom']?>","Role":"<?php echo $v[$i]['TRolesJoin']['TRol_Type']?>"}<?php if($i<sizeof($v)-1)echo ",";?>
<?php endfor?>]