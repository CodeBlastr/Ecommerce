<?php
class OrderTransaction extends OrdersAppModel {
	var $name = 'OrderTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'OrderItem' => array(
			'className' => 'Orders.OrderItem',
			'foreignKey' => 'order_transaction_id'
		),
	);
	
	var $hasOne = array(
		'OrderShipment' => array(
			'className' => 'Orders.OrderShipment',
			'foreignKey' => 'order_transaction_id'
		),
		'OrderPayment' => array(
			'className' => 'Orders.OrderPayment',
			'foreignKey' => 'order_transaction_id'
		),
	);
	
	var $belongsTo = array(
//		'OrderPayment' => array(
//			'className' => 'Orders.OrderPayment',
//			'foreignKey' => 'order_payment_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
		'Customer' => array(
			'className' => 'Users.User',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assignee' => array(
			'className' => 'Users.User',
			'foreignKey' => 'assignee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*
	 * add the transaction to DB.
	 *
	 * @param {array} 	$data to be added 
	 * @param {int}		$response: response from the payment after charging card.
	 * @param {int}		$user_id:  logged user id
	 */	
	function add($data = null) {
		if (!empty($data)) {
			# save the order transaction
			if ($this->save($data)) {
				#if OrderTransaction Id is not set then set to last save.
				if(!isset($data['OrderTransaction']['id'])) {
					$data['OrderTransaction']['id'] = $this->id;
				}	
				
				if ($this->_shipmentAndPayment($data)) {
					// following are filled to be passed to order item
					$data['OrderTransaction']['order_shipment_id'] = $this->OrderShipment->id;
					$data['OrderTransaction']['order_payment_id'] = $this->OrderPayment->id;
					if ($this->OrderItem->pay($data)) {
						return true;
					} else {
						#roll back 3x
						$this->OrderShipment->delete($this->OrderShipment->id);
						$this->OrderPayment->delete($this->OrderPayment->id);
						$this->delete($data['OrderTransaction']['id']);
						return false;
					}				
				} else {
					#roll back order transaction
					$this->delete($data['OrderTransaction']['id']);
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	
	/** 
	 * Save Order Shipment and Payment Data
	 * 
	 * @param {array}		Data array with some non-typical keys
	 * @todo				This could probably be normalized a bit, and moved to the respective models.
	 */
	function _shipmentAndPayment($data) {
		
		$this->OrderPayment->create();
		$this->OrderShipment->create();
		// save default master addresses of shipment and billing
		if (!($this->OrderShipment->find('first', array(
						'conditions' => array('OrderShipment.user_id' => $data['OrderTransaction']['customer_id'],
							'OrderShipment.order_transaction_id is null'))
				))) {
					
					$ship_data['OrderShipment'] = $data['OrderShipment'];
					$ship_data['OrderShipment']['user_id'] = $data['OrderTransaction']['customer_id'] ;
					$this->OrderShipment->save($ship_data);
				}
				
		if (!($this->OrderPayment->find('first', array(
							'conditions' => array('OrderPayment.user_id' => $data['OrderTransaction']['customer_id'],
									'OrderPayment.order_transaction_id is null'))
					))) {
					$bill_data['OrderPayment'] = $data['OrderPayment'];
					$bill_data['OrderPayment']['user_id'] = $data['OrderTransaction']['customer_id'] ;
					$this->OrderPayment->save($bill_data);
		}
				
		$this->OrderPayment->create();
		$this->OrderShipment->create();
		
		#setup order shipment data
		$shipmentAndPayment['OrderShipment'] = $data['OrderShipment'];
		if(isset($data['Meta']))
			$shipmentAndPayment['OrderShipment'] = array_merge($shipmentAndPayment['OrderShipment'], 
				$data['Meta']);
		$shipmentAndPayment['OrderShipment']['order_transaction_id'] = $data['OrderTransaction']['id'];
		#setup order payment data
		$response = $data['Response'];
		$shipmentAndPayment['OrderPayment'] = array_merge($data['OrderPayment'], $response);
		if(isset($data['Meta']))
			$shipmentAndPayment['OrderPayment'] = array_merge($shipmentAndPayment['OrderPayment'],
				 $data['Meta']);
		$shipmentAndPayment['OrderPayment']['order_transaction_id'] = $data['OrderTransaction']['id'];
		if ($this->OrderShipment->save($shipmentAndPayment)) {
			$orderShipmentId = $this->OrderShipment->id;
			if ($this->OrderPayment->save($shipmentAndPayment)) {
				return true;
			} else {
				#rollback
				$this->OrderShipment->delete($orderShipmentId);
				return false;
			}
		} else {
			return false;
		}
	}
	
	/** 
	 * Get Arb Profile Id
	 * 
	 * @param {$user_id}		user id according to which profile id return
	 * return {OrderTransaction.id}
	 */
	function getArbTransactionId($user_id = null) {
		
		$arb_ot_id = $this->find('first', array('conditions' => array('is_arb' => 1, 
							'customer_id' => $user_id), 'order' => array('created DESC')
						));
		return $arb_ot_id['OrderTransaction']['id'] ;			 
	}
	
	/** 
	 * Get Arb Payment Mode
	 * 
	 * @param {$order_transaction_id}	user id according to which profile id return
	 * return {OrderTransaction.mode}
	 */
	function getArbPaymentMode($order_transaction_id = null) {
		
		$arb_payment_mode = $this->find('first', array('conditions' => array('id' => $order_transaction_id) 
						));
		return $arb_payment_mode['OrderTransaction']['mode'] ;			 
	}
	
	/*Change Status
	 *@param {$transactionId} profile id of arb transaction in order payment 
	 *@param {$status}
	 *@param {$processor_response}
	 *Fetch Transaction Id from Order Payment Table and update 
	 *Order Transaction with new Status
	 */
	function changeStatus($order_transaction_id, $status, $processor_response){
		
		$this->data['OrderTransaction']['id'] = $order_transaction_id ;
		$this->data['OrderTransaction']['status'] = $status;
		$this->data['OrderTransaction']['processor_response'] = $processor_response;
		$this->save($this->data);
	}
	
	/** 
	 * Get Arb Transaction Amount
	 * 
	 * @param {$order_transaction_id} transaction_id according to which transaction amount return
	 * return {OrderTransaction.total}
	 */
	function getArbTransactionAmount($order_transaction_id = null) {
		
		$arb_amount = $this->find('first', array('fields' => array('total'),
						'conditions' => array('id' => $order_transaction_id) 
						));
		return $arb_amount['OrderTransaction']['total'] ;			 
	}
	
	/** 
	 * Get Arb Transaction User Id
	 * 
	 * @param {$order_transaction_id} transaction_id according to which transaction amount return
	 * return {OrderTransaction.customer_id}
	 */
	function getArbTransactionUserId($order_transaction_id = null) {
		
		$arb_amount = $this->find('first', array('fields' => array('customer_id'),
						'conditions' => array('id' => $order_transaction_id) 
						));
		return $arb_amount['OrderTransaction']['customer_id'] ;			 
	}
	
	/** 
	 * Get Arb Transaction Status
	 * 
	 * @param {$order_transaction_id} transaction_id according to which transaction status return
	 * return {OrderTransaction.status}
	 */
	function getArbTransactionStatus($order_transaction_id = null) {
		
		$arb_amount = $this->find('first', array('fields' => array('status'),
						'conditions' => array('id' => $order_transaction_id) 
						));
		return $arb_amount['OrderTransaction']['status'] ;			 
	}
}
?>