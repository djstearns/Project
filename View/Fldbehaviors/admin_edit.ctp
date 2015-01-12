<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Fldbehaviors');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Fldbehaviors'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Fldbehavior']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Fldbehaviors: ' . $this->data['Fldbehavior']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Fldbehavior');

?>
<div class="fldbehaviors row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Fldbehavior'), '#fldbehavior');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='fldbehavior' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('name', array(
					'label' => 'Name',
				));
				echo $this->Form->input('Fld');
			?>
			</div>
			<?php echo $this->Croogo->adminTabs(); ?>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
