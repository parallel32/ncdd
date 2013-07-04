<?php
namespace Saw\Component\Payment;

class GetCustomerRequest extends \Saw\Component\Communication\Request {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array('id'=>true);
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
}