<div class="flds index">test
	<h2><?php echo __('Flds'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('pobject_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('ftype_id'); ?></th>
			<th><?php echo $this->Paginator->sort('length'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($flds as $fld): ?>
	<tr>
		<td><?php echo h($fld['Fld']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($fld['Pobject']['name'], array('controller' => 'pobjects', 'action' => 'view', $fld['Pobject']['id'])); ?>
		</td>
		<td><?php echo h($fld['Fld']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($fld['Ftype']['name'], array('controller' => 'ftypes', 'action' => 'view', $fld['Ftype']['id'])); ?>
		</td>
		<td><?php echo h($fld['Fld']['length']); ?>&nbsp;</td>
		<td><?php echo h($fld['Fld']['created']); ?>&nbsp;</td>
		<td><?php echo h($fld['Fld']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $fld['Fld']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $fld['Fld']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $fld['Fld']['id']), null, __('Are you sure you want to delete # %s?', $fld['Fld']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Fld'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Pobjects'), array('controller' => 'pobjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pobject'), array('controller' => 'pobjects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ftypes'), array('controller' => 'ftypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ftype'), array('controller' => 'ftypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fldbehaviors'), array('controller' => 'fldbehaviors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fldbehavior'), array('controller' => 'fldbehaviors', 'action' => 'add')); ?> </li>
	</ul>
</div>
