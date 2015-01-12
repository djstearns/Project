<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Fldbehaviors'), h($fldbehavior['Fldbehavior']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Fldbehaviors'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Fldbehavior'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Fldbehavior'), array('action' => 'edit', $fldbehavior['Fldbehavior']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Fldbehavior'), array('action' => 'delete', $fldbehavior['Fldbehavior']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $fldbehavior['Fldbehavior']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Fldbehaviors'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Fldbehavior'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Flds'), array('controller' => 'flds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Fld'), array('controller' => 'flds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="fldbehaviors view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($fldbehavior['Fldbehavior']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($fldbehavior['Fldbehavior']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($fldbehavior['Fldbehavior']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Modified'); ?></dt>
		<dd>
			<?php echo h($fldbehavior['Fldbehavior']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
