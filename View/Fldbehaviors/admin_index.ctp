<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Fldbehaviors');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Fldbehaviors'), array('action' => 'index'));

?>
<div class="fldbehaviors index">
		<table class="table table-striped">
	<tr>
	<th></th>	
	   
	<th><?php echo $this->Paginator->sort('id'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('name'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('created'); ?></th>
	   
	<th><?php echo $this->Paginator->sort('modified'); ?></th>
		 
					<?php echo '<th>Fld</th>'
 ?>
	<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>

	<?php $i = 0; ?>
<?php foreach ($fldbehaviors as $fldbehavior): ?>
<?php $i++; ?>	<tr id='$fldbehavior['Fldbehavior']['id']'>
	<td>
<?php echo $this->Form->input($fldbehavior['Fldbehavior']['id'], array('type'=>'checkbox', 'class'=>'markdelete', 'value'=>$fldbehavior['Fldbehavior']['id'], 'label'=>false)); ?>
	</td>
		<td><?php echo $this->Html->link($fldbehavior['Fldbehavior']['id'], '#', array('id'=>'id','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fldbehavior['Fldbehavior']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;', 'other'=>'')); ?></td>
		<td><?php echo $this->Html->link($fldbehavior['Fldbehavior']['name'], '#', array('id'=>'name','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> $fldbehavior['Fldbehavior']['id'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;', 'other'=>'')); ?></td>
		<td><?php echo $this->Html->link($fldbehavior['Fldbehavior']['created'], '#', array('value'=>$fldbehavior['Fldbehavior']['created'], 'id'=>'created','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'datetime', 'data-pk'=> $fldbehavior['Fldbehavior']['id'], 'class'=>'editable editable-click datetimepicker', 'style'=>'display: inline;')); ?></td>		<td><?php echo $this->Html->link($fldbehavior['Fldbehavior']['modified'], '#', array('value'=>$fldbehavior['Fldbehavior']['modified'], 'id'=>'modified','data-url'=>$this->here.'/editindexsavefld', 'data-type'=>'datetime', 'data-pk'=> $fldbehavior['Fldbehavior']['id'], 'class'=>'editable editable-click datetimepicker', 'style'=>'display: inline;')); ?></td>
				 <td> <?php $arr = array(); 
				 $j = 0;
				 $val = 10;
				  foreach($fldbehavior['Fld'] as $key => $Fld){
						 if(isset($fldbehavior['Fld'][$j]) && ($val < count($Fld)) ){
				 			$arr[] = $Fld['name']; 
							$j++;
						 }
				 }
				 $str = implode(',',$arr); 
					echo $this->Html->link($str, '#', array( 'id'=>'Fld__name','data-url'=>$this->here.'/savehabtmfld', 'data-type'=>'select2', 'data-pk'=> $fldbehavior['Fldbehavior']['id'], 'class'=>'editable editable-click mclass-Fld', 'style'=>'display: inline;')); ?></td>
					</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $fldbehavior['Fldbehavior']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $fldbehavior['Fldbehavior']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $fldbehavior['Fldbehavior']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $fldbehavior['Fldbehavior']['id'])); ?>
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
$('.mclass-Fld').editable({
						inputclass: 'input-large',
							select2: {
								tags: <?php echo $fldstr; ?>,
								tokenSeparators: [',', ' ']
							}
							});
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