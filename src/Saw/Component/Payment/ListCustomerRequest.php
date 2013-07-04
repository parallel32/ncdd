<?php
namespace Saw\Component\Payment;

class ListCustomerRequest extends \Saw\Component\Communication\Request {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'count'=>true,
									'offset'=>true
								);
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
}