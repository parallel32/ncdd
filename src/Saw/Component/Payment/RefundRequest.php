<?php
namespace Saw\Component\Payment;

class RefundRequest extends \Saw\Component\Communication\Request {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'id'=>true,
									'amount'=>true
								);
	
	public function __construct($validate){
		parent::__construct($validate);
	}

	
}