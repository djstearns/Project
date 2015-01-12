<?php
App::uses('ProjectAppModel', 'Project.Model');
/**
 * PobjectsPobjectbehavior Model
 *
 * @property Pobject $Pobject
 * @property Pobjectbehavior $Pobjectbehavior
 */
class Pobject extends ProjectAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pobject' => array(
			'className' => 'Pobject',
			'foreignKey' => 'pobject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pobjectbehavior' => array(
			'className' => 'Pobjectbehavior',
			'foreignKey' => 'pobjectbehavior_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
