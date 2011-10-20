<?php
class OrderShipment extends OrdersAppModel {
	var $name = 'OrderShipment';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'OrderTransaction' => array(
			'className' => 'Orders.OrderTransaction',
			'foreignKey' => 'order_transaction_id',
			'dependent' => true,
		)
	);
}
?>