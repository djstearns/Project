<div class="pobjects view">
<h2><?php echo __('Pobject'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pobject['Pobject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pobject['Project']['name'], array('controller' => 'projects', 'action' => 'view', $pobject['Project']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($pobject['Pobject']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($pobject['Pobject']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pobject'), array('action' => 'edit', $pobject['Pobject']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pobject'), array('action' => 'delete', $pobject['Pobject']['id']), null, __('Are you sure you want to delete # %s?', $pobject['Pobject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pobjects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pobject'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Flds'), array('controller' => 'flds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fld'), array('controller' => 'flds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pobjectbehaviors'), array('controller' => 'pobjectbehaviors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pobjectbehavior'), array('controller' => 'pobjectbehaviors', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Flds'); ?></h3>
	<?php if (!empty($pobject['Fld'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Pobject Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Ftype Id'); ?></th>
		<th><?php echo __('Length'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pobject['Fld'] as $fld): ?>
		<tr>
			<td><?php echo $fld['id']; ?></td>
			<td><?php echo $fld['pobject_id']; ?></td>
			<td><?php echo $fld['name']; ?></td>
			<td><?php echo $fld['ftype_id']; ?></td>
			<td><?php echo $fld['length']; ?></td>
			<td><?php echo $fld['created']; ?></td>
			<td><?php echo $fld['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'flds', 'action' => 'view', $fld['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'flds', 'action' => 'edit', $fld['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'flds', 'action' => 'delete', $fld['id']), null, __('Are you sure you want to delete # %s?', $fld['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fld'), array('controller' => 'flds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Pobjectbehaviors'); ?></h3>
	<?php if (!empty($pobject['Pobjectbehavior'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pobject['Pobjectbehavior'] as $pobjectbehavior): ?>
		<tr>
			<td><?php echo $pobjectbehavior['id']; ?></td>
			<td><?php echo $pobjectbehavior['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'pobjectbehaviors', 'action' => 'view', $pobjectbehavior['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'pobjectbehaviors', 'action' => 'edit', $pobjectbehavior['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'pobjectbehaviors', 'action' => 'delete', $pobjectbehavior['id']), null, __('Are you sure you want to delete # %s?', $pobjectbehavior['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pobjectbehavior'), array('controller' => 'pobjectbehaviors', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
