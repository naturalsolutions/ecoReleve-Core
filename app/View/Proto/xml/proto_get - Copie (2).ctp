<?xml version="1.0" encoding="utf-8"?>
<Protocol_Form xsi:noNamespaceSchemaLocation="Pocket_XSD_V3-1.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<protocol>
		<?php if($find == 1):?>
			<name>
				<display_label><?php echo $nom?></display_label>
				<label lang="fr"><?php echo $nom?></label>
			</name>
			<description>
				<label lang="fr"><?php echo $nom?></label>
			</description>
			<multispecies>false</multispecies>
			<monitoring>false</monitoring>
			<fields>
				<fieldset name="all">
					<?php $i=1; foreach ($model->schema() as $key=>$val): ?>
						<field_<?php $type = $model->getColumnType($key);$type_sortie=$type;
									if($type=="integer"){
										$type_sortie="numeric";
										echo $type_sortie;
									}	
									else		
										echo $type_sortie;?> id="<?php echo $i;?>">
							<name>
								<label lang="fr"><?php echo $key;?></label>
								<display_label lang="fr"><?php echo $key;?></display_label>
							</name>
							<description>
								<?php if($type=="integer"):?>
									<label lang="fr">Nombre</label>
								<?php endif?>
								<?php if(!$type=="integer"):?>
									<label/>
								<?php endif?>
							</description>
							<constraints>
								<?php if($type=="text"):?>
									<required>true</required>
									<string_length>50</string_length>
									<multiline>true</multiline>
								<?php endif?>
								<?php if($type=="integer"):?>
									<max_bound>100</max_bound>
									<min_bound>0</min_bound>
									<precision>1</precision>
								<?php endif?>
							</constraints>
							<?php if($type=="integer"):?>
								<default_value>0</default_value>
							<?php endif?>	
							<?php if(!$type=="integer"):?>
								<default_value/>
							<?php endif?>	
							<?php $i++; ?>
						</field_<?php echo $type_sortie;?>>								
					<?php endforeach?>
				</fieldset>
			</fields>		
		<?php endif?>
		<?php if($find == 0):?>	
			Aucun protocole désigné. Veuillez indiquer le nom du protocole sur un parametre ?proto_name="nom protocole".
		<?php endif?>
		<?php if($find == -1):?>
			Ce protocole n'existe pas.
		<?php endif?>	
	</protocol>
</Protocol_Form>