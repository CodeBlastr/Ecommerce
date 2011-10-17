<?php
/**
 * Order Transactions Controller
 *
 * All transactions should be pushed through this controller. It is the catch all 
 * and should be able to (though it doesn't as of today) handle all monetary transaction
 * types.  
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.orders.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Extend this controller by leaps and bounds to handle many transaction types and scenarios. 
 */
class OrderTransactionsController extends OrdersAppController {

	var $name = 'OrderTransactions';
	var $components = array('Ssl', 'Payments' /*, 'Shipping.Fedex'*/);
	
	function index() {
		#$this->OrderTransaction->recursive = 0;
		$this->paginate= array(
			'order' => 'OrderTransaction.status, OrderTransaction.created',
			'contain' => array(
				'OrderItem', 
				'Creator'
				),
			);
		$this->set('orderTransactions', $this->paginate());
	}
	
	/**
	 * Order Transactions by Assignee
	 *
	 * Using this function we set the variables for an index of transactions have been assigned to the logged in user.
	 */
	function assigned() {
		$orderItems = $this->OrderTransaction->OrderItem->find('all', array(
			'conditions' => array(
				'OrderItem.assignee_id' => $this->Session->read('Auth.User.id'),
				),
			));
		$orderItems = Set::extract('/OrderItem/order_transaction_id', $orderItems);
		#$this->OrderTransaction->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'OrderTransaction.id' => $orderItems,
				),
			);
		$this->set('orderTransactions', $this->paginate());
	}
	
	/**
	 * Order Transactions by Customer
	 *
	 * Using this function we set the variables for an index of transactions which are for the logged in user.
	 */
	function customer() {
		#$this->OrderTransaction->recursive = 0;
		$this->paginate = array(
			'conditions'=>array(
				'OrderTransaction.customer_id' => $this->Session->read('Auth.User.id'),
				),
			'contain'=>array(
				'OrderItem',
				),
			);
		$this->set('orderTransactions', $this->paginate());
	}
	

	/** 
	 * Method for sending variables to the checkout view
	 *
	 * @todo		Need to add an checkout callback for items that have the model/foreignKey relationship for both failed and successful transactions.  For example, when you checkout and have purchased a banner, we would want this checkout() function to fire a call back to function within the banner model, which marks the banner as paid.  Noting that we would want the item itself to notify checkout that this callback needs to be fired.  Noting further that we would send the entire $this->data, back with any callback to cover a wide range of use cases for the callback.
	 */
	function checkout(){
		# a payment was submitted
		if (!empty($this->data)) :
			$this->_paymentSubmitted($this->data);
		endif;
		
		$this->_checkoutVariables();
	}
	


	function _paymentSubmitted($data) {
		$this->data = $data;
		$total = $this->data['OrderTransaction']['total'];
			
		# if arb is true then will get arb_profile_id for current user
		if($this->data['OrderPayment']['arb'] == 1) {
			$order_transaction_id = $this->OrderTransaction->getArbTransactionId($this->Auth->user('id'));
			
			# if we find order_transaction_id for user then we will update the old transaction  
			if(!empty($order_transaction_id)) {
				$this->data['OrderPayment']['arb_profile_id'] = 
					$this->OrderTransaction->OrderPayment->getArbProfileId($order_transaction_id);
					$this->data['OrderTransaction']['id'] = $order_transaction_id;
			}
		}
			
		if ($this->data['OrderTransaction']['shipping'] == 'on') {
			$this->data['OrderShipment'] = $this->data['OrderPayment'];
		} 
			
		# Charge the card
		$response = $this->_charge($this->data , $total, $this->data['OrderTransaction']['mode']);
		if($response['response_code'] != 1){
			//OrderTransaction failed
			$trdata["OrderTransaction"]["status"] = 'failed';
			// save the billing and shipping details anyway
			$this->OrderTransaction->OrderPayment->save($this->data);
			$this->OrderTransaction->OrderShipment->save($this->data);
			$this->Session->setFlash($response['reason_text'] . ' '.$response['description']);
			$this->redirect(array('plugin' => 'orders', 'controller'=>'order_transactions' , 'action' => 'checkout'));
		} else {
			$this->data['Response'] = $response;
			# setup order transaction data
			$this->data['OrderTransaction']['order_payment_id'] = $response['transaction_id'];
			$this->data['OrderTransaction']['processor_response'] = $response['reason_text'];
			$this->data['OrderTransaction']['total'] = $response['amount'];
			$this->data['OrderTransaction']['status'] = 'paid';
			$this->data['OrderTransaction']['is_arb'] = isset($response['is_arb']) ? $response['is_arb'] : 0;
			$this->data['OrderTransaction']['customer_id'] = $this->Auth->user('id');
			$this->data['OrderTransaction']['assignee_id'] = $this->Auth->user('id');
			if ($this->OrderTransaction->add($this->data)) {
				$msg = __($response['reason_text'] . ' '.$response['description'], true);
			} else {
				$msg = 'Transaction was successful but some error has occured. Please contact Admin with transaction id: '. $response['transaction_id'];
			}
			
			if ($this->Session->check('OrdersCartCount')) {
				$this->Session->delete('OrdersCartCount');
			}
			$this->Session->setFlash($msg);
		
			# send a transaction message to the person ordering
			$message = '<p>Thank you for your order. You can always log in and view your order status here : <a href="'.$_SERVER['HTTP_HOST'].'/orders/order_transactions/view/'.$this->OrderTransaction->id.'">'.$_SERVER['HTTP_HOST'].'/orders/order_transactions/view/'.$this->OrderTransaction->id.'</a></p>';
			$this->__sendMail($this->Session->read('Auth.User.email'), 'Successful Order', $message, $template = 'default');
			
			# this is the redirect for successful transactions
			# if settings given for orders checkout  
			if(defined('__ORDERS_CHECKOUT_REDIRECT')) {
				# extract the settings 
				extract(unserialize(__ORDERS_CHECKOUT_REDIRECT));
				$plugin = pluginize($model);
				$controller = Inflector::tableize($model);
				# get foreign key of OrderItem using given setings
				$foreign_key = $this->OrderTransaction->OrderItem->find('first', 
						array('fields' => $pass, 
							'conditions' => array(
								'OrderItem.order_transaction_id' => $this->OrderTransaction->id,
								)
							));
				$this->redirect(array('plugin' => $plugin, 'controller'=>$controller , 'action'=>$action, 
										!empty($foreign_key['OrderItem']['foreign_key']) ? $foreign_key['OrderItem']['foreign_key'] : '' ));
			} else {
				$this->redirect(array('controller' => 'order_transactions' , 'action' => 'view', $this->OrderTransaction->id));
			}
		}
	}
	
	
	/**
	 * Used to decide whether shipping options are necessary, and if they are which shipping options should be available
	 *
	 * @param {array}	an array of order items to check for shipping options that should be available
	 * @todo 			Move more of the shipping logic into this function from checkout()
	 */
	function _shippingOptions($orderItems = null) {
		if (!empty($orderItems) && defined('__ORDERS_ENABLE_SHIPPING')) {
			# if all items are virtual return null
			foreach ($orderItems as $orderItem) {
				if ($orderItem['OrderItem']['is_virtual'] != 1) {
					$return = true;
					break;
				} else {
					$return  = false;
				}
			}
			if ($return == true && defined('__ORDERS_FEDEX')) {
				$return = unserialize(__ORDERS_FEDEX);
			}
		} else {
			$return = false;
		}
		return $return;
	}


	/**
	 * Where the actual transfer of money is approved or denied.
	 *
	 * @param {data} 	billing information
	 * @param {total} 	the total to try and get approved
	 */	
	function _charge($data , $total, $mode){
		$response = null;
		if (!empty($data)) {
			// Split card expiration date into month and year
			$year =  $data['OrderTransaction']['card_exp_year'];
			$month = $data['OrderTransaction']['card_exp_month'];
			$cNum = $data['OrderTransaction']["card_number"];
	   
			$paymentInfo = array('Member'=> 
                           array( 
                               'first_name'=> $data['OrderPayment']['first_name'], 
                               'last_name'=> $data['OrderPayment']['last_name'], 
                               'billing_address'=> $data['OrderPayment']['street_address_1'], 
                               'billing_address2'=> $data['OrderPayment']['street_address_2'], 
                               'billing_country'=> $data['OrderPayment']['country'], 
                               'billing_city'=> $data['OrderPayment']['city'], 
                               'billing_state'=> $data['OrderPayment']['state'], 
                               'billing_zip'=> $data['OrderPayment']['zip']
                           ), 
                          'CreditCard'=> 
                           array(
                           	   'credit_type' => isset($data['OrderTransaction']['credit_type']) ? $data['OrderTransaction']['credit_type'] : '', 
                               'card_number'=>$cNum, 
                               'expiration_month'=>$month,
                               'expiration_year'=> $year,
                               'cv_code'=>$data['OrderTransaction']['card_sec']
                           ), 
                          'Order'=> 
                          	array('theTotal'=>$total),
                          'Billing'=> $this->data['OrderPayment'],
                          'Shipping'=> $this->data['OrderShipment'],
                          'Meta'=> isset($this->data['Meta']) ? $this->data['Meta'] : null,
                          'Mode'=> $mode , 	
                    );
            // set if this is recurring type or not
            $this->Payments->recurring($data['OrderPayment']['arb']);

			$response = $this->Payments->pay($paymentInfo);
		}

		return $response;
	}
	
	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid OrderTransaction', true), array('action'=>'index'));
		}
		$this->set('orderTransaction', $this->OrderTransaction->find('first',
			array('conditions' => array('OrderTransaction.id' => $id),
				'contain' => array('OrderItem' => array('CatalogItem'=>'CatalogItemBrand'), 'Creator', 'OrderShipment')
		)));
	}

	function add() {
		if (!empty($this->data)) {
			$this->OrderTransaction->create();
			if ($this->OrderTransaction->save($this->data)) {
				$this->flash(__('OrderTransaction saved.', true), array('action'=>'index'));
			} else {
			}
		}
	}

	/** 
	 * 
	 * @todo 	The transaction doesn't actually get edited on this page, only the order item status, and that goes to a different function (OrderItems.change_status()):
	 */
	function edit($id = null) {
		if (!$id) {
			$this->flash(__('Invalid OrderTransaction', true), array('action'=>'index'));
		}
		$this->set('orderTransaction', $this->OrderTransaction->find('first', array(
			'conditions' => array(
				'OrderTransaction.id' => $id
				),
			'contain' => array(
				'OrderItem' => array(
					'CatalogItem' => 'CatalogItemBrand',
					),
				'Creator', 'OrderShipment'
				)
			)
		));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid OrderTransaction', true), array('action'=>'index'));
		}
		if ($this->OrderTransaction->delete($id)) {
			$this->flash(__('OrderTransaction deleted', true), array('action'=>'index'));
		}
	}


	function admin_index($status = null) {
		$this->paginate['conditions'] = !empty($status) ? array('OrderTransaction.status' => $status) : null;
		#$this->OrderTransaction->recursive = 0;
		$this->set('orderTransactions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid OrderTransaction', true), array('action'=>'index'));
		}
		$this->set('orderTransaction', $this->OrderTransaction->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->OrderTransaction->create();
			if ($this->OrderTransaction->save($this->data)) {
				$this->flash(__('OrderTransaction saved.', true), array('action'=>'index'));
			} else {
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid OrderTransaction', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->OrderTransaction->save($this->data)) {
				$this->flash(__('The OrderTransaction has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->OrderTransaction->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid OrderTransaction', true), array('action'=>'index'));
		}
		if ($this->OrderTransaction->delete($id)) {
			$this->flash(__('OrderTransaction deleted', true), array('action'=>'index'));
		}
	}
	
	
	/** 
	 * There was a ton of variables in the checkout() action, so moved them here to help clean up a bit.
	 */
	function _checkoutVariables() {
		# setup ssl variables (note: https rarely works on localhost, so its removed)
		if (defined('__ORDERS_SSL') && !strpos($_SERVER['HTTP_HOST'], 'localhost')) : $this->Ssl->force(); endif;
		$ssl = defined('__ORDERS_SSL') ? unserialize(__ORDERS_SSL) : null;
		$trustLogos = !empty($ssl['trustLogos']) ? $ssl['trustLogos'] : null;
		$this->set(compact('trustLogos'));

		# setup the view variables from here down
		$orderItems = $this->_prepareCartData();
		
		# go to cart if there are no items to checkout with
		if (empty($orderItems[0]['OrderItem'])) :
			$this->Session->setFlash(__('Cart is empty, can\'t checkout.', true));
			$this->redirect(array('plugin' => 'orders', 'controller'=>'order_items' , 'action' => 'cart'));
		endif;
		
		# used to prefill customer billing and shipping data if it exists
		$customer = $this->OrderTransaction->Customer->find('first', 
			array('conditions' => array('Customer.id' => $this->Auth->user('id'))));
		$this->data['OrderTransaction'] = $customer['Customer'];
		$shippingOptions = $this->_shippingOptions($orderItems);
		
		# please clean this up by moving it to separate functions, or to the model.  Its a mess
		$shippingAddress = $this->OrderTransaction->OrderShipment->find('first', array(
			'conditions' => array(
				'OrderShipment.user_id' => $this->Auth->user('id'),
				// 'OrderShipment.order_transaction_id' => null,  // not sure why this matters - RK?
				),
			'order' => array(
				'OrderShipment.modified',
				),
			));
		
		$billingAddress = $this->OrderTransaction->OrderPayment->find('first', array(
			'conditions' => array('OrderPayment.user_id' => $this->Auth->user('id'),
				// 'OrderPayment.order_transaction_id' => null,  // not sure why this matters - RK?
				),
			'order' => array(
				'OrderPayment.modified',
				),
			));
		
		# see if all items are virtual
		foreach ($orderItems as $orderItem) : 
			$allVirtual = $orderItem['OrderItem']['is_virtual'];
			if ($allVirtual != 1) :
				break;
			endif;
		endforeach;
		
		# constants for per site options
   		$enableShipping = defined('__ORDERS_ENABLE_SHIPPING') ? __ORDERS_ENABLE_SHIPPING : false;
		$fedexSettings = defined('__ORDERS_FEDEX') ? unserialize(__ORDERS_FEDEX) : null;
		$paymentMode = defined('__ORDERS_DEFAULT_PAYMENT') ? __ORDERS_DEFAULT_PAYMENT : null;
		$paymentOptions = defined('__ORDERS_ENABLE_PAYMENT_OPTIONS') ? unserialize(__ORDERS_ENABLE_PAYMENT_OPTIONS) : null;
		$defaultShippingCharge = defined('__ORDERS_FLAT_SHIPPING_RATE') ? __ORDERS_FLAT_SHIPPING_RATE : 0;
		
		# set the variables
		$this->set(compact('orderItems', 'shippingOptions', 'defaultShippingCharge', 'shippingAddress', 'billingAddress', 'allVirtual', 'enableShipping', 'fedexSettings', 'paymentMode', 'paymentOptions'));
		$this->set('isArb', 0);
	
		# form field values
		$this->data['OrderTransaction']['order_charge'] = $orderItems[0]['total_price'] ;
		$this->data['OrderTransaction']['quantity'] = $orderItems[0]['total_quantity'] ;
		$this->data['OrderPayment'] = $billingAddress['OrderPayment'];
		$this->data['OrderShipment'] = $shippingAddress['OrderShipment'];
		$this->data['OrderPayment']['first_name'] = !empty($this->data['OrderTransaction']['first_name']) ? $this->data['OrderTransaction']['first_name'] : $this->Session->read('Auth.User.first_name');
		$this->data['OrderPayment']['last_name'] = !empty($this->data['OrderTransaction']['last_name']) ? $this->data['OrderTransaction']['last_name'] :  $this->Session->read('Auth.User.last_name');
		
	}

}
?>