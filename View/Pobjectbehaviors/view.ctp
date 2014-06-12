<div class="pobjectbehaviors view">
<h2><?php echo __('Pobjectbehavior'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pobjectbehavior['Pobjectbehavior']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($pobjectbehavior['Pobjectbehavior']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pobjectbehavior'), array('action' => 'edit', $pobjectbehavior['Pobjectbehavior']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pobjectbehavior'), array('action' => 'delete', $pobjectbehavior['Pobjectbehavior']['id']), null, __('Are you sure you want to delete # %s?', $pobjectbehavior['Pobjectbehavior']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pobjectbehaviors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pobjectbehavior'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pobjects'), array('controller' => 'pobjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pobject'), array('controller' => 'pobjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Pobjects'); ?></h3>
	<?php if (!empty($pobjectbehavior['Pobject'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Project Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pobjectbehavior['Pobject'] as $pobject): ?>
		<tr>
			<td><?php echo $pobject['id']; ?></td>
			<td><?php echo $pobject['project_id']; ?></td>
			<td><?php echo $pobject['name']; ?></td>
			<td><?php echo $pobject['description']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'pobjects', 'action' => 'view', $pobject['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'pobjects', 'action' => 'edit', $pobject['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'pobjects', 'action' => 'delete', $pobject['id']), null, __('Are you sure you want to delete # %s?', $pobject['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pobject'), array('controller' => 'pobjects', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
