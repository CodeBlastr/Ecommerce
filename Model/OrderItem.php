<?php
App::uses('OrdersAppModel', 'Orders.Model');
/**
 * OrderItem Item Model
 *
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
 * @subpackage    zuha.app.plugins.catalogs.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class OrderItem extends OrdersAppModel {

	var $name = 'OrderItem'; 

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $belongsTo = array(
		'CatalogItem'=>array(
			'className'=>'Catalogs.CatalogItem',
			'foreignKey'=>'catalog_item_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
		'User'=>array(
			'className'=>'User',
			'foreignKey'=>'customer_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
		'OrderPayment'=>array(
			'className'=>'Orders.OrderPayment',
			'foreignKey'=>'order_payment_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
		'OrderShipment'=>array(
			'className'=>'Orders.OrderShipment',
			'foreignKey'=>'order_shipment_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
		'OrderTransaction'=>array(
			'className'=>'OrderTransaction',
			'foreignKey'=>'order_transaction_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
	);	
	
	/* If we want to remove expired items do them here!!!
	function beforeFind() {
		# remove items from cart if they're expired
		$i = 0;
		foreach ($orderItems as $orderItem) {
			if ((!empty($orderItem['CatalogItem']['end_date']) && $orderItem['CatalogItem']['end_date'] > '0000-00-00 00:00:00') && $orderItem['CatalogItem']['end_date'] < date('Y-m-d H:i:s')) {
				unset($orderItems[$i]);
				$this->delete($orderItem['OrderItem']['id']);
			}
			$i++;
		}
	} */
	
	
	/**
	 * Stock control function Determines quantity of products in stock.
	 * @param {int} product -> The id of the product. 
	 * @return {int}
	 */	
	
	function stockControl($product){
		$data = $this->CatalogItem->find('first' , array(
			'conditions'=>array(
				'CatalogItem.id'=>$product
				),
			'contain' => array()
		));
		
		if($data['CatalogItem']['stock_item'] > 0 || $data['CatalogItem']['stock_item'] === 0) :
			return $data['CatalogItem']['stock_item'];
		else :
			return null;
		endif;
	}
	
	
	
	function createOrderItemFromCatalogItem($data, $userId = null) {
		# find the related catalog item
		$catalogItem = $this->CatalogItem->find('first' , array(
			'conditions'=>array(
				'CatalogItem.id' => $data['OrderItem']['catalog_item_id'],
				),
			));
		# set up the default values from the db catalog item
		$defaults['OrderItem']['status'] = 'incart';
		//$defaults['OrderItem']['parent_id'] = $catalogItem['CatalogItem']['id'];
		$defaults['OrderItem']['price'] = formatPrice($catalogItem['CatalogItem']['price']);
		$defaults['OrderItem']['name'] = $catalogItem['CatalogItem']['name'];
		$defaults['OrderItem']['length'] = $catalogItem['CatalogItem']['length'];;
		$defaults['OrderItem']['width'] = $catalogItem['CatalogItem']['width'];
		$defaults['OrderItem']['height'] = $catalogItem['CatalogItem']['height'];
		$defaults['OrderItem']['weight'] = $catalogItem['CatalogItem']['weight'];
		$defaults['OrderItem']['customer_id'] = !empty($userId) ? $userId : null;
		$defaults['OrderItem']['arb_settings'] = $catalogItem['CatalogItem']['arb_settings'];
		$defaults['OrderItem']['payment_type'] = $catalogItem['CatalogItem']['payment_type'];
		$defaults['OrderItem']['is_virtual'] = $catalogItem['CatalogItem']['is_virtual'];
		$defaults['OrderItem']['model'] = !empty($catalogItem['CatalogItem']['model']) ? $catalogItem['CatalogItem']['model'] : 'Catalog';
		$defaults['OrderItem']['foreign_key'] = !empty($catalogItem['CatalogItem']['foreign_key']) ? $catalogItem['CatalogItem']['foreign_key'] : $catalogItem['CatalogItem']['id'];
		# merge the defaults with the submitted data
		return Set::merge($defaults, $data);
	}
	
	
	
	/*
	 * Prepare cart data for items. As sum.
	 * @param {int} $user -> The id of the customer 
	 * @return {array} 
	 */
	function prepareCartData($userId = null, $userRoleId = null){
		# Get Orders by specified User
		$orderItems = $this->find('all', array(
			'conditions'=>array(
				'OrderItem.customer_id' => $userId,
				'OrderItem.status'=>'incart'
				),
			'fields' => array( // if you change these fields, make sure that it doesn't interfere with de-duplication
				'OrderItem.id',
				'OrderItem.status',
				'OrderItem.price',
				'OrderItem.quantity',
				'OrderItem.name',
				'OrderItem.length',
				'OrderItem.width',
				'OrderItem.height',
				'OrderItem.weight',
				'OrderItem.catalog_item_id',
				'OrderItem.customer_id',
				'OrderItem.arb_settings',
				'OrderItem.payment_type',
				'OrderItem.model',
				'OrderItem.foreign_key',
				'OrderItem.is_virtual',
				),
			'contain' => array(
				'CatalogItem' => array(
					'fields' => array(
						'CatalogItem.weight',
						'CatalogItem.length',
						'CatalogItem.height',
						'CatalogItem.width',
						'CatalogItem.name',
						'CatalogItem.model',
						'CatalogItem.foreign_key',
						),
					),
				),
			'order'=>array('OrderItem.price')
			));
		
		$possibleDeleteIds = Set::extract('/OrderItem/id', $orderItems);
				
		# clear Order Items
		$cartData = $this->cartExtras($orderItems);
		
		$saveIds = Set::extract('/OrderItem/id', $cartData);
		
		$this->deleteAll(array('OrderItem.id' => array_diff($possibleDeleteIds, $saveIds)));
		
		if(!empty($saveIds)) { $this->saveAll($cartData); }
				
		# remove orderItems 
		return $cartData;
	}
	
	
	function cartExtras($orderItems = null) {
		$orderItems = $this->mergeCartDuplicates($orderItems);
		$price = '';
		$quantity = '';
		$i = 0;
		if (!empty($orderItems)) : foreach ($orderItems as $orderItem) :
			$price += $orderItem['OrderItem']['price'] * $orderItem['OrderItem']['quantity'];
			$quantity += $orderItem['OrderItem']['quantity'];
			$i++;
		endforeach; endif;
		$orderItems[0]["total_price"] = $price;
		$orderItems[0]["total_quantity"] = $quantity;
		return $orderItems;
	}
	
	
	/** 
	 * Reduce the orderItems to one instance per orderItem with an updated quantity.
	 * 
	 * @array		An array of many orderItems
	 */
	function mergeCartDuplicates($orderItems = null) {		
		if (!empty($orderItems)) :
			foreach($orderItems as $OrderItem) :
				if(!isset($mergedOrderItems[$OrderItem['OrderItem']['catalog_item_id']])) :
					$mergedOrderItems[$OrderItem['OrderItem']['catalog_item_id']] = $OrderItem;
				else : 
					$mergedOrderItems[$OrderItem['OrderItem']['catalog_item_id']]['OrderItem']['quantity'] += $OrderItem['OrderItem']['quantity'];
				endif;
			endforeach;
			// reset the array keys to 0, 1, 2, etc..
			return array_values($mergedOrderItems);
		else :
			return null;
		endif;		
	}


	/*
	 * Add Item to cart -> Add the item to cart(order) depending on 
	 * @param {int} id -> The id of the order.
	 * @return {void}
	 * @todo 		This needs to be updated to use "throw, catch" syntax.
	 * @todo		The work regarding price needs to go into its own re-usable function.
	 * @todo		We need to add a configuration for how we handle guests adding things to cart.  Right now it doesnt' work at all. 
	 */	
	function addToCart($data, $userId = null){
		# there are multiple itesm to add at once
		if (!empty($data['OrderItem'][0])) :
			if ($this->addAllToCart($data, $userId)) :
				$return = array('state' => true, 'msg' => 'Quantities updated.');
			else :
				$return = array('state' => false, 'msg' => 'Error updating quantities.');
			endif;
			return $return;
		else :
			
			$return = array('state' => false, 'msg' => 'Item can not be added to Cart');
			
			# update the total price for this order item record 
			$data['OrderItem']['id']  = null; // removes X from cookieCart orderItems
			$data['OrderItem']['parent_id']  = null; // gets rid of a value used in the view only
			$data['OrderItem']['customer_id']  = $userId;
			$data = $this->createOrderItemFromCatalogItem($data, $userId);
			
			if($this->stockControl($data['OrderItem']['catalog_item_id']) !== 0){
				if ($this->save($data)) {
					$return = array('state' => true, 'msg' => 'Item was added to cart.');
				} else {
					$return = array('state' => false, 'msg' => 'Item was not added to cart.');
				}
			} else {
				$return['msg'] = 'Sorry, this item is out of stock';
			}
			return $return;
		endif;
	}
	
	
	function addAllToCart($data, $userId = null) {
		if (!empty($userId)) :
			#the incoming data has many order items instead of one.
			#reset the cart, because this data should contain all order items if we're submitting many
			$orderItemIds = Set::extract('/id', $data['OrderItem']);
			if ($this->deleteAll(array("{$this->alias}.id" => $orderItemIds))) :
				foreach ($data['OrderItem'] as $orderItem) :
					if ($orderItem['quantity'] > 0 && $this->addToCart(array('OrderItem' => $orderItem), $userId)) : 
						$return = array('state' => true, 'msg' => 'All items added to cart.');
					elseif ($orderItem['quantity'] <= 0) : 
						#ignore it (ie. don't re-add it)
					else :
						throw new Exception('Error adding at least one item to cart.');
					endif;
				endforeach;
			else :
				throw new Exception('Error resetting cart.');
			endif;			
		else :
			throw new Exception('Cannot change quantity without a user id.');
		endif;
		return $return;
	}
	
	
	/*
	 * add() function is similar to addToCart() function 
	 * this function does not have guestcart code. This function is used to add item in order_items
	 */
	function add($data, $userRoleId = null){
		//Set the data		
		$catalogItem = $this->CatalogItem->find('first' , array(
			'conditions'=>array(
				'CatalogItem.id' => $data['OrderItem']['catalog_item_id'],
				),
			));
		
		//Set Price 
		$data['OrderItem']['price']  = $data['OrderItem']['quantity'] * $catalogItem['CatalogItem']['price'];
		//save 
		if($catalogItem['CatalogItem']['stock'] == 0){
			if ($this->save($data)) {
				return true;
			} 	
		} else {
			if($this->OrderItem->stockControl($catalogItem)){
				if ($this->	save($data)) {
					return true;
				}
			} else {
				return false;
			}
		}
	}
	
	
	/**
	 * Looks up order items for a transaction (during checkout) and sets the status to paid for all of them.
	 *
	 * @param {array}		Data array
	 */
	function pay($data) {
		$return = false;	
		$ordItems = $this->find('all', array(
			'conditions'=>array(
				'OrderItem.customer_id' => $data['OrderTransaction']['customer_id'],
				'OrderItem.status' => 'incart'
				)
			));
		if(!empty($ordItems)) :
			foreach ($ordItems as $ordItem) {
				# this converts data in find(all) format to saveAll format, and updates the values
				$orderItem['OrderItem'] = $ordItem['OrderItem'];
				$orderItem['OrderItem']['status'] = 'paid';
				$orderItem['OrderItem']['order_transaction_id'] = $data['OrderTransaction']['id'];
				$orderItem['OrderItem']['order_shipment_id'] = $data['OrderTransaction']['order_shipment_id'];
				$orderItem['OrderItem']['order_payment_id'] = $data['OrderTransaction']['order_payment_id'];
	
				if(isset($orderItem['OrderItem']['catalog_item_id'])) {
					$data = $this->CatalogItem->find('first' , array(
							'conditions'=>array(
								'CatalogItem.id'=>$orderItem['OrderItem']['catalog_item_id'] 
							)
						));
					
					$orderItem['CatalogItem'] = $data['CatalogItem']; 	
					$orderItem['CatalogItem']['stock_item'] -= $orderItem['OrderItem']['quantity'] ;
				}
				
				if ($this->saveAll($orderItem)) {
					$return = true;
				} else {
					$return = false;
					break;
				}
			}
		endif;

		return $return;
	}
	
	
	
}
?>