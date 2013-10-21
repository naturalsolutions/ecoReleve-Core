<?php
	//echo print_r($taxons,true);
?>	
	<taxons nb="<?php echo $nb;?>">
		<?php foreach ($taxons as $taxon):?>
			<taxon id="<?php echo htmlspecialchars($taxon['AppModel']['ID_TAXON']);?>">
				<Higher_Taxon_ID><?php echo htmlspecialchars($taxon['AppModel']['ID_HIGHER_TAXON']);?></Higher_Taxon_ID>
				<Name_ID> <?php echo htmlspecialchars($taxon['AppModel']['ID_NAME']);?> </Name_ID>-->
				<Name_with_Authority> <?php echo htmlspecialchars($taxon['AppModel']['NAME_WITH_AUTHORITY']);?> </Name_with_Authority>
				<Authority> <?php echo htmlspecialchars($taxon['AppModel']['AUTHORITY']); ?></Authority>
				<Name_without_Authority> <?php echo htmlspecialchars($taxon['AppModel']['NAME_WITHOUT_AUTHORITY']);?> </Name_without_Authority>
				<Name_Valid> <?php echo htmlspecialchars($taxon['AppModel']['NAME_VALID']);?></Name_Valid>
				<Nom_Ver_Fr> <?php echo htmlspecialchars($taxon['AppModel']['NOM_VERN_FR']);?> </Nom_Ver_Fr>
				<Nom_Ver_Eng> <?php echo htmlspecialchars($taxon['AppModel']['NOM_VERN_ENG']);?> </Nom_Ver_Eng>
				<Kingdom> <?php echo htmlspecialchars($taxon['AppModel']['KINGDOM']);?> </Kingdom>
				<Phylum> <?php echo htmlspecialchars($taxon['AppModel']['PHYLUM']);?> </Phylum>
				<Class> <?php echo htmlspecialchars($taxon['AppModel']['CLASS']);?> </Class>
				<Order> <?php echo htmlspecialchars($taxon['AppModel']['ORDER']);?> </Order>
				<Family> <?php echo htmlspecialchars($taxon['AppModel']['FAMILY']);?> </Family>
				<Rank> <?php echo htmlspecialchars($taxon['AppModel']['RANK']);?></Rank>
				<Taxref_Cd_Nom> <?php echo htmlspecialchars($taxon['AppModel']['TAXREF_CD_NOM']);?></Taxref_Cd_Nom>
				<Taxref_Cd_Taxsup><?php echo htmlspecialchars($taxon['AppModel']['TAXREF_CD_TAXSUP']);?></Taxref_Cd_Taxsup>
				<Taxref_Cd_Ref><?php echo htmlspecialchars($taxon['AppModel']['TAXREF_CD_REF']);?></Taxref_Cd_Ref>
			</taxon>	
		
		<?php endforeach?>
	</taxons>

