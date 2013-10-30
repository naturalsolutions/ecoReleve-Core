<?php
App::uses('TAutorisation', 'Model');

/**
 * TAutorisation Test Case
 *
 */
class TAutorisationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.t_autorisation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TAutorisation = ClassRegistry::init('TAutorisation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TAutorisation);

		parent::tearDown();
	}

}
