<?xml version="1.0" encoding="utf-8"?>
<Protocol_Form xsi:noNamespaceSchemaLocation="Pocket_XSD_V3-1.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<?php echo $debug?>
	<protocol id="<?php echo $id_proto?>">
		<?php if($find == 1):?>
			<name>
				<display_label><?php echo str_replace("TProtocol","",str_replace("_"," ",$nom))?></display_label>
				<label lang="fr"><?php echo $nom?></label>
			</name>
			<description>
				<keywords>
					<?php $array_table_desc=split(",",$table_desc);foreach($array_table_desc as $v):?>
						<keyword>
							<?php echo $v?>
						</keyword>
					<?php endforeach?>
				</keywords>
				<label lang="fr"></label>
			</description>
			<multispecies>false</multispecies>
			<monitoring>false</monitoring>
			<fields>
				<fieldset name="all">
					<?php $i=1; foreach ($model->schema() as $key=>$val): //$key:name of column $val:array f column info?>  
						<?php //Field creation
							$type = $model->getColumnType($key);$type_sortie=$type; //default field output column type
							//not display if its an id or pk or fk							
							$colonne_decoupe=split("_",$key,2); if(stripos($key, "id")===false && stripos($key, "fk")===false &&stripos($key, "pk")===false):?>
							<?php //verify if the colunm is link with an id column for see if it's field list
								$list=false;
														
								if(sizeof($colonne_decoupe)>1 && (isset($model->schema()["Id_".$colonne_decoupe[1]]) || isset($model->schema()["ID_".$colonne_decoupe[1]]) || isset($model->schema()["id_".$colonne_decoupe[1]]))){
									if(isset($model->schema()["Id_".$colonne_decoupe[1]]))$id_type="Id";
									if(isset($model->schema()["ID_".$colonne_decoupe[1]]))$id_type="ID";
									if(isset($model->schema()["id_".$colonne_decoupe[1]]))$id_type="id";
									$list=true;
								}
							?>
							<?php $array_desc=split(":",$desc[$key]['cd']);	$type_sortie=$array_desc[0];?> 
							<field_<?php echo $type_sortie?> id="<?php echo $i;?>">
								<name>
									<label lang="fr"><?php echo $key;?></label>
									<display_label lang="fr"><?php echo str_replace("_"," ",$key)?></display_label>
								</name>
								<description>
									<?php if($type=="integer"):?>
										<label lang="fr">Nombre</label>
									<?php endif?>
									<?php if($type_sortie=="list"):?>
										
									<?php endif?>
									<?php if(!$type=="integer" && !$type_sortie=="list"):?>
										<label/>
									<?php endif?>
								</description>
								<constraints>
									<?php if($type_sortie=="text"):?>
										<required>true</required>
										<string_length>50</string_length>
										<multiline>true</multiline>
									<?php endif?>
									<?php if($type_sortie=="list"):?>
										<required>true</required>
									<?php endif?>
									<?php if($type=="integer"):?>
										<max_bound>100</max_bound>
										<min_bound>0</min_bound>
										<precision>1</precision>
									<?php endif?>
									<?php if($type=="boolean"):?>
										<required>true</required>									
									<?php endif?>
								</constraints>									
								<?php //generate the items
									if($type_sortie=="list"):?>
										<items>
											<?php
											$item_list="";
											$j=0;
											if(isset($array_desc[1]))
												foreach(split(",",$array_desc[1]) as $val){														
													$item_list.=htmlspecialchars("".$i.$j.";".$j.";".$val."|");													
												$j++;
												}
								?>
											<itemlist lg="en"><?php echo substr($item_list, 0, -1) ?> </itemlist>
											
										</items>
								<?php endif?>
								<?php if($type_sortie=="numeric"):?>
									<default_value>0</default_value>
								<?php endif?>
								<?php if($type_sortie=="list"):?>
									<default_value id="<?php echo $i."0";?>"/>
								<?php endif?>	
								<?php if($type_sortie=="text"):?>
									<default_value />
								<?php endif?>	
								<?php if($type_sortie=="boolean"):?>
									<default_value>false</default_value>
								<?php endif?>
								<?php $i++; ?>
							</field_<?php echo $type_sortie;?>>	
							<?php endif?>
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
		<?php if($find == -3):?>
			Vue de description inexistante dans la base.
			Crée la vue VIEW [dbo].[V_Qry_Column_Descr]
AS
SELECT     [table] as t, CONVERT(nchar(40),table_desc)as td, [column] as c, CONVERT(nchar(40),column_desc)as cd
FROM         (SELECT     u.name + '.' + t.name AS [table], td.value AS table_desc, c.name AS [column], cd.value AS column_desc
                       FROM          sys.sysobjects AS t INNER JOIN
                                              sys.sysusers AS u ON u.uid = t.uid LEFT OUTER JOIN
                                              sys.extended_properties AS td ON td.major_id = t.id AND td.minor_id = 0 AND td.name = 'MS_Description' INNER JOIN
                                              sys.syscolumns AS c ON c.id = t.id LEFT OUTER JOIN
                                              sys.extended_properties AS cd ON cd.major_id = c.id AND cd.minor_id = c.colid AND cd.name = 'MS_Description'
                       WHERE      (t.type = 'u'))
		<?php endif?>	
	</protocol>
</Protocol_Form>