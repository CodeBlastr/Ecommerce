<?php
App::uses('OrdersAppModel', 'Orders.Model');
/**
 * OrderCoupon Model
 *
 * @property OrderTransaction $OrderTransaction
 */
class OrderCoupon extends OrdersAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'is_active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'OrderTransaction' => array(
			'className' => 'OrderTransaction',
			'foreignKey' => 'order_coupon_id',
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
	
	
	public function verify($data, $conditions = null) {
		# similar to apply but don't mark as used
		if (!empty($data['OrderCoupon']['code'])) {
			$condtions = Set::merge(array('OrderCoupon.code' => $data['OrderCoupon']['code']), $conditions);
			$coupon = $this->find('first', array('conditions' => $condtions));
			
			if (empty($coupon)) {
				throw new Exception('Code out of date or does not apply.');
			} else {
				$data = $this->_applyPriceChange(
					$coupon['OrderCoupon']['discount_type'], 
					$coupon['OrderCoupon']['discount'], 
					$data);
				$data['OrderCoupon'] = $coupon['OrderCoupon'];
				return $data;
			}
		} else {
			throw new Exception('Coupon code was empty.');
		}
	}
	
	private function _applyPriceChange($type = 'fixed', $discount = 0, $data = null) {
		if ($type == 'percent') {
			# for now it does the total 
			$data['OrderTransaction']['order_charge'] = formatPrice(((100 - $discount) / 100) * $data['OrderTransaction']['order_charge']);
		} else {
			# do fixed coupon price change 
			$data['OrderTransaction']['order_charge'] = formatPrice($data['OrderTransaction']['order_charge'] - $discount);
		}
		
		return $data;		
	}
	
	public function apply($data) {
		# find the coupon (make sure it can be applied)
		try {
			$data = $this->verify($data);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}		
		
		# make the coupon as used 
		$coupon['OrderCoupon']['id'] = $data['OrderCoupon']['id'];
		$coupon['OrderCoupon']['uses'] = $data['OrderCoupon']['uses'] + 1;
		$this->validate = false;
		if ($this->save($coupon)) {
			return !empty($data['OrderTransaction']['total']) ? $data['OrderTransaction']['total'] : $data['OrderTransaction']['order_charge'];
		} else {
			throw new Exception('Code apply failed.');
		}
	}
	
	
	public function types() {
		return array(
			'fixed' => 'Fixed discount for cart total.',
			'percent' => 'Percent discount for cart total.',
			);
	}

}
