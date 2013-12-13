<div class="tUsers form">
<?php echo $this->Form->create('TUser'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('TUse_Login',array('label' => 'Login'));
		echo $this->Form->input('TUse_Password',array('label' => 'Password'));
		echo $this->Form->input('Role', array(
		  'selected' => $role,	
		  'options' => $roles
		));
		
		echo "<div class='input test'>"; 
		echo $this->Form->label('Date de creation');
		echo "	".$date;
		echo "</div>";
		
		echo $this->Form->input('TUse_Actif',array('label' => 'Actif'));
		echo $this->Form->input('TUse_Pk_ID');
		echo $this->Form->input('TUse_Nom',array('label' => 'Nom'));
		echo $this->Form->input('TUse_Prenom',array('label' => 'Prenom'));
		
		
		echo $this->Form->input('TUse_Departement',array('label' => 'Departement'));
		echo $this->Form->input('TUse_Fonction',array('label' => 'Fonction'));
		echo $this->Form->input('TUse_Language',array('label' => 'Language'));
		
		echo $this->Form->input('Application', array(
		  'selected' => $app,	
		  'options' => $apps
		));
		
		echo "<input name='data[TUser][id_auth]' hidden 6' value='$id_auth' type='text' id='TUserIdAuth'>";
		
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TUser.TUse_Pk_ID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TUser.TUse_Pk_ID'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
