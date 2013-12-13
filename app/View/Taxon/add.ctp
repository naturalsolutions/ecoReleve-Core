<div class="tUsers form">
<?php echo $this->Form->create('Taxon'); ?>
	<fieldset>
		<legend><?php echo __('Add Taxon'); ?></legend>
	<?php
		echo $this->Form->input('FK_PREFERED_NAME',array('label' => 'FK PREFERED NAME'));
		echo $this->Form->input('ID_HIGHER_TAXON',array('label' => 'ID HIGHER TAXON'));				
		echo $this->Form->input('KINGDOM',array('label' => 'KINGDOM'));	
		echo $this->Form->input('PHYLUM',array('label' => 'PHYLUM'));	
		echo $this->Form->input('CLASS',array('label' => 'CLASS'));	
		echo $this->Form->input('ORDER',array('label' => 'ORDER'));	
		echo $this->Form->input('FAMILY',array('label' => 'FAMILY'));	
		echo $this->Form->input('RANK',array('label' => 'RANK'));	
		echo $this->Form->input('NAME_VALID_AUTHORITY',array('label' => 'AUTHORITY'));	
		echo $this->Form->input('NAME_VALID_WITH_AUTHORITY',array('label' => 'NAME VALID WITH AUTHORITY'));	
		echo $this->Form->input('NAME_VALID_WITHOUT_AUTHORITY',array('label' => 'NAME VALID WITHOUT AUTHORITY'));	
		echo $this->Form->input('NAME_VERN_FR',array('label' => 'NAME VERN FR'));	
		echo $this->Form->input('NAME_VERN_ENG',array('label' => 'NAME VERN ENG'));	
		echo $this->Form->input('TAXREF_CD_TAXSUP',array('label' => 'TAXREF CD TAXSUP'));	
		echo $this->Form->input('TAXREF_CD_REF',array('label' => 'TAXREF CD REF'));	
		$i=0;
		for($i;$i<3;$i++){
			echo "<h3>Image ".($i+1)."</h3>";
			echo $this->Form->input("Additional.$i.value",array('label' => 'Image url'));
			echo $this->Form->input("Additional.$i.value_precision",array('label' => 'author'));
			echo "<div class='blank'>";
			echo $this->Form->input("Additional.$i.aditional_value_Pk",array('label' => 'aditional_value_Pk'));
			echo '<div class="input text"><label for="Additional2FKValueType">FK_value_type</label><input value="image" name="data[Additional]['.$i.'][FK_value_type]" maxlength="250" type="text" id="Additional2FKValueType"/></div>';
			echo "</div>";
			
		}	
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Taxon'), array('action' => 'index')); ?></li>
	</ul>
</div>
