<div class="Taxon view">
<h2><?php echo __('Taxon'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['ID_TAXON']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FK PREFERED NAME'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['FK_PREFERED_NAME']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ID HIGHER TAXON'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['ID_HIGHER_TAXON']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('KINGDOM'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['KINGDOM']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PHYLUM'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['PHYLUM']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CLASS'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['CLASS']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ORDER'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['ORDER']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FAMILY'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['FAMILY']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('RANK'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['RANK']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('AUTHORITY'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['NAME_VALID_AUTHORITY']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('NAME VALID WITH AUTHORITY'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['NAME_VALID_WITH_AUTHORITY']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('NAME VALID WITHOUT AUTHORITY'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['NAME_VALID_WITHOUT_AUTHORITY']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('NAME VERN FR'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['NAME_VERN_FR']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('NAME VERN ENG'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['NAME_VERN_ENG']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TAXREF CD TAXSUP'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['TAXREF_CD_TAXSUP']); ?>
			&nbsp;
		</dd>	
		<dt><?php echo __('TAXREF CD REF'); ?></dt>
		<dd>
			<?php echo h($Taxon[0]['Taxon']['TAXREF_CD_REF']); ?>
			&nbsp;
		</dd>		
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $Taxon[0]['Taxon']['ID_TAXON'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $Taxon[0]['Taxon']['ID_TAXON']), null, __('Are you sure you want to delete # %s?', $Taxon[0]['Taxon']['ID_TAXON'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Taxon'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New'), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Image'); ?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Image url'); ?></th>
		<th><?php echo __('Author'); ?></th>
		<th><?php echo __('Action'); ?></th>
	</tr>
	<?php
		foreach ($Taxon[0]['Additional'] as $add): ?>
			<?php if($add['FK_value_type']=='image'):?>
				<tr>
					<td><?php echo $add['value']; ?></td>
					<td><?php $aut=json_decode($add['value_precision'],true);print_r($add['value_precision']); ?></td>
					<td><?php echo $this->Form->postLink(__('Delete'), array('controller'=>'TaxonAddi','action' => 'delete', $add['aditional_value_Pk']), null, __('Are you sure you want to delete # %s?', $add['aditional_value_Pk'])); ?></td>	
				</tr>
			<?php endif?>
		<?php endforeach; ?>
	</table>
</div