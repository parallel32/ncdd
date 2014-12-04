<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * PaymentLite model.  
 * lightweight version of Member model
 */
class PaymentLite extends Model {

	public $_id;
	public $name;
	public $token;
	public $expMonth;
	public $expYear;
	public $cardType;
	public $number;
	public $cvc;
	public $addressLine1;
	public $addressLine2;
	public $city;
	public $stateProvinceRegion;
	public $zipPostalCode;
	public $country;
	// FDGG specific ACH (check transaction)
	public $checkNumber; // Customer's check number
	public $accountType; // PC – Primary checking, PS – Primary savings, BC – Backup checking, BS – Backup savings
	public $accountNumber; // Checking Account Number
	public $routingNumber; // Customer's Bank Routing Number
	public $drivingLicenseNumber; //Customer's Driver's License Number
	public $drivingLicenseState; // The two-digit abbreviation for the state that issues the Driver‟s License.
	// the renewal credit
	public $renewalCredit; 
	
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		//$metadata->addPropertyConstraint('renewalCredit', new Constraints\Type(array('type'=>'numeric','message'=>'Please input only numbers.')));
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('groups' => array('cc','product-purchase'))));
		$metadata->addPropertyConstraint('number', new Constraints\NotBlank(array('groups' => array('cc','product-purchase'))));
		$metadata->addPropertyConstraint('cvc', new Constraints\NotBlank(array('groups' => array('cc','product-purchase'))));
		$metadata->addPropertyConstraint('addressLine1', new Constraints\NotBlank(array('groups' => array('check','cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('groups' => array('check','cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('stateProvinceRegion', new Constraints\NotBlank(array('groups' => array('check','cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('zipPostalCode', new Constraints\NotBlank(array('groups' => array('check','cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('groups' => array('check','cc','manual','product-purchase'))));
		
		
		$metadata->addPropertyConstraint('checkNumber', new Constraints\NotBlank(array('groups' => array('check'))));
		$metadata->addPropertyConstraint('accountType', new Constraints\NotBlank(array('groups' => array('check'))));
		$metadata->addPropertyConstraint('accountNumber', new Constraints\NotBlank(array('groups' => array('check'))));
		$metadata->addPropertyConstraint('routingNumber', new Constraints\NotBlank(array('groups' => array('check'))));
		$metadata->addPropertyConstraint('drivingLicenseNumber', new Constraints\NotBlank(array('groups' => array('check'))));
		$metadata->addPropertyConstraint('drivingLicenseState', new Constraints\NotBlank(array('groups' => array('check'))));
		
		
		$metadata->addConstraint(new Callback(array('methods' => array('renewalCreditCheck'))));
		$metadata->addConstraint(new Callback(array('methods' => array('validateCardNumber'))));
	}
	public function renewalCreditCheck(ExecutionContext $context){
		
		if(!empty($this->renewalCredit) && !is_numeric($this->renewalCredit)){
			$propertyPath = $context->getPropertyPath().'renewalCredit';
        	$context->addViolationAtPath($propertyPath,'Please input only numbers.', array(), null);
		}
	}	
	public function validateCardNumber(ExecutionContext $context){
		
		  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
		  $number=preg_replace('/\D/', '', $this->number);

		  // Set the string length and parity
		  $number_length=strlen($number);
		  $parity=$number_length % 2;

		  // Loop through each digit and do the maths
		  $total=0;
		  for ($i=0; $i<$number_length; $i++) {
		    $digit=$number[$i];
		    // Multiply alternate digits by two
		    if ($i % 2 == $parity) {
		      $digit*=2;
		      // If the sum is two digits, add them together (in effect)
		      if ($digit > 9) {
		        $digit-=9;
		      }
		    }
		    // Total up the digits
		    $total+=$digit;
		  }

		  // If the total mod 10 equals 0, the number is valid
		  

		if($total % 10 != 0){
			if(strpos($this->number, '...') === false){
				$propertyPath = $context->getPropertyPath().'number';
        		$context->addViolationAtPath($propertyPath,'This card number is either invalid or it is one we do not accept.', array(), null);
        	}
		}
	}	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->_id = (!is_object($doc['_id'])) ? new \MongoId($doc['_id']) : $doc['_id'];
		$this->name = $doc['name'];
		$this->token = $doc['token'];  
		$this->expMonth = $doc['expMonth'];
		$this->expYear = $doc['expYear'];        
		$this->cardType = $doc['cardType'];        
		$this->number = (strpos($this->number, '...') !== false) ? '' : (string)$doc['number'];
		$this->cvc = $doc['cvc'];
		$this->checkNumber = $doc['checkNumber'];
		$this->accountType = $doc['accountType'];
		$this->accountNumber = $doc['accountNumber'];
		$this->routingNumber = $doc['routingNumber'];
		$this->drivingLicenseNumber = $doc['drivingLicenseNumber'];
		$this->drivingLicenseState = $doc['drivingLicenseState'];
        $this->addressLine1 = $doc['addressLine1'];
        $this->addressLine2 = $doc['addressLine2'];
		$this->city = $doc['city'];
		$this->stateProvinceRegion = $doc['stateProvinceRegion'];    	
        $this->zipPostalCode = $doc['zipPostalCode'];
        $this->country = $doc['country'];
        $this->renewalCredit = $doc['renewalCredit'];
		
	}
	
}