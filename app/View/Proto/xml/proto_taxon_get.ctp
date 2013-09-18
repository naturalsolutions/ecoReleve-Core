<taxons proto_name="<?php echo $table_name?>" havetaxon="<?php
	if($find!=1)echo "no";
	else echo "yes";	
?>">
	<?php if($find==1):?>
		<?php foreach($taxons as $taxon):?>
			<taxon><?php echo $taxon['AppModel']['Name_Taxon']?></taxon>
		<?php endforeach?>	
	<?php endif?>
	<?php if($find==0):?>
		<message>Argument id_proto not set</message>
	<?php endif?>
	<?php if($find==-1):?>
		<message>This table doesn't exist</message>
	<?php endif?>
	<?php if($find==-2):?>
		<message>This table hasn't taxon field</message>
	<?php endif?>
</taxons>