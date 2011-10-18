<?php
/**
 * Payment Using User Credits
 */
//App::import('model' , 'Users.User');
class CreditComponent extends Object{
	var $name = 'Credit';
	
	//var $uses = array('Users.User');
	var $components = array('Session', 'Auth');
	
	function startup(&$controller) {
	}	
	function initialize(&$controller) {
	}
	
	
	
	function Pay($data){
		App::import('Component', 'Session');
		$Session = new SessionComponent();
		
		$userObject = ClassRegistry::init('User');
		$creditData = $userObject->find('first' , array('conditions' => 
				array('User.credit_total >=' => $data['Order']['theTotal'],
						'User.id' => $Session->read('Auth.User.id'))));
		if(!empty($creditData) && intval($creditData['User']['credit_total']) >= intval($data['Order']['theTotal'])) {
			$creditData['User']['credit_total'] = (intval($creditData['User']['credit_total']) - intval($data['Order']['theTotal']));  
			$userObject->updateAll( array("User.credit_total" => $creditData['User']['credit_total']), 
									array( "User.id" => $Session->read('Auth.User.id') ) );
			$response['transaction_id'] = $userObject->__uid('ot');
			$response['response_code'] = 1;
			$response['amount'] = $data['Order']['theTotal'];
			$this->_parseCreditResponse($response);
		}	
		else {
			$response['response_code'] = 0;
			$response['amount'] = $data['Order']['theTotal'];
			$this->_parseCreditResponse($response);
		}
		
	}
	
/**
 * Parse the response from Paypal into a more readable array
 * makes doing validation changes easier.
 *
 */
	function _parseCreditResponse($response) {
		if($response['response_code']) {
				$parsedResponse['reason_code'] = 1;
				$parsedResponse['response_code'] = 1;
				$parsedResponse['transaction_id'] = $response['transaction_id'];
				$parsedResponse['reason_text'] = 'Successful Payment';
				$parsedResponse['description'] = 'Transaction Completed';
		} else {
				$parsedResponse['response_code'] = 3; // similar to authorize
				$parsedResponse['reason_text'] = 'Unsuccesful Payment';
				$parsedResponse['description'] = 'Transaction Can not Completed';
			}
		$parsedResponse['amount'] = $response['amount'];
		$this->response = $parsedResponse;
		
	}
	
}
?>