<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Pobjects');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Pobjects'), array('action' => 'index'));

?>

<div class="pobjects index">
	<?php echo $this->Form->create(null, array('action'=>'deleteall')); ?>
	<table class="table table-striped">
	<tr>
	<th></th>	
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('project_id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('description'); ?></th>
		
				  <?php $i = 0;
 $arr = array(); 
				 foreach($pobjectdata[$i]['Pobjectbehavior'] as $Pobjectbehavior){ $arr[] = $Pobjectbehavior['name']; }
					$str = implode(',',$arr); 
					echo '<th>Pobjectbehavior</th>'
 ?>
	<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>

	<?php $i = 0; ?>
<?php foreach ($pobjects as $pobject): ?>
<?php $i++; ?>	<tr>
	<td>
<?php echo $this->Form->input($pobject['Pobject']['id'], array('type'=>'checkbox','label'=>false)); ?>
	</td>
		<td><?php echo $this->Html->link($pobject['Pobject']['id'], '#', array('id'=>'id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $pobject['Pobject']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($pobject['Project']['name'], '#', array('id'=>'project_id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'select2', 'data-pk'=> $pobject['Pobject']['id'], 'class'=>'editable editable-click dclass-Project', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($pobject['Pobject']['name'], '#', array('id'=>'name','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $pobject['Pobject']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($pobject['Pobject']['description'], '#', array('id'=>'description','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $pobject['Pobject']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>

				 <td> <?php $arr = array(); 
				 foreach($pobjectdata[$i-1]['Pobjectbehavior'] as $Pobjectbehavior){ $arr[] = $Pobjectbehavior['name']; }
					$str = implode(',',$arr); 
					echo $this->Html->link($str, '#', array( 'id'=>'Pobjectbehavior__name','data-url'=>$this->here.'/savehabtmfld', 'data-type'=>'select2', 'data-pk'=> $pobject['Pobject']['id'], 'class'=>'editable editable-click mclass-Pobjectbehavior', 'style'=>'display: inline;')); ?></td>
					</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $pobject['Pobject']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $pobject['Pobject']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $pobject['Pobject']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $pobject['Pobject']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end('Delete'); ?>
</div>
<script type="text/javascript">
$.fn.editable.defaults.mode = 'inline';

$('.jclass').editable();
$('.mclass-Pobjectbehavior').editable({
						inputclass: 'input-large',
							select2: {
								tags: <?php echo $pobjectbehaviorstr; ?>,
								tokenSeparators: [',', ' ']
							}
							});
var Projectslist = [];
			$.each(<?php echo json_encode($projects); ?>, function(k, v) {
				Projectslist.push({id: k, text: v});
			}); 
			
			$('.dclass-Project').editable({
				source: Projectslist,
				select2: {
					width: 200,
					placeholder: 'Select Project',
					allowClear: true
				} 
			});
 
</script>
