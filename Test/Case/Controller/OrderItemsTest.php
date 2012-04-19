<?php
/* OrderItems Test cases generated on: 2012-02-08 01:27:49 : 1328664469*/
App::uses('OrderItemsController', 'Orders.Controller');

/**
 * TestOrderItems *
 */
class TestOrderItems extends OrderItemsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
	
/**
 * Used to make protected function available to tests.
 */
    public function public_updateCartCompatibility() {
        return $this->_updateCartCompatibility();
    }
}

/**
 * OrderItems Test Case
 *
 */
class OrderItemsTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->OrderItems = new TestOrderItems();
		//$this->OrderItems->constructClasses();
	}
	
	public function test_updateCartCompatibility() {
		//$results = $this->OrderItems->public_updateCartCompatibility();
		//$this->assertEqual(null, $results);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderItems);

		parent::tearDown();
	}

}
