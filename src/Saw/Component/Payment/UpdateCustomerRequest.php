<?php
namespace Saw\Component\Payment;

class UpdateCustomerRequest extends \Saw\Component\Communication\Request {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'vaultId'=>true,
									'token'=>true,
									'email'=>true,
									'description'=>true
								);
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
}