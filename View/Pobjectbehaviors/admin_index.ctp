<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Pobjectbehaviors');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Pobjectbehaviors'), array('action' => 'index'));

?>

<div class="pobjectbehaviors index">
	<?php echo $this->Form->create(null, array('action'=>'deleteall')); ?>
	<table class="table table-striped">
	<tr>
	<th></th>	
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		
				  <?php $i = 0;
 $arr = array(); 
				 foreach($pobjectbehaviordata[$i-1]['Pobject'] as $Pobject){ $arr[] = $Pobject['name']; }
					$str = implode(',',$arr); 
					echo '<th>Pobject</th>'
 ?>
	<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>

	<?php $i = 0; ?>
<?php foreach ($pobjectbehaviors as $pobjectbehavior): ?>
<?php $i++; ?>	<tr>
	<td>
<?php echo $this->Form->input($pobjectbehavior['Pobjectbehavior']['id'], array('type'=>'checkbox','label'=>false)); ?>
	</td>
		<td><?php echo $this->Html->link($pobjectbehavior['Pobjectbehavior']['id'], '#', array('id'=>'id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $pobjectbehavior['Pobjectbehavior']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($pobjectbehavior['Pobjectbehavior']['name'], '#', array('id'=>'name','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $pobjectbehavior['Pobjectbehavior']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>

				 <td> <?php $arr = array(); 
				 foreach($pobjectbehaviordata[$i-1]['Pobject'] as $Pobject){ $arr[] = $Pobject['name']; }
					$str = implode(',',$arr); 
					echo $this->Html->link($str, '#', array( 'id'=>'Pobject__name','data-url'=>$this->here.'/savehabtmfld', 'data-type'=>'select2', 'data-pk'=> $pobjectbehavior['Pobjectbehavior']['id'], 'class'=>'editable editable-click mclass-Pobject', 'style'=>'display: inline;')); ?></td>
					</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $pobjectbehavior['Pobjectbehavior']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $pobjectbehavior['Pobjectbehavior']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $pobjectbehavior['Pobjectbehavior']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $pobjectbehavior['Pobjectbehavior']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end('Delete'); ?>
</div>
<script type="text/javascript">
$.fn.editable.defaults.mode = 'inline';

$('.jclass').editable();
$('.mclass-Pobject').editable({
						inputclass: 'input-large',
							select2: {
								tags: <?php echo $pobjectstr; ?>,
								tokenSeparators: [',', ' ']
							}
							});

</script>