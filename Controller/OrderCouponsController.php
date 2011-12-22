<?php
App::uses('OrdersAppController', 'Orders.Controller');
/**
 * OrderCoupons Controller
 *
 * @property OrderCoupon $OrderCoupon
 */
class OrderCouponsController extends OrdersAppController {
	
	public $name = 'OrderCoupons';
	public $uses = 'Orders.OrderCoupon';


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('orderCoupons', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->OrderCoupon->id = $id;
		if (!$this->OrderCoupon->exists()) {
			throw new NotFoundException(__('Invalid order coupon'));
		}
		$this->set('orderCoupon', $this->OrderCoupon->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderCoupon->create();
			if ($this->OrderCoupon->save($this->request->data)) {
				$this->Session->setFlash(__('The order coupon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order coupon could not be saved. Please, try again.'));
			}
		}
		$this->set('discountTypes', $this->OrderCoupon->types());
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->OrderCoupon->id = $id;
		if (!$this->OrderCoupon->exists()) {
			throw new NotFoundException(__('Invalid order coupon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderCoupon->save($this->request->data)) {
				$this->Session->setFlash(__('The order coupon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order coupon could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->OrderCoupon->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->OrderCoupon->id = $id;
		if (!$this->OrderCoupon->exists()) {
			throw new NotFoundException(__('Invalid order coupon'));
		}
		if ($this->OrderCoupon->delete()) {
			$this->Session->setFlash(__('Order coupon deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Order coupon was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function verify() {
		// currently used at orders/order_transactions/checkout only
		$this->request->data = $this->OrderCoupon->verify($this->request->data);
		$this->set('data', $this->request->data);
	}
	
}
