<?php
namespace Saw\Component\Payment;

abstract class Payment {
	
	/**
	 * an array containing keys to authenticate to a payment gateway
	 * @var array
	 */
	protected $keys;
	
	/**
	 * the Silex app object
	 * @var \Application\Silex 
	 */
	public $app;
	
	/**
	 * initialize the private variables
	 *
	 * @param \Silex\Application 	$app  	the silex application
	 * @param array 			 	$keys	an array containing keys 
	 *										to authenticate to a payment gateway
	 */
	public function __construct(\Silex\Application $app, array $keys){
		$this->app  = $app;
		$this->keys = $keys;
	}
	/**
	 * charge a credit card
	 *
	 * @param array 	$request	an array that is converted to a request object through an internal
	 *								call to chargeRequest which in turn 
	 *								validates against the ChargeRequest object's policy
	 *								and can contain either an array of credit card information or
	 * 								a private string representing credit card information 
	 * @return 	Response  			return a Response Object 
	 */
	abstract public function charge($request);
	
	/**
	 * Process the charge request and standardize for the intended payment gateway.
	 * This is designed to hold the plumbing to prepare any request 
	 * for validation with the ChargeRequest object.
	 * 
	 * @param 	array 	$request  	request array to a payment gateway
	 * @return 	Request 			return a Request Object 
	 *					
	 */
	abstract protected function chargeRequest($request);
	
	/**
	 * process the charge response and standardize 
	 * for the intended payment gateway
	 * 
	 * @param 	array 	$response  	response array from a payment gateway
	 * @return 	Response    		return a Response Object 
	 *					
	 */
	abstract protected function chargeResponse($response);
	
	/**
	 * @param array 	$request	an array that is converted to a request object through an internal
	 *								call to chargeRequest which in turn 
	 *								validates against the ChargeRequest object's policy
	 * @return 	Response  			return a Response Object
	 */
	abstract public function refund($request);

	/**
	 * Process the refund request and standardize for the intended payment gateway.
	 * This is designed to hold the plumbing to prepare any request 
	 * for validation with the ChargeRequest object.
	 * 
	 * @param 	array 	$request  	request array to a payment gateway
	 * @return 	Request 			return a Request Object 
	 *					
	 */
	abstract protected function refundRequest($request);
	
	/**
	 * process the refund response and standardize
	 * for the intended payment gateway
	 * 
	 * @param 	array 	$response  	response array from a payment gateway
	 * @return 	Response    		return a Response Object 
	 *					
	 */
	abstract protected function refundResponse($response);

	
	/**
	 * create a new customer
	 *
	 * @param array 	$request	an array that is converted to a request object through an internal
	 *								call to CustomerRequest which in turn 
	 *								validates against the ChargeRequest object's policy
	 *								and can contain either an array of credit card information or
	 * 								a private string representing credit card information 
	 * @return 	Response  			return a Response Object
	 */
	abstract public function newCustomer($request);
	
	/**
	 * Process the new customer request and standardize for the intended payment gateway.
	 * This is designed to hold the plumbing to prepare any request 
	 * for validation with the ChargeRequest object.
	 * 
	 * @param 	array 	$request  	request array to a payment gateway
	 * @return 	Request 			return a Request Object 
	 *					
	 */
	abstract protected function newCustomerRequest($request);
	
	/**
	 * process the new customer response and standardize
	 * for the intended payment gateway
	 * 
	 * @param 	array 	$response  	response array from a payment gateway
	 * @return 	Response    		return a Response Object 
	 *					
	 */
	abstract protected function newCustomerResponse($response);
	
	abstract public function updateCustomer($request);
	
	abstract protected function updateCustomerRequest($request);
	
	abstract protected function updateCustomerResponse($response);

	abstract public function deleteCustomer($request);
	
	abstract protected function deleteCustomerRequest($request);
	
	abstract protected function deleteCustomerResponse($response);
	
	/**
	 * find one customer
	 *
	 * @param 	array 		$request 	consists only of the customerId
	 * @return 	Response  				return a Response Object
	 */
	abstract public function getCustomer($request);
	
	/**
	 * 
	 * @param 	array 	$request  	request array to a payment gateway
	 * @return 	Request 			return a Request Object 
	 *					
	 */
	abstract protected function getCustomerRequest($request);
	
	/**
	 * 
	 * @param 	array 	$response  	response array from a payment gateway
	 * @return 	Response    		return a Response Object 
	 *					
	 */
	abstract protected function getCustomerResponse($response);
	
	
}