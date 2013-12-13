<div class="Taxon index">
	<h2><?php echo __('Taxon'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID_TAXON','ID TAXON'); ?></th>
			<th><?php echo $this->Paginator->sort('TAXREF_CD_REF','TAXREF CD REF'); ?></th>
			<th><?php echo $this->Paginator->sort('NAME_VALID_WITHOUT_AUTHORITY','NAME (WITHOUT AUTHORITY)'); ?></th>
			<th><?php echo $this->Paginator->sort('NAME_VALID_AUTHORITY','AUTHORITY'); ?></th>
			<th><?php echo $this->Paginator->sort('RANK','RANK'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($Taxon as $taxon): ?>
	<tr>
		<td><?php echo h($taxon['Taxon']['ID_TAXON']); ?>&nbsp;</td>
		<td><?php echo h($taxon['Taxon']['TAXREF_CD_REF']); ?>&nbsp;</td>
		<td><?php echo h($taxon['Taxon']['NAME_VALID_WITHOUT_AUTHORITY']); ?>&nbsp;</td>
		<td><?php echo h($taxon['Taxon']['NAME_VALID_AUTHORITY']); ?>&nbsp;</td>
		<td><?php echo h($taxon['Taxon']['RANK']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $taxon['Taxon']['ID_TAXON'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $taxon['Taxon']['ID_TAXON'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $taxon['Taxon']['ID_TAXON']), null, __('Are you sure you want to delete # %s?', $taxon['Taxon']['ID_TAXON'])); ?>
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
	<?php echo $this->Form->create(null, array('url'=>array('action' => 'search', 'controller' => 'taxon')));?>
	<?php echo "<h4>".$this->Form->input('search',array('label' => 'Name Without Auth. :'))."</h4>";?>		
	<?php echo $this->Form->end(__('Search')); ?>
</div>
