<div class="tUsers view">
<h2><?php  echo __('T User'); ?></h2>
	<dl>
		<dt><?php echo __('TUse Pk ID'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Pk_ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Nom'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Nom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Prenom'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Prenom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Actif'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Actif']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse DateCreation'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_DateCreation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Login'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Login']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Password'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Departement'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Departement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Language'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Language']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse DateModif'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_DateModif']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TUse Observateur'); ?></dt>
		<dd>
			<?php echo h($tUser['TUser']['TUse_Observateur']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit T User'), array('action' => 'edit', $tUser['TUser']['TUse_Pk_ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete T User'), array('action' => 'delete', $tUser['TUser']['TUse_Pk_ID']), null, __('Are you sure you want to delete # %s?', $tUser['TUser']['TUse_Pk_ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List T Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New T User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List T Applications'), array('controller' => 't_applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 't_applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related T Applications'); ?></h3>
	<?php if (!empty($tUser['Application'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('TApp PK ID'); ?></th>
		<th><?php echo __('TApp Nom'); ?></th>
		<th><?php echo __('TApp ApplicationPath'); ?></th>
		<th><?php echo __('TApp Description'); ?></th>
		<th><?php echo __('TApp ImagePath'); ?></th>
		<th><?php echo __('TApp Couleur'); ?></th>
		<th><?php echo __('TApp IconePath'); ?></th>
		<th><?php echo __('TApp Ordre'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tUser['Application'] as $application): ?>
		<tr>
			<td><?php echo $application['TApp_PK_ID']; ?></td>
			<td><?php echo $application['TApp_Nom']; ?></td>
			<td><?php echo $application['TApp_ApplicationPath']; ?></td>
			<td><?php echo $application['TApp_Description']; ?></td>
			<td><?php echo $application['TApp_ImagePath']; ?></td>
			<td><?php echo $application['TApp_Couleur']; ?></td>
			<td><?php echo $application['TApp_IconePath']; ?></td>
			<td><?php echo $application['TApp_Ordre']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 't_applications', 'action' => 'view', $application['TApp_PK_ID'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 't_applications', 'action' => 'edit', $application['TApp_PK_ID'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 't_applications', 'action' => 'delete', $application['TApp_PK_ID']), null, __('Are you sure you want to delete # %s?', $application['TApp_PK_ID'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Application'), array('controller' => 't_applications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
