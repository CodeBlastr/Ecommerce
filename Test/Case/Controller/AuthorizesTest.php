<?php
/* Authorizes Test cases generated on: 2012-02-08 01:26:47 : 1328664407*/
App::uses('Authorizes', 'Orders.Controller');

/**
 * TestAuthorizes *
 */
class TestAuthorizes extends Authorizes {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * Authorizes Test Case
 *
 */
class AuthorizesTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Authorizes = new TestAuthorizes();
		$this->->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Authorizes);

		parent::tearDown();
	}

}
