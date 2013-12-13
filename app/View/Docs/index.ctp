<div class="Docs index">
	<h2><?php echo __('Doc'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID','ID'); ?></th>
			<th><?php echo $this->Paginator->sort('URL','URL'); ?></th>
			<th><?php echo $this->Paginator->sort('LABEL','LABEL'); ?></th>
			<th><?php echo $this->Paginator->sort('COMMENT','COMMENT'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($Docs as $docs): ?>
	<tr>
		<td><?php echo h($docs['Doc']['ID']); ?>&nbsp;</td>
		<td><?php echo h($docs['Doc']['URL']); ?>&nbsp;</td>
		<td><?php echo h($docs['Doc']['LABEL']); ?>&nbsp;</td>
		<td><?php echo h($docs['Doc']['COMMENT']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $docs['Doc']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $docs['Doc']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $docs['Doc']['ID']), null, __('Are you sure you want to delete # %s?', $docs['Doc']['ID'])); ?>
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
