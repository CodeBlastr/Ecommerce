<?php
/**
 * OrderItemFixture
 *
 */
class OrderItemFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string
 */
	public $name = 'OrderItem';
	
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 512, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'catalog_item_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order_payment_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order_shipment_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order_transaction_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quantity' => array('type' => 'float', 'null' => false, 'default' => '1'),
		'price' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'weight' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'height' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'width' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'length' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'incart', 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => '\'\',\'pending\',\'sent\',\'successful\',\'paid\',\'frozen\',\'cancelled\',\'incart\',\'requestReturn\',\'return\'', 'charset' => 'utf8'),
		'tracking_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'deadline' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'arb_settings' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'payment_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'featured' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'foreign_key' =>  array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_virtual' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'customer_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'contact_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'assignee_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'creator_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modifier_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Instant Coffee',
			'catalog_item_id' => '189813-12831-12831923-12312',
			'order_payment_id' => '189813-12831-12831923-12312',
			'order_shipment_id' => '189813-12831-12831923-12312',
			'order_transaction_id' => '189813-12831-12831923-12312',
			'quantity' => 1,
			'price' => 1,
			'weight' => 1,
			'height' => 1,
			'width' => 1,
			'length' => 1,
			'status' => 'incart',
			'tracking_no' => null,
			'location' => null,
			'deadline' => null,
			'arb_settings' => null,
			'payment_type' => null,
			'featured' => 1,
			'foreign_key' => '189813-12831-12831923-12312',
			'model' => 'CatalogItem',
			'is_virtual' => 1,
			'customer_id' => 1,
			'contact_id' => 1,
			'assignee_id' => 1,
			'creator_id' => 1,
			'modifier_id' => 1,
			'created' => '2012-04-19 17:33:37',
			'modified' => '2012-04-19 17:33:37'
		),
	);
}
