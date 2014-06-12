<?php
App::uses('ProjectAppModel', 'Project.Model');
/**
 * Pobject Model
 *
 * @property Project $Project
 * @property Fld $Fld
 * @property Pobjectbehavior $Pobjectbehavior
 */
class Pobject extends ProjectAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $actsas = array('Containable');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Fld' => array(
			'className' => 'Project.Fld',
			'foreignKey' => 'pobject_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Pobjectbehavior' => array(
			'className' => 'Project.Pobjectbehavior',
			'joinTable' => 'pobjects_pobjectbehaviors',
			'foreignKey' => 'pobject_id',
			'associationForeignKey' => 'pobjectbehavior_id',
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
