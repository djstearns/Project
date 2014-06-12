<div class="fldbehaviors form">
<?php echo $this->Form->create('Fldbehavior');?>
	<fieldset>
		<legend><?php __('Add Fldbehavior'); ?></legend>
	<?php
		echo $this->Form->input('Fldbehabor.name');
		//echo $this->Form->input('Fld', array('data-placeholder'=>'Choose a Fld...','class'=>'chosen-select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Fldbehaviors', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Flds', true), array('controller' => 'flds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fld', true), array('controller' => 'flds', 'action' => 'add')); ?> </li>
	</ul>
</div>