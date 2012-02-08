<?php
/* Chained Test cases generated on: 2012-02-08 01:50:54 : 1328665854*/
App::uses('ChainedComponent', 'Orders.Controller/Component');

/**
 * ChainedComponent Test Case
 *
 */
class ChainedComponentTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Chained = new ChainedComponent();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chained);

		parent::tearDown();
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {

	}

/**
 * testChainedSetting method
 *
 * @return void
 */
	public function testChainedSetting() {

	}

/**
 * testPayAmount method
 *
 * @return void
 */
	public function testPayAmount() {

	}

/**
 * testPay method
 *
 * @return void
 */
	public function testPay() {

	}

}
