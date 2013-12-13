<div class="tUsers form">
<?php echo $this->Form->create('TUser'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('TUse_Login',array('label' => 'Login'));
		echo $this->Form->input('TUse_Password',array('type'=>'password','label' => 'Password'));
		echo $this->Form->input('Role', array(
		  'options' => $roles
		));
		echo "<div class='input test'>"; 
		echo $this->Form->label('Date de creation');
		echo "	".date('Y-m-d h:i:s a', time());
		echo "</div>";
		echo $this->Form->input('TUse_Actif',array('label' => 'Actif', 'checked'));
		echo $this->Form->input('TUse_Nom',array('label' => 'Nom'));
		echo $this->Form->input('TUse_Prenom',array('label' => 'Prenom'));		
		echo $this->Form->input('TUse_Departement',array('label' => 'Departement'));
		echo $this->Form->input('TUse_Fonction',array('label' => 'Fonction'));
		echo $this->Form->input('TUse_Language',array('label' => 'Language'));
		
		echo $this->Form->input('Application', array(
		  'options' => $apps
		));
		
		echo "<div class='blank'>";
		echo $this->Form->input('TUse_DateCreation',array('hidden','label' => ''));
		echo "</div>";
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
