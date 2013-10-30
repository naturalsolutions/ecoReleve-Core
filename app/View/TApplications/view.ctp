<div class="tApplications view">
<h2><?php  echo __('T Application'); ?></h2>
	<dl>
		<dt><?php echo __('TApp PK ID'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_PK_ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp Nom'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_Nom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp ApplicationPath'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_ApplicationPath']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp Description'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_Description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp ImagePath'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_ImagePath']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp Couleur'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_Couleur']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp IconePath'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_IconePath']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TApp Ordre'); ?></dt>
		<dd>
			<?php echo h($tApplication['TApplication']['TApp_Ordre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit T Application'), array('action' => 'edit', $tApplication['TApplication']['TApp_PK_ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete T Application'), array('action' => 'delete', $tApplication['TApplication']['TApp_PK_ID']), null, __('Are you sure you want to delete # %s?', $tApplication['TApplication']['TApp_PK_ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List T Applications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New T Application'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List T Users'), array('controller' => 't_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 't_users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related T Users'); ?></h3>
	<?php if (!empty($tApplication['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('TUse Pk ID'); ?></th>
		<th><?php echo __('TUse Nom'); ?></th>
		<th><?php echo __('TUse Prenom'); ?></th>
		<th><?php echo __('TUse Actif'); ?></th>
		<th><?php echo __('TUse DateCreation'); ?></th>
		<th><?php echo __('TUse Login'); ?></th>
		<th><?php echo __('TUse Password'); ?></th>
		<th><?php echo __('TUse Departement'); ?></th>
		<th><?php echo __('TUse Language'); ?></th>
		<th><?php echo __('TUse DateModif'); ?></th>
		<th><?php echo __('TUse Observateur'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tApplication['User'] as $user): ?>
		<tr>
			<td><?php echo $user['TUse_Pk_ID']; ?></td>
			<td><?php echo $user['TUse_Nom']; ?></td>
			<td><?php echo $user['TUse_Prenom']; ?></td>
			<td><?php echo $user['TUse_Actif']; ?></td>
			<td><?php echo $user['TUse_DateCreation']; ?></td>
			<td><?php echo $user['TUse_Login']; ?></td>
			<td><?php echo $user['TUse_Password']; ?></td>
			<td><?php echo $user['TUse_Departement']; ?></td>
			<td><?php echo $user['TUse_Language']; ?></td>
			<td><?php echo $user['TUse_DateModif']; ?></td>
			<td><?php echo $user['TUse_Observateur']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 't_users', 'action' => 'view', $user['TUse_Pk_ID'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 't_users', 'action' => 'edit', $user['TUse_Pk_ID'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 't_users', 'action' => 'delete', $user['TUse_Pk_ID']), null, __('Are you sure you want to delete # %s?', $user['TUse_Pk_ID'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 't_users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
