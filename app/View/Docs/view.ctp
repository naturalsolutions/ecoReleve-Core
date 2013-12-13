<div class="tUsers view">
<h2><?php echo __('Doc'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($Doc[0]['Doc']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('URL'); ?></dt>
		<dd>
			<?php echo h($Doc[0]['Doc']['URL']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LABEL'); ?></dt>
		<dd>
			<?php echo h($Doc[0]['Doc']['LABEL']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('COMMENT'); ?></dt>
		<dd>
			<?php echo h($Doc[0]['Doc']['COMMENT']); ?>
			&nbsp;
		</dd>		
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $Doc[0]['Doc']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $Doc[0]['Doc']['ID']), null, __('Are you sure you want to delete # %s?', $Doc[0]['Doc']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Doc'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New'), array('action' => 'add')); ?> </li>
	</ul>
</div>