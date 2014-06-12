<div class="ftypes view">
<h2><?php  __('Ftype');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ftype['Ftype']['id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ftype', true), array('action' => 'edit', $ftype['Ftype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Ftype', true), array('action' => 'delete', $ftype['Ftype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ftype['Ftype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ftypes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ftype', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
