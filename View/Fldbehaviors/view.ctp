<div class="fldbehaviors view">
<h2><?php  __('Fldbehavior');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fldbehavior['Fldbehavior']['id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Fldbehavior', true), array('action' => 'edit', $fldbehavior['Fldbehavior']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Fldbehavior', true), array('action' => 'delete', $fldbehavior['Fldbehavior']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fldbehavior['Fldbehavior']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Fldbehaviors', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fldbehavior', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Flds', true), array('controller' => 'flds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fld', true), array('controller' => 'flds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Flds');?></h3>
	<?php if (!empty($fldbehavior['Fld'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Pobject Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Ftype Id'); ?></th>
		<th><?php __('Length'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($fldbehavior['Fld'] as $fld):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $fld['id'];?></td>
			<td><?php echo $fld['pobject_id'];?></td>
			<td><?php echo $fld['name'];?></td>
			<td><?php echo $fld['ftype_id'];?></td>
			<td><?php echo $fld['length'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'flds', 'action' => 'view', $fld['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'flds', 'action' => 'edit', $fld['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'flds', 'action' => 'delete', $fld['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fld['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fld', true), array('controller' => 'flds', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
