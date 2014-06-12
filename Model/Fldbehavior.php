<?php
class Fldbehavior extends ProjectAppModel {
	var $name = 'Fldbehavior';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'Fld' => array(
			'className' => 'Project.Fld',
			'joinTable' => 'flds_fldbehaviors',
			'foreignKey' => 'fldbehavior_id',
			'associationForeignKey' => 'fld_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>