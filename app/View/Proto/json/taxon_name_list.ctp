<?php if ($find==1 && !$verna && !isset($table)):?>
[<?php for($i=0;$i<count($result);$i++):?>
<?php echo '{"TaxonName":{"NAME_WITHOUT_AUTHORITY":"'.$result[$i]['TaxonName']['NAME_WITHOUT_AUTHORITY'].'"}}'?>
<?php if($i<count($result)-1) echo ","?>
<?php endfor?>]
<?php endif?>
<?php if ($find==1 && !$verna && isset($table)):?>
[<?php for($i=0;$i<count($result);$i++):?>
<?php echo '{"TaxonName":{"FK_Taxon":"'.$result[$i]['TaxonName']['FK_Taxon'].'","NAME_WITHOUT_AUTHORITY":"'.$result[$i]['TaxonName']['NAME_WITHOUT_AUTHORITY'].'","AUTHORITY":"'.$result[$i]['TaxonName']['AUTHORITY'].'","NAME_VALID_WITH_AUTHORITY":"'.$result[$i]['TTaxaJoin']['NAME_VALID_WITH_AUTHORITY'].'","NAME_VERN_FR":"'.$result[$i]['TTaxaJoin']['NAME_VERN_FR'].'","RANK":"'.$result[$i]['TTaxaJoin']['RANK'].'"}}'?>
<?php if($i<count($result)-1) echo ","?>
<?php endfor?>]
<?php endif?>
<?php if ($find==1 && $verna && !isset($table)):?>
[<?php for($i=0;$i<count($result);$i++):?>
<?php echo '{"TaxonName":{"NAME_WITHOUT_AUTHORITY":"'.$result[$i]['Value']['NAME_VERN_FR'].'"}}'?>
<?php if($i<count($result)-1) echo ","?>
<?php endfor?>]
<?php endif?>
<?php if ($find==1 && $verna && isset($table)):?>
[<?php for($i=0;$i<count($result);$i++):?>
<?php echo '{"TaxonName":{"FK_Taxon":"'.$result[$i]['Value']['ID_TAXON'].'","NAME_WITHOUT_AUTHORITY":"'.$result[$i]['Value']['NAME_VALID_WITHOUT_AUTHORITY'].'","AUTHORITY":"'.$result[$i]['Value']['NAME_VALID_AUTHORITY'].'","NAME_VALID_WITH_AUTHORITY":"'.$result[$i]['Value']['NAME_VALID_WITH_AUTHORITY'].'","NAME_VERN_FR":"'.$result[$i]['Value']['NAME_VERN_FR'].'","RANK":"'.$result[$i]['Value']['RANK'].'"}}'?>
<?php if($i<count($result)-1) echo ","?>
<?php endfor?>]
<?php endif?>
<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>