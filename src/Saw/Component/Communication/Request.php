<?php

namespace Saw\Component\Communication;

class Request extends Communication {
	
	/**
	 * array to validate against
	 * by design all elements in this array must be set 
	 * to true.  array_filter is used to reduce the array
	 * based on business rules and in order to reduce it
	 * the element that is desired to be removed should be
	 * reset to false.
	 * @var array
	 */
	protected $_template;
	
	/**
	 * array to validate and is always empty
	 * until one is passed in to the constructor
	 * @var array
	 */
	protected $_validate;
	
	public function __construct($arr){
		$this->_validate = $arr;
	}
	
	public function __toArray(){
		return $this->_validate;
	}
	/**
	 * will return true if the validate array matches the template exactly
	 * otherwise the array keys that don't match will be returned.
	 *
	 * @return mixed true if each key in the _template matches the $this->_validate array.
	 * @exception RequestDomainException
	 */
	public function validate (){
		$res_arr = array();
		//error_log('Request:validate::_validate::');
		//error_log(print_r($this->_validate,true));
		//error_log(print_r($this->_template,true));
		
		$res_arr = $this->recursiveValidate($this->_template, $this->_validate);
		if(empty($res_arr)):
			return true;
		else:
			throw new Exceptions\RequestDomainException("The request array doesn't validate", $res_arr);
		endif;
	}
	
}