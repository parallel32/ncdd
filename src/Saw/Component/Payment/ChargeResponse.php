<?php

namespace Saw\Component\Payment;

class ChargeResponse extends \Saw\Component\Communication\Response {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'transactionId'=>true,
									'date'=>true,
									'amount'=>true,
									'transactionFee'=>true,
									'failureMessage'=>true,
									'status'=>true,
									'lastFourNumbers'=>true,
									'expDate'=>true,
									'nameOnAccount'=>true,
									'type'=>true
									
								);
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
}