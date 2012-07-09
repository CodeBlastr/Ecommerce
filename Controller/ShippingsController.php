<?php
class ShippingsController extends AppController {

	var $name = 'Shippings';
	var $components = array('Shipping');
	var $uses = array();
	
	/*
	 * getShippingRate function 
	 */
	function getShippingCharge(){
			$this->autoRender = false;
			if(Configure::read('debug')) {
				Configure::write('debug', 0);
			}

			$options_req_shipment1 =  defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT) : '' ;
					
			$options_req_shipment2 = array(
					'ServiceType' => isset($this->request->data['OrderTransaction']['shippingType']) ? $this->request->data['OrderTransaction']['shippingType'] : '' ,
					'TotalInsuredValue' => array('Ammount'=>100,'Currency'=>'USD') ,
					'Shipper' => defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER) : '',
					
					'Recipient' => array(
								'Address' => array(
								'StreetLines' => array('Address Line 1'),
								'City' => 'Richmond',
								'StateOrProvinceCode' => isset($this->request->data['OrderShipment']['state']) ? $this->request->data['OrderShipment']['state'] : '' ,
								'PostalCode' => isset($this->request->data['OrderShipment']['zip']) ? $this->request->data['OrderShipment']['zip'] : '' ,
								'CountryCode' => isset($this->request->data['OrderShipment']['country']) ? $this->request->data['OrderShipment']['country'] : '' ,
								'Residential' => false)
							),
					'ShippingChargesPayment' => array('PaymentType' => 'SENDER'),
					'RateRequestTypes' => 'ACCOUNT', 
					'RateRequestTypes' => 'LIST', 
					'PackageCount' => isset($this->request->data['OrderTransaction']['quantity']) ? $this->request->data['OrderTransaction']['quantity'] : '' ,
					'PackageDetail' =>		'INDIVIDUAL_PACKAGES',
					'RequestedPackageLineItems' => array('0' => array('Weight' => array('Value' => isset($this->request->data['OrderTransaction']['weight']) ? 
							(empty($this->request->data['OrderTransaction']['weight']) ? __ORDERS_SHIPPING_FEDEX_DEFAULT_WEIGHT : $this->request->data['OrderTransaction']['weight']) : '' ,
																		'Units' => defined('__ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT') ? __ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT : ''
																		),
																		'Dimensions' => array(
																			'Length' => isset($this->request->data['OrderTransaction']['length']) ? $this->request->data['OrderTransaction']['length'] : '' ,
																			'Width' => isset($this->request->data['OrderTransaction']['width']) ? $this->request->data['OrderTransaction']['width'] : '' ,
																			'Height' => isset($this->request->data['OrderTransaction']['height']) ? $this->request->data['OrderTransaction']['height'] : '' ,
																			'Units' => defined('__ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT') ? __ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT : ''
																		)),
												 		)
					);
			
			$options_req_shipment = array_merge((array)$options_req_shipment2, (array)$options_req_shipment1);															
			
			$options = array(
					'WebAuthenticationDetail' => defined('__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL') ? unserialize(__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL) : '',
					'ClientDetail' => defined('__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL') ? unserialize(__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL) : '',
					'TransactionDetail' => array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***'),
					'Version' => defined('__ORDERS_SHIPPING_FEDEX_VERSION') ? unserialize(__ORDERS_SHIPPING_FEDEX_VERSION) : '',
					'ReturnTransitAndCommit' => true,
					'RequestedShipment' => $options_req_shipment,
				);
			$data = $this->Shipping->getRate($options);
			
			//@todo 		Get rid of the json_encode() thing, you only need to put .json on the url
			echo json_encode($data);
			
	}
	
	
	// for getting in form of array intead of json
	function getShippingCharge_array(){
			$this->autoRender = false;
			
			$options_req_shipment1 =  defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT) : '' ;
					
			$options_req_shipment2 = array(
					'ServiceType' => isset($this->request->data['OrderTransaction']['shippingType']) ? $this->request->data['OrderTransaction']['shippingType'] : '' ,
					'TotalInsuredValue' => array('Ammount'=>100,'Currency'=>'USD') ,
					'Shipper' => defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER) : '',
					
					'Recipient' => array(
								'Address' => array(
								'StreetLines' => array('Address Line 1'),
								'City' => 'Richmond',
								'StateOrProvinceCode' => isset($this->request->data['OrderShipment']['state']) ? $this->request->data['OrderShipment']['state'] : '' ,
								'PostalCode' => isset($this->request->data['OrderShipment']['zip']) ? $this->request->data['OrderShipment']['zip'] : '' ,
								'CountryCode' => isset($this->request->data['OrderShipment']['country']) ? $this->request->data['OrderShipment']['country'] : '' ,
								'Residential' => false)
							),
					'ShippingChargesPayment' => array('PaymentType' => 'SENDER'),
					'RateRequestTypes' => 'ACCOUNT', 
					'RateRequestTypes' => 'LIST', 
					'PackageCount' => isset($this->request->data['OrderTransaction']['quantity']) ? $this->request->data['OrderTransaction']['quantity'] : '' ,
					'PackageDetail' =>		'INDIVIDUAL_PACKAGES',
					'RequestedPackageLineItems' => array('0' => array('Weight' => array('Value' => isset($this->request->data['OrderTransaction']['weight']) ? 
							(empty($this->request->data['OrderTransaction']['weight']) ? __ORDERS_SHIPPING_FEDEX_DEFAULT_WEIGHT : $this->request->data['OrderTransaction']['weight']) : '' ,
																		'Units' => defined('__ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT') ? __ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT : ''
																		),
																		'Dimensions' => array(
																			'Length' => isset($this->request->data['OrderTransaction']['length']) ? $this->request->data['OrderTransaction']['length'] : '' ,
																			'Width' => isset($this->request->data['OrderTransaction']['width']) ? $this->request->data['OrderTransaction']['width'] : '' ,
																			'Height' => isset($this->request->data['OrderTransaction']['height']) ? $this->request->data['OrderTransaction']['height'] : '' ,
																			'Units' => defined('__ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT') ? __ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT : ''
																		)),
												 		)
					);
			
			$options_req_shipment = array_merge((array)$options_req_shipment2, (array)$options_req_shipment1);															
			
			$options = array(
					'WebAuthenticationDetail' => defined('__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL') ? unserialize(__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL) : '',
					'ClientDetail' => defined('__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL') ? unserialize(__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL) : '',
					'TransactionDetail' => array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***'),
					'Version' => defined('__ORDERS_SHIPPING_FEDEX_VERSION') ? unserialize(__ORDERS_SHIPPING_FEDEX_VERSION) : '',
					'ReturnTransitAndCommit' => true,
					'RequestedShipment' => $options_req_shipment,
				);
			$data = $this->Shipping->getRate($options);
								 		
			return ($data);
			
	}
	
}
?>