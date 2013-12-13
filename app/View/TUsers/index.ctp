<div class="tUsers index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('TUse_Pk_ID','ID'); ?></th>
			<th><?php echo $this->Paginator->sort('TUse_Nom','Nom'); ?></th>
			<th><?php echo $this->Paginator->sort('TUse_Prenom','Prenom'); ?></th>
			<th><?php echo $this->Paginator->sort('TUse_DateCreation','Date de Creation'); ?></th>
			<th><?php echo $this->Paginator->sort('TUse_Login','Login'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tUsers as $tUser): ?>
	<tr>
		<td><?php echo h($tUser['TUser']['TUse_Pk_ID']); ?>&nbsp;</td>
		<td><?php echo h($tUser['TUser']['TUse_Nom']); ?>&nbsp;</td>
		<td><?php echo h($tUser['TUser']['TUse_Prenom']); ?>&nbsp;</td>
		<td><?php echo h($tUser['TUser']['TUse_DateCreation']); ?>&nbsp;</td>
		<td><?php echo h($tUser['TUser']['TUse_Login']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tUser['TUser']['TUse_Pk_ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tUser['TUser']['TUse_Pk_ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tUser['TUser']['TUse_Pk_ID']), null, __('Are you sure you want to delete # %s?', $tUser['TUser']['TUse_Pk_ID'])); ?>
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
		<li><?php echo $this->Html->link(__('New'), array('action' => 'add')); ?></li>
	</ul>
</div>
