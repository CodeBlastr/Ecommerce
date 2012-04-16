<?php
App::uses('OrdersAppController', 'Orders.Controller');

class AuthorizesController extends OrdersAppController {
	public $name = 'Authorizes';
	public $uses = 'Orders.Authorize';
 	public $components = array('AuthorizeNet');

 	function index(){
 		        // You would need to add in necessary information here from your data collector 
        $billinginfo = array("fname" => "First", 
                            "lname" => "Last", 
                            "address" => "123 Fake St. Suite 0", 
                            "city" => "City", 
                            "state" => "ST", 
                            "zip" => "90210", 
                            "country" => "USA"); 
     
        $shippinginfo = array("fname" => "First", 
                            "lname" => "Last", 
                            "address" => "123 Fake St. Suite 0", 
                            "city" => "City", 
                            "state" => "ST", 
                            "zip" => "90210", 
                            "country" => "USA"); 
     
        $response = $this->AuthorizeNet->chargeCard('########', '##############', '4111111111111111', '01', '2010', '123', true, 110, 5, 5, "Purchase of Goods", $billinginfo, "email@email.com", "555-555-5555", $shippinginfo);
 	}
 }