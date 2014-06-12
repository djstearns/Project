<div class="ftypes form">
<?php echo $this->Form->create('Ftype');?>
	<fieldset>
		<legend><?php __('Add Ftype'); ?></legend>
	<?php
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Ftypes', true), array('action' => 'index'));?></li>
	</ul>
</div>