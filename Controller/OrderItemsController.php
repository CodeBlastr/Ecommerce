<?php
class OrderItemsController extends OrdersAppController {

	public $name = 'OrderItems';
	public $uses = 'Orders.OrderItem';
	public $allowedActions = array('delete');


	function index($status = null) {
		#$this->OrderItem->recursive = 0;
		$this->set('orderItems', $this->paginate());
	}


	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid order item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->OrderItem->contain('OrderPayment', 'OrderShipment');
		$this->set('orderItem', $this->OrderItem->read(null, $id));
	}


	/**
	 * Ordering an item function. Add to cart is handled here too. 
	 * Redirects back to CatalogItem
	 * @return NULL
	 * @todo	Most of this needs to go into the model, and be converted to "throw, catch" syntax.
	 * @todo	We may be able to add things besides catalog items to cart, so this will need to be updated to allow that.  (it will be a model/foreignKey type of format).
	 */
  	function add() {
		$userId = $this->Session->read('Auth.User.id');
		# if there are multiple items then we will go to the checkout page, instead of the cart view page
		$redirect = !empty($this->request->data['OrderItem'][0]) ? array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'checkout') : array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'cart'); 

		$this->check_payment_type($this->request->data);
		if (!empty($userId)) :
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
		else :
			$this->_addToCookieCart($this->request->data);
	  		$this->redirect($redirect);
		endif;
	}
	
	/*
	 * Check Payment Type
	 * @params $this->request->data
	 * write the common payment type in session
	 */
	function check_payment_type($orderItem = null){
		if(!empty($orderItem['OrderItem']['payment_type'])) :
			if($this->Session->check('OrderPaymentType')) :
				$paymentTypes = $this->Session->read('OrderPaymentType');
				$newPaymentTypes = explode(',', $orderItem['OrderItem']['payment_type']);
				$commonPaymentType = array_intersect($paymentTypes, $newPaymentTypes);
				if(!empty($commonPaymentType)) :
					$this->Session->write('OrderPaymentType', $commonPaymentType);
				else :
					$this->Session->setFlash('Please checkout with existing cart items.');
		  			$this->redirect(array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'checkout'));
				endif;
			else :
				$this->Session->write('OrderPaymentType', explode(',', $orderItem['OrderItem']['payment_type']));	 
			endif;
		endif;	
	}
	
	/**
	 * View Cart 
	 * @param {int} user_id
	 */
	function cart(){
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
	function delete($id, $index = null) {
		if ($id == 'X') {
			# X means it is a guest cart item
			#$cartCount = $this->Cookie->read('OrdersCartCount');
			$this->Cookie->delete("cookieCart");
			#$cartItem = $this->Cookie->read('cookieCart.'.$index);
			#$cartQuantity = $this->Cookie->read('GuestCart.'.$index.'.OrderItem.quantity');
			#$cartCount = $cartCount - $cartQuantity;
			#$this->Cookie->delete('GuestCart.'.$index);
		} else {
			$this->OrderItem->delete($id);			
		}
		$this->redirect(array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'cart'));
	}
	
	
	
	function admin_index($status = null) {
		$this->paginate['conditions'] = !empty($status) ? array('OrderItem.status' => $status) : null;
		#$this->OrderItem->recursive = 0;
		$this->set('orderItems', $this->paginate());
	}


	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid order item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('orderItem', $this->OrderItem->read(null, $id));
	}


	function admin_add() {
		if (!empty($this->request->data)) {
			$this->OrderItem->create();
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.', true));
			}
		}
		$creators = $this->OrderItem->Creator->find('list');
		$modifiers = $this->OrderItem->Modifier->find('list');
		$this->set(compact('creators', 'modifiers'));
	}


	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid order item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->OrderItem->read(null, $id);
		}
		$creators = $this->OrderItem->Creator->find('list');
		$modifiers = $this->OrderItem->Modifier->find('list');
		$this->set(compact('creators', 'modifiers'));
	}


	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for order item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->OrderItem->delete($id)) {
			$this->Session->setFlash(__('Order item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Order item was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	/**
	 * Sets the variables for updating the status of an order item.
	 * @todo 	These status fields need to be updated to use "enumerations".  Enumerations are what allow us to have different labels in multi-sites.  One site might call a completed transaction, "Shipped", the other might call it, "Completed".  We have to use enumerations for all drop downs for this reason.  (just set the enumeration to is_system, if its id number is hard coded anywhere, and then we'll make sure its included with the install of zuha.)
	 * @todo	When all order items are sent, we should have a status for the order_transaction of "shipped".  But it really should be in the model not specifically here.
	 */
	function change_status() {
		if(!empty($this->request->data['OrderItem'])) {
			# if all items are sent then set status of the whole transaction to shipped
			$statuses = Set::extract('/status', $this->request->data['OrderItem']);
			foreach ($statuses as $status) : 
				if ($status != 'sent') :
					unset($this->request->data['OrderTransaction']['status']);
					break;
				else : 
					$this->request->data['OrderTransaction']['status'] = 'shipped';
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