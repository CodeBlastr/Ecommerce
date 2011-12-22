<?php
App::uses('OrdersAppModel', 'Orders.Model');
/**
 * OrderPayment Model
 *
 * @property OrderPayment $OrderPayment
 */
class OrderPayment extends OrdersAppModel {
	var $name = 'OrderPayment';
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

	var $hasMany = array(
		'OrderItem' => array(
			'className' => 'Orders.OrderItem',
			'foreignKey' => 'order_payment_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'OrderTransaction' => array(
			'className' => 'Orders.OrderTransaction',
			'foreignKey' => 'order_payment_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	/** 
	 * Get Order Transaction Id
	 * 
	 * @param {$transactionId}  transaction_id	
	 * @param {$arb} //optional default value = 0
	 * return {OrderPayment.order_transaction_id}
	 */
	function getOrderTransactionId($transactionId, $arb = 0) {
		
		$transaction = $this->find('first', array('conditions' => 
 									array('transaction_id' => $transactionId, 'is_arb' => $arb)));
		return $transaction['OrderPayment']['order_transaction_id'] ;			 
	}
	
	/** 
	 * Get Arb Profile Id
	 * 
	 * @param {$orderTransactionId}
	 * return {profile id}
	 */
	function getArbProfileId($orderTransactionId = null) {
		
		$arb_profile_id = $this->find('first', array('conditions' => array(
												'order_transaction_id' => $orderTransactionId)
					));
		return $arb_profile_id['OrderPayment']['transaction_id'] ;			 
	}
}
?>