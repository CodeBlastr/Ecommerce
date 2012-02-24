<?php
App::uses('OrdersAppController', 'Orders.Controller');
/**
 * OrderItems Controller
 *
 * @property OrderItem $Order
 */
class OrderItemsController extends OrdersAppController {

	public $name = 'OrderItems';
	public $uses = 'Orders.OrderItem';
	public $allowedActions = array('delete');
	public $shippedStatus = 'shipped';
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		if (defined('__ORDERS_STATUSES')) {
			$orderStatuses = unserialize(__ORDERS_STATUSES);
			$this->shippedStatus = !empty($orderStatuses['shipped']) ? $orderStatuses['shipped'] : $this->shippedStatus;
		}
	}

/**
 * Index method
 * 
 * @param null
 * @return null
 */
	public function index() {
		$this->OrderItem->recursive = 0;
		$this->set('orderItems', $this->paginate());
		$this->set('statuses', $this->OrderItem->statuses());
	}

/**
 * View method
 *
 * @param uuid
 * @return null
 */ 
	public function view($id = null) {
		$this->OrderItem->id = $id;
		if (!$this->OrderItem->exists()) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$this->OrderItem->contain('OrderPayment', 'OrderShipment');
		$this->set('orderItem', $this->OrderItem->read(null, $id));
	}


/**
 * Add method (cart)
 *
 * @param null
 * @return void
 */
  	public function add($catalogItemId = null) {
		$userId = $this->Session->read('Auth.User.id');
		# redirect to cart if not coming from the cart page (go to check out if you are coming from the cart page)
		$redirect = !empty($this->request->data['OrderItem'][0]) ? array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'checkout') : array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'cart'); 
		
		# temporary for this to redo $redirect, until guest cart checkout is implemented
		$redirect = $this->_linkToCheckout($catalogItemId, $redirect); 
		
		$this->_checkCartCompatibility($this->request->data);
		if (!empty($userId)) {
			$ret = $this->OrderItem->addToCart($this->request->data, $userId);
			if ($ret['state']) {
				$cart_count = $this->OrderItem->prepareCartData($this->Session->read('Auth.User.id'), $this->userRoleId);
				$cart_count = $cart_count[0]['total_quantity'];
				if ($this->Session->check('OrdersCartCount')) {
					$this->Session->delete('OrdersCartCount');
				}
		  		$this->Session->write('OrdersCartCount', $cart_count);
		  		$this->Session->setFlash($ret['msg']);
		  		$this->redirect($redirect);
			} else {
				$this->Session->setFlash(__($ret['msg'], true));
			}
		} else {
			$this->_addToCookieCart($this->request->data);
	  		$this->redirect($redirect);
		}
	}
	
	
/**
 * Add to cart with one click (no form input needed)
 * 
 * @param string
 */
	protected function _linkToCheckout($catalogItemId = null, $redirect) {
		if (empty($this->request->data) && !empty($catalogItemId)) {
			$catalogItem = $this->OrderItem->CatalogItem->find('first', array('conditions' => array('CatalogItem.id' => $catalogItemId)));
			if (!empty($catalogItem)) {
				$this->request->data['OrderItem']['quantity'] = 1;
				$this->request->data['OrderItem']['parent_id'] = $catalogItem['CatalogItem']['id'];
				$this->request->data['OrderItem']['catalog_item_id'] = $catalogItem['CatalogItem']['id'];
				$this->request->data['OrderItem']['price'] = $catalogItem['CatalogItem']['price'];
				$this->request->data['OrderItem']['payment_type'] = $catalogItem['CatalogItem']['payment_type'];
				# temporary for this to redo $redirect, until guest cart checkout is implemente	
				return array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'checkout');
			}
		}
		return $redirect;
	}
 

/**
 * Edit method
 *
 * @param uuid
 * @return void
 */
	public function edit($id = null) {
		$this->OrderItem->id = $id;
		if (!$this->OrderItem->exists()) {
			throw new NotFoundException(__('Invalid order coupon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		} else {
			$orderItem = $this->OrderItem->read(null, $id);
			$this->request->data = $orderItem;
			$viewLink = !empty($orderItem['OrderItem']['model']) && !empty($orderItem['OrderItem']['model']) ? array('plugin' => ZuhaInflector::pluginize($orderItem['OrderItem']['model']), 'controller' => Inflector::tableize($orderItem['OrderItem']['model']), 'action' => 'view',  $orderItem['OrderItem']['id']) : null;
			$this->set(compact('viewLink'));
		}
		# _viewVars
		$this->set('statuses', $this->OrderItem->statuses());
	}
	
/**
 * Check the compatibility of cart items.
 *
 * @params {array} 
 */
	protected function _checkCartCompatibility($orderItem = null){
		if(!empty($orderItem['OrderItem']['payment_type'])) :
			if($this->Session->check('OrderPaymentType')) :
				$paymentTypes = $this->Session->read('OrderPaymentType');
				$newPaymentTypes = explode(',', $orderItem['OrderItem']['payment_type']);
				$commonPaymentType = array_intersect($paymentTypes, $newPaymentTypes);
				if(!empty($commonPaymentType)) :
					$this->Session->write('OrderPaymentType', $commonPaymentType);
				else :
					$this->Session->setFlash('The item you have added to cart is incompatible with at least one of your current cart items.  Please checkout with existing cart items first.');
		  			$this->redirect(array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'checkout'));
				endif;
			else :
				$this->Session->write('OrderPaymentType', explode(',', $orderItem['OrderItem']['payment_type']));	 
			endif;
		endif;	
	}

/**
 * Edits the cart compatibility session
 * Write the common payment type in session
 *
 * @params 
 */
	protected function _updateCartCompatibility(){
		$userId = $this->Session->read('Auth.User.id');
		if (!empty($userId)) {
			$orderItems = $this->OrderItem->find('all', array('conditions' => array('OrderItem.customer_id' => $userId)));
			if (!empty($orderItems)) {
				$paymentTypes = Set::extract('/OrderItem/payment_type', $orderItems);
				$this->Session->write('OrderPaymentType', $paymentTypes);
			} else {
				$this->Session->delete('OrderPaymentType');
			}
		}
	}
	
/**
 * View Cart 
 * @param {int} user_id
 */
	public function cart(){
		//get Items in Cart
		//Configure::write('debug' , 0);
		$orderItems = $this->_prepareCartData();
		#$dat = $this->OrderItem->prepareCartData($this->Auth->user("id"));
		$this->set('data' , $orderItems);
		$isCookieCart = $this->Cookie->read('cookieCart');
		$this->set('isCookieCart', $isCookieCart);
	}


/** 
 * Deletes Items From Cart
 * 
 * @param {mixed} 	The id of the Order Item or X if it is a guest cart item
 * @param {int}		The array integer index of the guest cart item
 */
	public function delete($id, $index = null) {
		if ($id == 'X') {
			# X means it is a guest cart item
			#$cartCount = $this->Cookie->read('OrdersCartCount');
			$this->Cookie->delete("cookieCart");
			$this->Session->delete('OrderPaymentType');
			#$cartItem = $this->Cookie->read('cookieCart.'.$index);
			#$cartQuantity = $this->Cookie->read('GuestCart.'.$index.'.OrderItem.quantity');
			#$cartCount = $cartCount - $cartQuantity;
			#$this->Cookie->delete('GuestCart.'.$index);
		} else {
			$this->OrderItem->delete($id);
			$this->_updateCartCompatibility();	
		}
		$this->redirect(array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'cart'));
	}
	
	
/**
 * Sets the variables for updating the status of an order item.
 * @todo 	These status fields need to be updated to use "enumerations".  Enumerations are what allow us to have different labels in multi-sites.  One site might call a completed transaction, "Shipped", the other might call it, "Completed".  We have to use enumerations for all drop downs for this reason.  (just set the enumeration to is_system, if its id number is hard coded anywhere, and then we'll make sure its included with the install of zuha.)
 * @todo	When all order items are sent, we should have a status for the order_transaction of "shipped".  But it really should be in the model not specifically here.
 */
	public function change_status() {
		if(!empty($this->request->data['OrderItem'])) {
			# if all items are sent then set status of the whole transaction to shipped
			$statuses = Set::extract('/status', $this->request->data['OrderItem']);
			foreach ($statuses as $status) : 
				if ($status != 'sent') :
					#unset($this->request->data['OrderTransaction']['status']);
					break;
				else : 
					$this->request->data['OrderTransaction']['status'] = $this->shippedStatus;
				endif;
			endforeach; 
			
			if ($this->OrderItem->OrderTransaction->saveAll($this->request->data)) : 
				$this->Session->setFlash(__('Order updated', true));
			else :
				$this->Session->setFlash(__('Order could not be updated', true));
			endif;
		}
		$this->redirect($this->referer());
	}
}
?>