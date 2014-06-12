<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Flds');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Flds'), array('action' => 'index'));

?>

<div class="flds index">
	<?php echo $this->Form->create(null, array('action'=>'deleteall')); ?>
	<table class="table table-striped">
	<tr>
	<th></th>	
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('pobject_id'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('ftype_id'); ?></th>
		<th><?php echo $this->Paginator->sort('length'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		
				  <?php $i = 0;
 $arr = array(); 
				 foreach($flddata[$i-1]['Fldbehavior'] as $Fldbehavior){ $arr[] = $Fldbehavior['name']; }
					$str = implode(',',$arr); 
					echo '<th>Fldbehavior</th>'
 ?>
	<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>

	<?php $i = 0; ?>
<?php foreach ($flds as $fld): ?>
<?php $i++; ?>	<tr>
	<td>
<?php echo $this->Form->input($fld['Fld']['id'], array('type'=>'checkbox','label'=>false)); ?>
	</td>
		<td><?php echo $this->Html->link($fld['Fld']['id'], '#', array('id'=>'id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($fld['Pobject']['name'], '#', array('id'=>'pobject_id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'select2', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click dclass-Pobject', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($fld['Fld']['name'], '#', array('id'=>'name','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($fld['Ftype']['name'], '#', array('id'=>'ftype_id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'select2', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click dclass-Ftype', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($fld['Fld']['length'], '#', array('id'=>'length','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($fld['Fld']['created'], '#', array('id'=>'created','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>
		<td><?php echo $this->Html->link($fld['Fld']['modified'], '#', array('id'=>'modified','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>

				 <td> <?php $arr = array(); 
				 foreach($flddata[$i-1]['Fldbehavior'] as $Fldbehavior){ $arr[] = $Fldbehavior['name']; }
					$str = implode(',',$arr); 
					echo $this->Html->link($str, '#', array( 'id'=>'Fldbehavior__name','data-url'=>$this->here.'/savehabtmfld', 'data-type'=>'select2', 'data-pk'=> $fld['Fld']['id'], 'class'=>'editable editable-click mclass-Fldbehavior', 'style'=>'display: inline;')); ?></td>
					</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $fld['Fld']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $fld['Fld']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $fld['Fld']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $fld['Fld']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end('Delete'); ?>
</div>
<script type="text/javascript">
$.fn.editable.defaults.mode = 'inline';

$('.jclass').editable();
$('.mclass-Fldbehavior').editable({
						inputclass: 'input-large',
							select2: {
								tags: <?php echo $fldbehaviorstr; ?>,
								tokenSeparators: [',', ' ']
							}
							});
var Pobjectslist = [];
			$.each(<?php echo json_encode($pobjects); ?>, function(k, v) {
				Pobjectslist.push({id: k, text: v});
			}); 
			
			$('.dclass-Pobject').editable({
				source: Pobjectslist,
				select2: {
					width: 200,
					placeholder: 'Select Pobject',
					allowClear: true
				} 
			});
 var Ftypeslist = [];
			$.each(<?php echo json_encode($ftypes); ?>, function(k, v) {
				Ftypeslist.push({id: k, text: v});
			}); 
			
			$('.dclass-Ftype').editable({
				source: Ftypeslist,
				select2: {
					width: 200,
					placeholder: 'Select Ftype',
					allowClear: true
				} 
			});
 
</script>