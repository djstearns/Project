<?php
App::uses('ProjectAppModel', 'Project.Model');
/**
 * FldsFldbehavior Model
 *
 * @property Fld $Fld
 * @property Fldbehavior $Fldbehavior
 */
class FldsFldbehavior extends ProjectAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Fld' => array(
			'className' => 'Project.Fld',
			'foreignKey' => 'fld_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Fldbehavior' => array(
			'className' => 'Project.Fldbehavior',
			'foreignKey' => 'fldbehavior_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
