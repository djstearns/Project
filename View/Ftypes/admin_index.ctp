<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Ftypes');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Ftypes'), array('action' => 'index'));

?>
<div class="ftypes index">
		<table class="table table-striped">
	<tr>
	<th></th>	
	   
	<th><?php echo $this->Paginator->sort('id'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('name'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('sqltype'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('extra'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('created'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>

	<?php $i = 0; ?>
<?php foreach ($ftypes as $ftype): ?>
<?php $i++; ?>	<tr id='$ftype['Ftype']['id']'>
	<td>
<?php echo $this->Form->input($ftype['Ftype']['id'], array('type'=>'checkbox', 'class'=>'markdelete', 'value'=>$ftype['Ftype']['id'], 'label'=>false)); ?>
	</td>
		<td><?php echo $this->Html->link($ftype['Ftype']['id'], '#', array('id'=>'id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $ftype['Ftype']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;', 'other'=>'')); ?></td>
		<td><?php echo $this->Html->link($ftype['Ftype']['name'], '#', array('id'=>'name','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $ftype['Ftype']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;', 'other'=>'')); ?></td>
		<td><?php echo $this->Html->link($ftype['Ftype']['sqltype'], '#', array('id'=>'sqltype','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $ftype['Ftype']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;', 'other'=>'')); ?></td>
		<td><?php echo $this->Html->link($ftype['Ftype']['extra'], '#', array('id'=>'extra','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $ftype['Ftype']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;', 'other'=>'')); ?></td>
		<td><?php echo $this->Html->link($ftype['Ftype']['created'], '#', array('value'=>$ftype['Ftype']['created'], 'id'=>'created','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'datetime', 'data-pk'=> $ftype['Ftype']['id'], 'class'=>'editable editable-click datetimepicker', 'style'=>'display: inline;')); ?></td>		<td><?php echo $this->Html->link($ftype['Ftype']['modified'], '#', array('value'=>$ftype['Ftype']['modified'], 'id'=>'modified','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'datetime', 'data-pk'=> $ftype['Ftype']['id'], 'class'=>'editable editable-click datetimepicker', 'style'=>'display: inline;')); ?></td>		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $ftype['Ftype']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $ftype['Ftype']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $ftype['Ftype']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $ftype['Ftype']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	</div>
<script type="text/javascript">
$('.deleteall').click( function (e) {
	e.preventDefault();
	var allVals = [];
	$('.markdelete:checked').each(function() {
	   allVals.push($(this).val());
	 });
	 $.ajax({
	  type: "POST", 
	  url: <?php echo "'".$this->here."/deleteall'"; ?>,	  data: allVals,
	  success: function(data, config) {
		$('.markdelete:checked').each(function() {
		   $('#'+$(this).val()).hide();
		 });
	  }  
	});
	 return false;
	
});

$.fn.editable.defaults.mode = 'inline';

$('.jclass').editable();
		$(function(){
			$('.datetimepicker').editable({
				format: 'yyyy-mm-dd hh:ii',    
				viewformat: 'dd/mm/yyyy hh:ii',    
				datetimepicker: {
						weekStart: 1
				   }
				
			});
		});
		$('.dclass-checkbox').click( function (e){
			e.preventDefault();
			var linkitem = $(this);
			//$(this).attr("src","");
			var id = $(this).attr('id');
			var value = $(this).attr('value');
			var pk = $(this).attr('data-pk');
			$.ajax({
			  type: "POST", 
			  url: <?php echo "'".$this->here."/editindexsavefld'"; ?>,			  data: {"name":id,"check":value,"pk":pk},
			  success: function(data, config) {
				if(data == '1'){
					$(linkitem).attr("src", "<?php echo $this->base; ?>/project/img/icons/tick.png");					$(linkitem).attr("value", 0);
				}else{
					$(linkitem).attr("src", "<?php echo $this->base; ?>/project/img/icons/cross.png");					$(linkitem).attr("value", 1);
				}
			  }
			  
			});
			 return false;
		});
</script>