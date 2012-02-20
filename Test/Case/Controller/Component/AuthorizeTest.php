<?php
/* Authorize Test cases generated on: 2012-02-08 01:48:47 : 1328665727*/
App::uses('AuthorizeComponent', 'Orders.Controller/Component');

/**
 * Authorize Test Case
 *
 */
class AuthorizeTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Authorize = new AuthorizeComponent();
	}
	
	public function testPay() {
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Authorize);

		parent::tearDown();
	}

}
