<?php
namespace Saw\Component\Payment;

class NewCustomerRequest extends \Saw\Component\Communication\Request {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'token'=>true,
									'name'=>true,
									'expMonth'=>true,
									'expYear'=>true,
									'cardType'=>true,
									'number'=>true,
									'cvc'=>true,
									'addressLine1'=>true,
									'addressLine2'=>true,
									'stateProvinceRegion'=>true,
									'zipPostalCode'=>true,
									'country'=>true,
									'email'=>true,
									'description'=>true									
								);
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
	/**
	 * Override Request.validate() because matching the array template isn't enough.
	 * More logic has to e applied because a new customer request can have a card as an array
	 * or as a string token representing a card.
	 * This will return true if the validate array matches the template exactly
	 * otherwise the array keys that don't match will be returned.
	 *
	 * @return mixed true if each key in the _template matches the $this->_validate array.
	 * @exception RequestDomainException
	 */
	public function validate(){
		$res_arr = array();
		
		// if token is present then it represents the card and address fields
		// so the must be removed as they are not needed to validate against
		if(!empty($this->_validate['token'])){
			$this->_template['name'] = false;
			$this->_template['expMonth'] = false;
			$this->_template['expYear'] = false;
			$this->_template['cardType'] = false;
			$this->_template['number'] = false;
			$this->_template['cvc'] = false;
			$this->_template['addressLine1'] = false;
			$this->_template['addressLine2'] = false;
			$this->_template['stateProvinceRegion'] = false;
			$this->_template['zipPostalCode'] = false;
			$this->_template['country'] = false;
			$this->_template = array_filter($this->_template);
		}
		
		$res_arr = $this->recursiveValidate($this->_template, $this->_validate);
		
		//error_log('NewCustomerRequest::validate::_validate::');
		//error_log(print_r($this->_validate,true));
		//error_log(print_r($this->_template,true));
		//error_log(print_r($res_arr,true));
		
		
		if(empty($res_arr)):
			return true;
		else:
			throw new \Saw\Component\Communication\Exceptions\RequestDomainException("The request array doesn't validate", $res_arr);
		endif;
	}
	
}