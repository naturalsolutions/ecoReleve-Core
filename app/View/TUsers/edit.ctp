<div class="tUsers form">
<?php echo $this->Form->create('TUser'); ?>
	<fieldset>
		<legend><?php echo __('Edit T User'); ?></legend>
	<?php
		echo $this->Form->input('TUse_Pk_ID');
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
		echo $this->Form->input('Application');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TUser.TUse_Pk_ID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TUser.TUse_Pk_ID'))); ?></li>
		<li><?php echo $this->Html->link(__('List T Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List T Applications'), array('controller' => 't_applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 't_applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
