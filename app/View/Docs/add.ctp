<div class="tUsers form">
<?php echo $this->Form->create('Doc'); ?>
	<fieldset>
		<legend><?php echo __('Add Doc'); ?></legend>
	<?php
		echo $this->Form->input('URL',array('label' => 'URL'));
		echo $this->Form->input('LABEL',array('label' => 'LABEL'));		
		echo $this->Form->input('COMMENT',array('label' => 'COMMENT'));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('action' => 'index')); ?></li>
	</ul>
</div>
