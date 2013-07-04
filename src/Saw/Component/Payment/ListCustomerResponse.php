<?php
namespace Saw\Component\Payment;

class ListCustomerResponse extends \Saw\Component\Communication\Response {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'id'=>true,
									'created'=>true,
									'description'=>true,
									'email'=>true,
									'card'=>array(
										'type'=>true,
										'last4'=>true,
										'exp_month'=>true,
										'exp_year'=>true,
										'name'=>true,
										'country'=>true,
										'address_line1'=>true,
										'address_line2'=>true,
										'address_zip'=>true,
										'address_state'=>true,
										'address_country'=>true,
									)
								);							
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
}