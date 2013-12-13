<div class="tUsers view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Pk_ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nom'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Nom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prenom'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Prenom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Actif'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Actif']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('DateCreation'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_DateCreation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Login'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Login']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Departement'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Departement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fonction'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Fonction']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language'); ?></dt>
		<dd>
			<?php echo h($tUser[0]['TUser']['TUse_Language']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tUser[0]['TUser']['TUse_Pk_ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tUser[0]['TUser']['TUse_Pk_ID']), null, __('Are you sure you want to delete # %s?', $tUser[0]['TUser']['TUse_Pk_ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New'), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Application'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Application'); ?></th>
		<th><?php echo __('Role'); ?></th>		
	</tr>
	<?php
		$i = 0;
		foreach ($tUser as $app): ?>
		<tr>
			<td><?php echo $app['Applications']['TApp_Nom']; ?></td>
			<td><?php echo $app['Roles']['TRol_Type']; ?></td>			
		</tr>
	<?php endforeach; ?>
	</table>
</div>
