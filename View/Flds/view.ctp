<div class="flds view">
<h2><?php echo __('Fld'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pobject'); ?></dt>
		<dd>
			<?php echo $this->Html->link($fld['Pobject']['name'], array('controller' => 'pobjects', 'action' => 'view', $fld['Pobject']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ftype'); ?></dt>
		<dd>
			<?php echo $this->Html->link($fld['Ftype']['name'], array('controller' => 'ftypes', 'action' => 'view', $fld['Ftype']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Length'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['length']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Fld'), array('action' => 'edit', $fld['Fld']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Fld'), array('action' => 'delete', $fld['Fld']['id']), null, __('Are you sure you want to delete # %s?', $fld['Fld']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Flds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fld'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pobjects'), array('controller' => 'pobjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pobject'), array('controller' => 'pobjects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ftypes'), array('controller' => 'ftypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ftype'), array('controller' => 'ftypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fldbehaviors'), array('controller' => 'fldbehaviors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fldbehavior'), array('controller' => 'fldbehaviors', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Fldbehaviors'); ?></h3>
	<?php if (!empty($fld['Fldbehavior'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($fld['Fldbehavior'] as $fldbehavior): ?>
		<tr>
			<td><?php echo $fldbehavior['id']; ?></td>
			<td><?php echo $fldbehavior['name']; ?></td>
			<td><?php echo $fldbehavior['created']; ?></td>
			<td><?php echo $fldbehavior['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fldbehaviors', 'action' => 'view', $fldbehavior['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fldbehaviors', 'action' => 'edit', $fldbehavior['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fldbehaviors', 'action' => 'delete', $fldbehavior['id']), null, __('Are you sure you want to delete # %s?', $fldbehavior['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fldbehavior'), array('controller' => 'fldbehaviors', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
