<?php
App::uses('ProjectAppModel', 'Project.Model');
/**
 * Fld Model
 *
 * @property Pobject $Pobject
 * @property Ftype $Ftype
 * @property Fldbehavior $Fldbehavior
 */
class Fld extends ProjectAppModel {

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
		'Pobject' => array(
			'className' => 'Project.Pobject',
			'foreignKey' => 'pobject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Ftype' => array(
			'className' => 'Project.Ftype',
			'foreignKey' => 'ftype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Fldbehavior' => array(
			'className' => 'Fldbehavior',
			'joinTable' => 'flds_fldbehaviors',
			'foreignKey' => 'fld_id',
			'associationForeignKey' => 'fldbehavior_id',
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
