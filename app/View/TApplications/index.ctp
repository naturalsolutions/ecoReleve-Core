<div class="tApplications index">
	<h2><?php echo __('T Applications'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('TApp_PK_ID'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_Nom'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_ApplicationPath'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_Description'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_ImagePath'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_Couleur'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_IconePath'); ?></th>
			<th><?php echo $this->Paginator->sort('TApp_Ordre'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tApplications as $tApplication): ?>
	<tr>
		<td><?php echo h($tApplication['TApplication']['TApp_PK_ID']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_Nom']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_ApplicationPath']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_Description']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_ImagePath']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_Couleur']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_IconePath']); ?>&nbsp;</td>
		<td><?php echo h($tApplication['TApplication']['TApp_Ordre']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tApplication['TApplication']['TApp_PK_ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tApplication['TApplication']['TApp_PK_ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tApplication['TApplication']['TApp_PK_ID']), null, __('Are you sure you want to delete # %s?', $tApplication['TApplication']['TApp_PK_ID'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New T Application'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List T Users'), array('controller' => 't_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 't_users', 'action' => 'add')); ?> </li>
	</ul>
</div>
