<div class="fldbehaviors form">
<?php echo $this->Form->create('Fldbehavior');?>
	<fieldset>
		<legend><?php __('Edit Fldbehavior'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('Fld', array('data-placeholder'=>'Choose a Fld...','class'=>'chosen-select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Fldbehavior.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Fldbehavior.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Fldbehaviors', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Flds', true), array('controller' => 'flds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fld', true), array('controller' => 'flds', 'action' => 'add')); ?> </li>
	</ul>
</div>