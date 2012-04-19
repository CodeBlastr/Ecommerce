<?php
/* OrderItem Test cases generated on: 2012-02-08 01:19:15 : 1328663955*/
App::uses('OrderItem', 'Orders.Model');

/**
 * OrderItem Test Case
 *
 */
class OrderItemTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.Orders.order_item',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->OrderItem = ClassRegistry::init('Orders.OrderItem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderItem);

		parent::tearDown();
	}

/**
 * testStockControl method
 *
 * @return void
 */
	public function testStockControl() {

	}

/**
 * testCreateOrderItemFromCatalogItem method
 *
 * @return void
 */
	public function testCreateOrderItemFromCatalogItem() {

	}

/**
 * testPrepareCartDatum method
 *
 * @return void
 */
	public function testPrepareCartData() {
		$result = $this->OrderItem->prepareCartData(1, 1);
		$this->assertEqual(1, count($result)); // admin has one item in cart		
	}

/**
 * testCartExtra method
 *
 * @return void
 */
	public function testCartExtra() {

	}

/**
 * testMergeCartDuplicate method
 *
 * @return void
 */
	public function testMergeCartDuplicate() {

	}

/**
 * testAddToCart method
 *
 * @return void
 */
	public function testAddToCart() {

	}

/**
 * testAddAllToCart method
 *
 * @return void
 */
	public function testAddAllToCart() {

	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}

/**
 * testPay method
 *
 * @return void
 */
	public function testPay() {

	}

/**
 * testHandleVirtualItem method
 *
 * @return void
 */
	public function testHandleVirtualItem() {

	}

/**
 * testStatus method
 *
 * @return void
 */
	public function testStatus() {

	}

}
