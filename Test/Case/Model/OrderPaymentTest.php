<?php
/* OrderPayment Test cases generated on: 2012-02-08 01:19:37 : 1328663977*/
App::uses('OrderPayment', 'Orders.Model');

/**
 * OrderPayment Test Case
 *
 */
class OrderPaymentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->OrderPayment = ClassRegistry::init('OrderPayment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderPayment);

		parent::tearDown();
	}

/**
 * testGetOrderTransactionId method
 *
 * @return void
 */
	public function testGetOrderTransactionId() {

	}

/**
 * testGetArbProfileId method
 *
 * @return void
 */
	public function testGetArbProfileId() {

	}

}
