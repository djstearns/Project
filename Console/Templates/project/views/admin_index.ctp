<?php

$header = <<<EOF
<?php
\$this->viewVars['title_for_layout'] = __d('croogo', '$pluralHumanName');
\$this->extend('/Common/$action');

\$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', '${pluralHumanName}'), array('action' => 'index'));

?>\n
EOF;
echo $header;

?>

<div class="<?php echo $pluralVar; ?> index">
	<?php echo "<?php echo \$this->Form->create(null, array('action'=>'deleteall')); ?>\n" ?>
	<table class="table table-striped">
	<tr>
	<th></th>	
	<?php foreach ($fields as $field): ?>
	<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
	<?php endforeach; ?>
	<?php
	if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $alias => $details) {
				
				/*echo "\t\t<td><?php foreach(\$kiddata[\$i-1]['$alias'] as \$alias){ echo \$this->Html->link(\$alias['{$details['displayField']}'], array('controller' => '{$alias}s', 'action' => 'view', \$alias['{$details['primaryKey']}'])); } ?></td>\n";
				*/
				echo "
				  <?php \$i = 0;\n \$arr = array(); 
				 foreach(\${$singularVar}data[\$i-1]['$alias'] as \${$alias}){ \$arr[] = \${$alias}['{$details['displayField']}']; }
					\$str = implode(',',\$arr); 
					echo '<th>{$alias}</th>'\n";
			
			}
			echo " ?>\n";
		}
	?>
	<th class="actions"><?php echo "<?php echo __d('croogo', 'Actions'); ?>"; ?></th>
	</tr>

	<?php
	echo "<?php \$i = 0; ?>\n";
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "<?php \$i++; ?>";
	echo "\t<tr>\n";
	echo "\t<td>\n";
    echo "<?php echo \$this->Form->input(\${$singularVar}['{$modelClass}']['id'], array('type'=>'checkbox','label'=>false)); ?>\n";
	echo "\t</td>\n";
	
		foreach ($fields as $field) {
			
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						/*echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						*/
						echo "\t\t<td><?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$displayField}'], '#', array('id'=>'{$field}','data-url'=>\$this->here.'/editindexsavefld', 'data-type'=>'select2', 'data-pk'=> \${$singularVar}['{$modelClass}']['{$primaryKey}'], 'class'=>'editable editable-click dclass-".$alias."', 'style'=>'display: inline;')); ?></td>\n";
						
						/*
						echo "\t\t<td><?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$displayField}'], '#', array('data-source'=>json_encode(\$".strtolower($alias)."s) ,'id'=>'{$field}','data-url'=>'editindexsavefld', 'data-type'=>'select2', 'data-pk'=> \${$singularVar}['{$modelClass}']['{$primaryKey}'], 'class'=>'editable editable-click', 'style'=>'display: inline;')); ?></td>\n";
						*/
						break;
					}
				}
			}

			if ($isKey !== true) {
				/*
					echo "\t\t<td><?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>&nbsp;</td>\n";
				*/
				echo "\t\t<td><?php echo \$this->Html->link(\${$singularVar}['{$modelClass}']['{$field}'], '#', array('id'=>'{$field}','data-url'=>\$this->here.'/editindexsavefld', 'data-type'=>'text', 'data-pk'=> \${$singularVar}['{$modelClass}']['{$primaryKey}'], 'class'=>'editable editable-click jclass', 'style'=>'display: inline;')); ?></td>\n";
			}
			
			
		}
		
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $alias => $details) {
				
				/*echo "\t\t<td><?php foreach(\$kiddata[\$i-1]['$alias'] as \$alias){ echo \$this->Html->link(\$alias['{$details['displayField']}'], array('controller' => '{$alias}s', 'action' => 'view', \$alias['{$details['primaryKey']}'])); } ?></td>\n";
				*/
				echo "
				 <td> <?php \$arr = array(); 
				 foreach(\${$singularVar}data[\$i-1]['$alias'] as \${$alias}){ \$arr[] = \${$alias}['{$details['displayField']}']; }
					\$str = implode(',',\$arr); 
					echo \$this->Html->link(\$str, '#', array( 'id'=>'{$alias}__{$details['displayField']}','data-url'=>\$this->here.'/savehabtmfld', 'data-type'=>'select2', 'data-pk'=> \${$singularVar}['{$modelClass}']['{$primaryKey}'], 'class'=>'editable editable-click mclass-{$alias}', 'style'=>'display: inline;')); ?></td>
				";
				echo "\t</td>\n";
			}
			
		}
		
		
		echo "\t\t<td class=\"item-actions\">\n";
		echo "\t\t\t<?php echo \$this->Croogo->adminRowAction('', array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('icon' => 'eye-open')); ?>\n";
		echo "\t\t\t<?php echo \$this->Croogo->adminRowAction('', array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('icon' => 'pencil')); ?>\n";
		echo "\t\t\t<?php echo \$this->Croogo->adminRowAction('', array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</table>
	<?php echo "<?php echo \$this->Form->end('Delete'); ?>\n" ?>
</div>
<script type="text/javascript">
$.fn.editable.defaults.mode = 'inline';

$('.jclass').editable();
<?php
if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $alias => $details) {
				
				/*echo "\$('#{$alias}__{$details['displayField']}').editable({
						inputclass: 'input-large',
							select2: {
								tags: <?php echo \$".strtolower($alias)."tr; ?>,
								tokenSeparators: [',', ' ']
							}
							});\n";	
				*/
				echo "\$('.mclass-".$alias."').editable({
						inputclass: 'input-large',
							select2: {
								tags: <?php echo \$".strtolower($alias)."str; ?>,
								tokenSeparators: [',', ' ']
							}
							});\n";	
							
			}
			
		}

if (!empty($associations['belongsTo'])) {
			foreach ($associations['belongsTo'] as $alias => $details) {
			/*	
			echo "var {$alias}slist = [];
			$.each(<?php echo json_encode(\$".strtolower($alias)."s); ?>, function(k, v) {
				{$alias}slist.push({id: k, text: v});
			}); 
			
			$('#".strtolower($alias)."_id').editable({
				source: {$alias}slist,
				select2: {
					width: 200,
					placeholder: 'Select $alias',
					allowClear: true
				} 
			});\n ";
			*/
			echo "var {$alias}slist = [];
			$.each(<?php echo json_encode(\$".strtolower($alias)."s); ?>, function(k, v) {
				{$alias}slist.push({id: k, text: v});
			}); 
			
			$('.dclass-".$alias."').editable({
				source: {$alias}slist,
				select2: {
					width: 200,
					placeholder: 'Select $alias',
					allowClear: true
				} 
			});\n ";
				
			}
			
		}
?>

</script>