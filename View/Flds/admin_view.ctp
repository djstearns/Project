<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Flds'), h($fld['Fld']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Flds'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Fld'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Fld'), array('action' => 'edit', $fld['Fld']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Fld'), array('action' => 'delete', $fld['Fld']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $fld['Fld']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Flds'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Fld'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Pobjects'), array('controller' => 'pobjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Pobject'), array('controller' => 'pobjects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Ftypes'), array('controller' => 'ftypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Ftype'), array('controller' => 'ftypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Fldbehaviors'), array('controller' => 'fldbehaviors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Fldbehavior'), array('controller' => 'fldbehaviors', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="flds view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Pobject'); ?></dt>
		<dd>
			<?php echo $this->Html->link($fld['Pobject']['name'], array('controller' => 'pobjects', 'action' => 'view', $fld['Pobject']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Ftype'); ?></dt>
		<dd>
			<?php echo $this->Html->link($fld['Ftype']['name'], array('controller' => 'ftypes', 'action' => 'view', $fld['Ftype']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Length'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['length']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Modified'); ?></dt>
		<dd>
			<?php echo h($fld['Fld']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
