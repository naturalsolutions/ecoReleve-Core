<div class="tUsers form">
<?php echo $this->Form->create('TUser'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add T User'); ?></legend>
	<?php
		echo $this->Form->input('TUse_Nom');
		echo $this->Form->input('TUse_Prenom');
		echo $this->Form->input('TUse_Actif');
		echo $this->Form->input('TUse_DateCreation');
		echo $this->Form->input('TUse_Login');
		echo $this->Form->input('TUse_Password');
		echo $this->Form->input('TUse_Departement');
		echo $this->Form->input('TUse_Language');
		echo $this->Form->input('TUse_DateModif');
		echo $this->Form->input('TUse_Observateur');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List T Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
