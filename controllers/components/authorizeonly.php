<?php
require('authcim.php');
class AuthorizeonlyComponent extends Object { 
	
	var $response = array();
	var $recurring = false;
	var $login	=  __ORDERS_TRANSACTIONS_AUTHORIZENET_LOGIN_ID; 
	var $transkey = __ORDERS_TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY;
	var $data = null;
	
	
	//set recurring value default is false
	function recurring($val = false) {
		$this->recurring = $val;
	}
	
	function startup(&$controller) { 
        // This method takes a reference to the controller which is loading it. 
        // Perform controller initialization here. 
    }

/**
 * Payment by chargin CC based on Authorize.net
 *
 */
	function Pay($data) {
		$this->data = $data;
		//create AuthnetCIM class object
		$this->authnetCIM = new AuthnetCIM($this->login, $this->transkey, 1);
		$this->cimCustomerProfile($this->data);	
	}

	function cimPayment() {
			
		//@todo: make this refID (optional) to come from some field or store this for later use
		$this->authnetCIM->setParameter('refID', 150);
		
		$this->authnetCIM->setParameter('customerProfileId', $this->data['Billing']['cim_profile_id']);
		$this->authnetCIM->setParameter('customerPaymentProfileId', $this->data['Billing']['cim_payment_profile_id']);
		$this->authnetCIM->setParameter('amount', $this->data['Order']['theTotal']);
		$this->authnetCIM->setParameter('cardCode', 125);
		$this->authnetCIM->createCustomerProfileTransaction('profileTransAuthOnly');
		$this->_parseCIMResponse($this->authnetCIM);
	}
	
	function cimPaymentProfile() {
			
		//@todo: make this refID (optional) to come from some field or store this for later use
		$this->authnetCIM->setParameter('refID', 150);
		
		$this->authnetCIM->setParameter('customerProfileId', $this->data['Billing']['cim_profile_id']);
		$this->authnetCIM->setParameter('billToFirstName', $this->data['Billing']['first_name']); 
		$this->authnetCIM->setParameter('billToLastName', $this->data['Billing']['last_name']); 
		$this->authnetCIM->setParameter('billToAddress', $this->data['Billing']['street_address_1'] . ' ' . $this->data['Billing']['street_address_2']);
		$this->authnetCIM->setParameter('billToCity', $this->data['Billing']['city']);
		$this->authnetCIM->setParameter('billToState', $this->data['Billing']['state']);
		
		$this->authnetCIM->setParameter('billToZip', $this->data['Billing']['zip']);
		$this->authnetCIM->setParameter('billToCountry', $this->data['Billing']['country']);
		$this->authnetCIM->setParameter('cardNumber',$this->data['CreditCard']['card_number']); 
		$this->authnetCIM->setParameter('expirationDate', $this->data['CreditCard']['expiration_year']
				."-".$this->data['CreditCard']['expiration_month']);
	
		$this->authnetCIM->createCustomerPaymentProfile();
		$this->_parseCIMResponse($this->authnetCIM);
	}
    
	
	function cimCustomerProfile() {
			
		//@todo: make this refID (optional) to come from some field or store this for later use
		$this->authnetCIM->setParameter('refID', 150);
		$this->authnetCIM->setParameter('merchantCustomerId', $this->data['Billing']['user_id']);
		
		$this->authnetCIM->setParameter('billToFirstName', $this->data['Billing']['first_name']); 
		$this->authnetCIM->setParameter('billToLastName', $this->data['Billing']['last_name']); 
		$this->authnetCIM->setParameter('billToAddress', $this->data['Billing']['street_address_1'] . ' ' . $this->data['Billing']['street_address_2']);
		$this->authnetCIM->setParameter('billToCity', $this->data['Billing']['city']);
		$this->authnetCIM->setParameter('billToState', $this->data['Billing']['state']);
		
		$this->authnetCIM->setParameter('billToZip', $this->data['Billing']['zip']);
		$this->authnetCIM->setParameter('billToCountry', $this->data['Billing']['country']);
		$this->authnetCIM->setParameter('cardNumber',$this->data['CreditCard']['card_number']); 
		$this->authnetCIM->setParameter('expirationDate', $this->data['CreditCard']['expiration_year']
				."-".$this->data['CreditCard']['expiration_month']);
	
		$this->authnetCIM->setParameter('shipToFirstName', $this->data['Shipping']['first_name']); 
		$this->authnetCIM->setParameter('shipToLastName', $this->data['Shipping']['last_name']); 
		$this->authnetCIM->setParameter('shipToAddress', $this->data['Shipping']['street_address_1'] . ' ' . $this->data['Shipping']['street_address_2']);
		$this->authnetCIM->setParameter('shipToCity', $this->data['Shipping']['city']);
		$this->authnetCIM->setParameter('shipToState', $this->data['Shipping']['state']);
		$this->authnetCIM->setParameter('shipToZip', $this->data['Shipping']['zip']);
		$this->authnetCIM->setParameter('shipToCountry', $this->data['Shipping']['country']);
		
		$this->authnetCIM->createCustomerProfile();
		
		$payment_profile_id  = null;
		$profile_id = null; // customer profile id
		
		if(!$this->authnetCIM->isSuccessful() && 
					strpos($this->authnetCIM->getResponse(), 'duplicate')) {
			// if failure but duplicate entry
			$duplicate_response = explode(" ", $this->authnetCIM->getResponse());
			// customer profile id existing customer
			$profile_id = $duplicate_response[5];
		
			$this->authnetCIM->setParameter('customerProfileId', $profile_id);
			$this->authnetCIM->getCustomerProfile();
			
			$found = false;
			// if multiple payment profiles
			if(is_array($this->authnetCIM->paymentProfiles['paymentProfiles'])) {
				foreach($this->authnetCIM->paymentProfiles['paymentProfiles'] as $profile ) {
					$payment_profile_id = $profile->customerPaymentProfileId;
					$profile_card_number = $profile->payment->creditCard->cardNumber;
					if(substr($profile_card_number, -4) == substr($this->data['CreditCard']['card_number'], -4)){
						$found = true;
						break; // found existing profile
					}
					
				}
			} else { // else if single profile of payment
				$payment_profile_id = $this->authnetCIM->paymentProfiles['paymentProfiles']->customerPaymentProfileId;
				$found = true;
			}
			
			if (!$found) { // credit card profile found
				$payment_profile_id = null; // this is done because if no match is found we ned to create
					// a new profile below
			}
		}
		else if($this->authnetCIM->isSuccessful()) {
			// if successful
			$profile_id = $this->authnetCIM->getProfileID();
		} 

		// crate new payment profile
		if ($profile_id && !$payment_profile_id) {

			$this->authnetCIM->setParameter('customerProfileId', $profile_id);
			$this->authnetCIM->createCustomerPaymentProfile();

			if($this->authnetCIM->isSuccessful()) {
				$payment_profile_id = $this->authnetCIM->getPaymentProfileId();
			}
		}

		$this->_parseCIMResponse($this->authnetCIM , $profile_id, $payment_profile_id);
	}

	/**
	 * parseCIMResponse()
	 * @parameters AuthnetCIM object, customer profile id, customer payment profile id   
	 *
	 */
	function _parseCIMResponse($cim, $profile_id, $payment_profile_id) {
		
		//if profile id and payment profile id is set 
		if(isset($profile_id) && isset($payment_profile_id)) {
			$parsedResponse['description'] = 'Transaction'; // The transaction description, Up to 255 characters (no symbols)
			$parsedResponse['response_code'] = 1; //response code 1 for successfull response
			$parsedResponse['transaction_type'] = 'auth_only';
			$parsedResponse['reason_text'] = 'Transaction Successfull';
		} else { //if profile id is not set
			$parsedResponse['description'] = $cim->getDescription(); // The transaction description, Up to 255 characters (no symbols)
			$parsedResponse['response_code'] = $cim->getResponseCode(); //response code 1 for successfull response
			$parsedResponse['response_subcode'] = $cim->getResponseSubcode(); // A code used by the payment gateway for internal transaction tracking
			$parsedResponse['reason_code'] = $cim->getReasonCode(); // A code that provides more details about the result of the transaction
			$parsedResponse['reason_text'] = $cim->getResponseText();
			$parsedResponse['transaction_type'] = $cim->getTransactionType();
		   	$parsedResponse['meta'] = $cim->getResponse() ;
		}
		$parsedResponse['cim_profile_id'] = $profile_id;
		$parsedResponse['cim_payment_profile_id'] = $payment_profile_id;
		$parsedResponse['transaction_id'] = $profile_id; // The payment gateway assigned identification number for the transaction
		$parsedResponse['amount'] = $this->data['Order']['theTotal'];
	   	$this->response = $parsedResponse;
	}
	
}
?>