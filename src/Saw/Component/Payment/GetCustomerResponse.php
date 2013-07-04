<?php
namespace Saw\Component\Payment;

class GetCustomerResponse extends \Saw\Component\Communication\Response {
	
	/**
	 * array to validate against
	 * @var array
	 */
	protected $_template = array(	'vaultId'=>true,
									'expMonth'=>true,
									'expYear'=>true,
									'cardType'=>true,
									'number'=>true,
									'addressLine1'=>true,
									'addressLine2'=>true,
									'stateProvinceRegion'=>true,
									'zipPostalCode'=>true,
									'country'=>true,
									'email'=>true									
								);							
	
	public function __construct($validate){
		parent::__construct($validate);
	}
	
}