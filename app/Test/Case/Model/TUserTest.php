<?php
App::uses('TUser', 'Model');

/**
 * TUser Test Case
 *
 */
class TUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.t_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TUser = ClassRegistry::init('TUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TUser);

		parent::tearDown();
	}

}
