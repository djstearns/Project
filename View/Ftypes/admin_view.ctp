<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Ftypes'), h($ftype['Ftype']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Ftypes'), array('action' => 'index'));

?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Ftype'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Ftype'), array('action' => 'edit', $ftype['Ftype']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Ftype'), array('action' => 'delete', $ftype['Ftype']['id']), array('button' => 'danger', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $ftype['Ftype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Ftypes'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Ftype'), array('action' => 'add'), array('button' => 'success')); ?> </li>
		</ul>
	</div>
</div>

<div class="ftypes view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($ftype['Ftype']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($ftype['Ftype']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Sqltype'); ?></dt>
		<dd>
			<?php echo h($ftype['Ftype']['sqltype']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Extra'); ?></dt>
		<dd>
			<?php echo h($ftype['Ftype']['extra']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($ftype['Ftype']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Modified'); ?></dt>
		<dd>
			<?php echo h($ftype['Ftype']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
