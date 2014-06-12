<?php
App::uses('ProjectAppModel', 'Project.Model');
/**
 * Pobjectbehavior Model
 *
 * @property Pobject $Pobject
 */
class Pobjectbehavior extends ProjectAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Pobject' => array(
			'className' => 'Project.Pobject',
			'joinTable' => 'pobjects_pobjectbehaviors',
			'foreignKey' => 'pobjectbehavior_id',
			'associationForeignKey' => 'pobject_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
