<?php
App::uses('Fld', 'Project.Model');

/**
 * Fld Test Case
 *
 */
class FldTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.project.fld',
		'plugin.project.pobject',
		'plugin.project.ftype',
		'plugin.project.fldbehavior',
		'plugin.project.flds_fldbehavior'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Fld = ClassRegistry::init('Project.Fld');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Fld);

		parent::tearDown();
	}

}
