<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Pobjectbehaviors'), h($pobjectbehavior['Pobjectbehavior']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Pobjectbehaviors'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Pobjectbehavior'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Pobjectbehavior'), array('action' => 'edit', $pobjectbehavior['Pobjectbehavior']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Pobjectbehavior'), array('action' => 'delete', $pobjectbehavior['Pobjectbehavior']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $pobjectbehavior['Pobjectbehavior']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Pobjectbehaviors'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Pobjectbehavior'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Pobjects'), array('controller' => 'pobjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Pobject'), array('controller' => 'pobjects', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="pobjectbehaviors view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($pobjectbehavior['Pobjectbehavior']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($pobjectbehavior['Pobjectbehavior']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
