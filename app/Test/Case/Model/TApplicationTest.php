<?php
App::uses('TApplication', 'Model');

/**
 * TApplication Test Case
 *
 */
class TApplicationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.t_application'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TApplication = ClassRegistry::init('TApplication');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TApplication);

		parent::tearDown();
	}

}
