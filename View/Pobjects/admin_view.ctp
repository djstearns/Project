<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Pobjects'), h($pobject['Pobject']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Pobjects'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Pobject'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Pobject'), array('action' => 'edit', $pobject['Pobject']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Pobject'), array('action' => 'delete', $pobject['Pobject']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $pobject['Pobject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Pobjects'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Pobject'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Flds'), array('controller' => 'flds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Fld'), array('controller' => 'flds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Pobjectbehaviors'), array('controller' => 'pobjectbehaviors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Pobjectbehavior'), array('controller' => 'pobjectbehaviors', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="pobjects view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($pobject['Pobject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pobject['Project']['name'], array('controller' => 'projects', 'action' => 'view', $pobject['Project']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($pobject['Pobject']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Description'); ?></dt>
		<dd>
			<?php echo h($pobject['Pobject']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
