<?xml version="1.0" encoding="utf-8"?>
<Protocol_Form xsi:noNamespaceSchemaLocation="Pocket_XSD_V3-1.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<protocol>
		<?php if($find == 1):?>
			<name>
				<display_label><?php print_r( $model)?></display_label>
				<label lang="fr"><?php echo $nom?></label>
			</name>
			<description>
				<label lang="fr"><?php echo $nom?></label>
			</description>
			<multispecies>false</multispecies>
			<monitoring>false</monitoring>
			<fields>
				<fieldset name="all">
					<?php $i=1; foreach ($model->schema() as $key=>$val): //$key:name of column $val:array f column info?>  
						<?php //Field creation
							$type = $model->getColumnType($key);$type_sortie=$type; //default field output column type
							//not display if its an id or pk or fk							
							$colonne_decoupe=split("_",$key,2); if(strcasecmp($colonne_decoupe[0], "id")!=0 && strcasecmp($colonne_decoupe[0], "fk")!=0 &&strcasecmp($colonne_decoupe[0], "pk")!=0):?>
							<?php //verify if the colunm is link with an id column for see if it's field list
								$list=false;
														
								if(sizeof($colonne_decoupe)>1 && (isset($model->schema()["Id_".$colonne_decoupe[1]]) || isset($model->schema()["ID_".$colonne_decoupe[1]]) || isset($model->schema()["id_".$colonne_decoupe[1]]))){
									if(isset($model->schema()["Id_".$colonne_decoupe[1]]))$id_type="Id";
									if(isset($model->schema()["ID_".$colonne_decoupe[1]]))$id_type="ID";
									if(isset($model->schema()["id_".$colonne_decoupe[1]]))$id_type="id";
									$list=true;
								}
							?>
							<?php 	if($list){
										$type_sortie="list";}
									else if($type=="integer" || $type=="float"){
										$type_sortie="numeric";
									}	
									else if($type=="string"){
										$type_sortie="text";}
										
							?> 
							<field_<?php echo $type_sortie?> id="<?php echo $i;?>">
								<name>
									<label lang="fr"><?php echo $key;?></label>
									<display_label lang="fr"><?php echo $key;?></display_label>
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
											<?php $first_notnull=$model->find('first',array('conditions' => array("not" => array($id_type."_".$colonne_decoupe[1] => null))));
												$id_list=0;
												if(isset($first_notnull['Model']))$id_list=$first_notnull['Model'][$id_type."_".$colonne_decoupe[1]];
												
											?>
											<?php if($id_list==0):?>
												<itemlist lg="en"/>
											<?php endif?>
											<?php if(!$id_list==0):?>
												<?php //Creation of item value
													$item_list="";
													$id_t = intval($model_T->find('first', array('conditions' => array('ID' => $id_list)))['Model']['Id_Type']);													
													$list=$model_T->find('all', array('conditions' => array('Id_Type' => $id_t),'limit' => 200));
													$j=0;
													foreach($list as $key=>$val){														
														foreach($val['Model'] as $key2=>$val2){
															if($key2=="topic_en"){
																$item_list.=htmlspecialchars("".$i.$j.";".$j.";".$val2."|");
																
															}																
														}	
														$j++;
													}
												?>
												<itemlist lg="en"><?php echo substr($item_list, 0, -1) ?> </itemlist>
											<?php endif?>
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
	</protocol>
</Protocol_Form>