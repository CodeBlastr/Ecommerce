<?php
/* Paypal Test cases generated on: 2012-02-08 01:51:20 : 1328665880*/
App::uses('PaypalComponent', 'Orders.Controller/Component');

/**
 * PaypalComponent Test Case
 *
 */
class PaypalComponentTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Paypal = new PaypalComponent();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Paypal);

		parent::tearDown();
	}

/**
 * testRecurring method
 *
 * @return void
 */
	public function testRecurring() {

	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {

	}

/**
 * testChainedPayment method
 *
 * @return void
 */
	public function testChainedPayment() {

	}

/**
 * testManageRecurringPaymentsProfileStatus method
 *
 * @return void
 */
	public function testManageRecurringPaymentsProfileStatus() {

	}

/**
 * testPay method
 *
 * @return void
 */
	public function testPay() {

	}

}
