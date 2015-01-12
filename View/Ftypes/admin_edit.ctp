<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Ftypes');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Ftypes'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Ftype']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Ftypes: ' . $this->data['Ftype']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Ftype');

?>
<div class="ftypes row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Ftype'), '#ftype');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='ftype' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('name', array(
					'label' => 'Name',
				));
				echo $this->Form->input('sqltype', array(
					'label' => 'Sqltype',
				));
				echo $this->Form->input('extra', array(
					'label' => 'Extra',
				));
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
