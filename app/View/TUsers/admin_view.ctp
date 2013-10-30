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
	</ul>
</div>
