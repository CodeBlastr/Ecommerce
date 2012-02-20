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
	public $fixtures = array('plugin.orders.order_item', 'plugin.catalogs.catalog_item', 'plugin.catalogs.catalog', 'app.alias', 'plugin.catalogs.catalog_item_brand', 'plugin.users.user', 'plugin.users.user_role', 'plugin.users.user_wall', 'plugin.contacts.contact', 'app.enumeration', 'plugin.contacts.contact_address', 'plugin.contacts.contact_detail', 'app.enumerations', 'plugin.tasks.task', 'plugin.projects.project', 'plugin.projects.project_issue', 'plugin.timesheets.timesheet_time', 'plugin.timesheets.timesheet', 'app.timesheets_timesheet_time', 'plugin.projects.projects_member', 'plugin.users.user_group', 'plugin.users.users_user_group', 'plugin.users.user_group_wall_post', 'plugin.users.used', 'plugin.messages.message', 'app.invoice', 'app.invoice_item', 'app.invoice_time', 'app.projects_watcher', 'plugin.wikis.wiki', 'plugin.wikis.wiki_page', 'plugin.wikis.wiki_content', 'plugin.galleries.gallery', 'plugin.galleries.gallery_image', 'plugin.wikis.wiki_content_version', 'app.projects_wiki', 'plugin.categories.category', 'plugin.categories.category_option', 'plugin.categories.categorized_option', 'plugin.categories.categorized', 'app.contacts_contact', 'plugin.users.user_status', 'plugin.users.user_follower', 'plugin.orders.order_payment', 'plugin.orders.order_transaction', 'plugin.orders.order_coupon', 'plugin.orders.order_shipment', 'app.location', 'plugin.catalogs.catalog_item_price');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->OrderItem = ClassRegistry::init('OrderItem');
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
	public function testPrepareCartDatum() {

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
