<?php
	//echo print_r($taxons,true);
?>	
	<taxons nb="<?php echo $nb;?>">
		<?php $i=-1;foreach ($taxons as $taxon):?>
			<?php if($i!=$taxon['AppModel']['ID_TAXON']):?>
				<?php if($i!=-1) echo "</taxon>"?>
				<taxon id="<?php echo htmlspecialchars($taxon['AppModel']['ID_TAXON']);?>">
					<Higher_Taxon_ID><?php echo htmlspecialchars($taxon['AppModel']['ID_HIGHER_TAXON']);?></Higher_Taxon_ID>				
					<Name_Valid> <?php echo htmlspecialchars($taxon['AppModel']['NAME_VALID']);?></Name_Valid>
					<Nom_Ver_Fr> <?php echo htmlspecialchars($taxon['AppModel']['NOM_VERN_FR']);?> </Nom_Ver_Fr>
					<Nom_Ver_Eng> <?php echo htmlspecialchars($taxon['AppModel']['NOM_VERN_ENG']);?> </Nom_Ver_Eng>
					<Kingdom> <?php echo htmlspecialchars($taxon['AppModel']['KINGDOM']);?> </Kingdom>
					<Phylum> <?php echo htmlspecialchars($taxon['AppModel']['PHYLUM']);?> </Phylum>
					<Class> <?php echo htmlspecialchars($taxon['AppModel']['CLASS']);?> </Class>
					<Order> <?php echo htmlspecialchars($taxon['AppModel']['ORDER']);?> </Order>
					<Family> <?php echo htmlspecialchars($taxon['AppModel']['FAMILY']);?> </Family>
					<Rank> <?php echo htmlspecialchars($taxon['AppModel']['RANK']);?></Rank>
					<Taxref_Cd_Taxsup><?php echo htmlspecialchars($taxon['AppModel']['TAXREF_CD_TAXSUP']);?></Taxref_Cd_Taxsup>
					<Taxref_Cd_Ref><?php echo htmlspecialchars($taxon['AppModel']['TAXREF_CD_REF']);?></Taxref_Cd_Ref>
					<ID_Name> <?php echo htmlspecialchars($taxon['TTaxa_name_join']['ID_NAME']);?> </ID_Name>
					<Taxref_Cd_Nom><?php echo htmlspecialchars($taxon['TTaxa_name_join']['TAXREF_CD_NOM']);?></Taxref_Cd_Nom>
					<Name_With_Authority> <?php echo htmlspecialchars($taxon['TTaxa_name_join']['NAME_WITH_AUTHORITY']);?> </Name_With_Authority>
					<Authority> <?php echo htmlspecialchars($taxon['TTaxa_name_join']['AUTHORITY']);?> </Authority>
					<Name_Without_Authority> <?php echo htmlspecialchars($taxon['TTaxa_name_join']['NAME_WITHOUT_AUTHORITY']);?> </Name_Without_Authority>
					<?php
						if(isset($taxon['TTaxa_additonal_values_join']['value'])){
							$tag=$taxon['TTaxa_additonal_values_join']['FK_value_type'];
							$value=$taxon['TTaxa_additonal_values_join']['value'];
							echo "<$tag>$value</$tag>";
							
						}	
					?>					
			<?php endif?>
			<?php if($i==$taxon['AppModel']['ID_TAXON']):?>	
				<?php
						if(isset($taxon['TTaxa_additonal_values_join']['value'])){
							$tag=$taxon['TTaxa_additonal_values_join']['FK_value_type'];
							$value=$taxon['TTaxa_additonal_values_join']['value'];
							echo "<$tag>$value</$tag>";
							
						}	
					?>
			<?php endif?>
			<?php $i=$taxon['AppModel']['ID_TAXON']?>
		<?php endforeach?>
		</taxon>
	</taxons>

