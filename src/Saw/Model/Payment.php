<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Payment model.  Belongs to Merchant and Merchant has many Payments.
 * Design decision is to make Payment a collection.
 */
class Payment extends Model {
	
	public $collection = 'payment';
    public $type;
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
	
	public $addressLine1Shipping;
	public $addressLine2Shipping;
	public $cityShipping;
	public $stateProvinceRegionShipping;
	public $zipPostalCodeShipping;
	public $countryShipping;
	
	public $phone;
	public $email;
	public $amount;
	public $description;
	public $title;
	public $ownerId; // can be anything: application, seminar, product
	public $ownerClass; // the class to which the ownerId belongs
	public $transactionId;
	public $paidDate;
	public $items;
	public $memberId; //either loggedin user or has no value because it's a public store purchase
	private $currency = 'usd';
	private $publicKey = SAW_STRIPE_PUBLIC_KEY;
	private $secretKey = SAW_STRIPE_SECRET_KEY;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('groups' => array('cc','product-purchase'))));
		$metadata->addPropertyConstraint('number', new Constraints\NotBlank(array('groups' => array('cc','product-purchase'))));
		$metadata->addPropertyConstraint('cvc', new Constraints\NotBlank(array('groups' => array('cc','product-purchase'))));
		
		$metadata->addPropertyConstraint('addressLine1', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('stateProvinceRegion', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('zipPostalCode', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		
		$metadata->addPropertyConstraint('addressLine1Shipping', new Constraints\NotBlank(array('groups' => array('product-purchase'))));
		$metadata->addPropertyConstraint('cityShipping', new Constraints\NotBlank(array('groups' => array('product-purchase'))));
		$metadata->addPropertyConstraint('stateProvinceRegionShipping', new Constraints\NotBlank(array('groups' => array('product-purchase'))));
		$metadata->addPropertyConstraint('zipPostalCodeShipping', new Constraints\NotBlank(array('groups' => array('product-purchase'))));
		$metadata->addPropertyConstraint('countryShipping', new Constraints\NotBlank(array('groups' => array('product-purchase'))));
		
		$metadata->addPropertyConstraint('phone', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email','groups' => array('cc','manual','product-purchase'))));
		
		// product-purchase group isn't required here because the payment must validate before an Order record can be created
		$metadata->addPropertyConstraint('ownerId', new Constraints\NotBlank(array('groups' => array('cc','manual')))); 
		$metadata->addPropertyConstraint('ownerClass', new Constraints\NotBlank(array('groups' => array('cc','manual'))));
		
		$metadata->addPropertyConstraint('description', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('title', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		$metadata->addPropertyConstraint('amount', new Constraints\NotBlank(array('groups' => array('cc','manual','product-purchase'))));
		
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
		$this->type = $doc['type'];        
		$this->name = $doc['name'];        
		$this->token = $doc['token'];        
		$this->expMonth = $doc['expMonth'];        
		$this->expYear = $doc['expYear'];        
		$this->cardType = $doc['cardType'];        
		$this->number = '...'.$doc['number'];        
		$this->cvc = $doc['cvc'];        
        $this->addressLine1 = $doc['addressLine1'];
        $this->addressLine2 = $doc['addressLine2'];
		$this->city = $doc['city'];
		$this->stateProvinceRegion = $doc['stateProvinceRegion'];    	
        $this->zipPostalCode = $doc['zipPostalCode'];
        $this->country = $doc['country'];
		$this->addressLine1Shipping = $doc['addressLine1Shipping'];
        $this->addressLine2Shipping = $doc['addressLine2Shipping'];
		$this->cityShipping = $doc['cityShipping'];
		$this->stateProvinceRegionShipping = $doc['stateProvinceRegionShipping'];    	
        $this->zipPostalCodeShipping = $doc['zipPostalCodeShipping'];
        $this->countryShipping = $doc['countryShipping'];
		$this->phone = $doc['phone'];
		$this->email = $doc['email'];
		$this->amount = $doc['amount'];
		$this->description = $doc['description'];
		$this->title = $doc['title'];
		$this->ownerId = $doc['ownerId'];
		$this->ownerClass = $doc['ownerClass'];
		$this->transactionId = $doc['transactionId'];
		$this->paidDate = $doc['paidDate'];
		$this->items = $doc['items'];
		$this->memberId = $doc['memberId'];
	}
	
	protected function prepareInsert(){
		$this->type = $this->type ?: 'cc';
		$this->name = $this->name ?: '';
		$this->token = $this->token ?: '';
		$this->expMonth = $this->expMonth ?: '';        
		$this->expYear = $this->expYear ?: '';
		$this->cardType = $this->cardType ?: '';
		$this->number = $this->number ?: '';
		$this->cvc = $this->cvc ?: '';
        $this->addressLine1 = $this->addressLine1 ?: '';
        $this->addressLine2 = $this->addressLine2 ?: '';
		$this->city = $this->city ?: '';
		$this->stateProvinceRegion = $this->stateProvinceRegion ?: '';    	
        $this->zipPostalCode = $this->zipPostalCode ?: '';
        $this->country = $this->country ?: 'US';
		$this->phone = $this->phone ?: '';
		$this->email = $this->email ?: '';
		$this->amount = $this->amount ?: '';
		$this->description = $this->description ?: '';
		$this->title = $this->title ?: '';
		$this->ownerClass = $this->ownerClass ?: '';
		$this->ownerId = (!empty($this->ownerId)) ? (is_object($this->ownerId)) ? $this->ownerId : new \MongoId($this->ownerId) : new \stdClass();
		$this->transactionId = $this->transactionId ?: '';
		$this->paidDate = $this->paidDate ?: new Date(self::$app, 'now');
		$this->items = $this->items ?: array();
		$this->memberId = (!empty($this->memberId)) ? (is_object($this->memberId)) ? $this->memberId : new \MongoId($this->memberId) : null;
	}
	
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Exceptions\DomainException("Adding failed.  Please try again.");
		}
	}
	
	/**
	 * Initiate a credit card charge
	 */
	public function charge(){
		try {
			// prepare charge request here
			$request['amount'] = $this->amount*100; // because Stripe treats a dollar amount as 100 pennies
			$request['currency'] = $this->currency;
			$request['description'] = $this->description;
			$request['card'] = $this->token;
			$response = \Stripe_Charge::create($request, $this->secretKey);

			$this->transactionId = $response->id;
			$paymentId = $this->insert();
			$this->markOwnerClassPaid($paymentId);
			return $paymentId;
		} catch (\Exception $e) {
			throw new \Saw\Exceptions\SawException(new Exceptions\DomainException(),"The transaction failed.  Please try again. Processing Message: ".$e->getMessage()." Code:".$e->getCode());
		}
		
	}
	/**
	 * Issue a credit card refund on a previous charge
	 */
	public function refund($transactionId, $amount){
		// prepare refund request here
		$request['id'] = $transactionId;
		$request['amount'] = $amount;
		
		$ch = \Stripe_Charge::retrieve($request['id'], $this->secretKey);
		if(empty($request['amount'])){ // if not amount specified full refund
			$response = $ch->refund();
		}else{
			$response = $ch->refund(array("amount"=>$request['amount']));
		}
		error_log('REFUND response:'.print_r($response,true));
	}
	/**
	 * do a manual charge usually for check payemnts
	 */
	public function manualCharge(){
		try {
			$this->transactionId = new \MongoId();
			$paymentId = $this->insert();			
			$this->markOwnerClassPaid($paymentId);
			return $paymentId;
		} catch (\Exception $e) {
			throw new \Saw\Exceptions\SawException(new Exceptions\DomainException(),"The transaction failed.  Please try again. Processing Message: ".$e->getMessage()." Code:".$e->getCode());
		}
		
	}
	public function ownerClassObj(){
		switch ($this->ownerClass) {
			case 'RegistrationSeminar':
				$obj = new RegistrationSeminar(array('_id'=>$this->ownerId),self::$app);
				return $obj;
				break;
			case 'ApplyNewMember':
				$obj = new ApplyNewMember(array('_id'=>$this->ownerId),self::$app);
				return $obj;
				break;
			case 'ApplyNewSustainingMember':
				$obj = new ApplyNewSustainingMember(array('_id'=>$this->ownerId),self::$app);
				return $obj;
				break;
		}
	}
	public function markOwnerClassPaid($paymentId){
		switch ($this->ownerClass) {
			case 'RegistrationSeminar':
				$obj = new RegistrationSeminar(array('_id'=>$this->ownerId
														,'currentStatus'=>Registration::$status['PAID']
														,'paidDate'=> new Date(self::$app, 'now')
														,'paymentId'=> $paymentId
												),self::$app);

				return $obj->saveSafe();
				break;
			case 'ApplyNewMember':
				$obj = new ApplyNewMember(array('_id'=>$this->ownerId
														,'currentStatus'=>Apply::$status['PAID']
														,'paidDate'=> new Date(self::$app, 'now')
														,'paymentId'=> $paymentId
												),self::$app);

				return $obj->saveSafe();
				break;
			case 'ApplyNewSustainingMember':
				$obj = new ApplyNewSustainingMember(array('_id'=>$this->ownerId
														,'currentStatus'=>Apply::$status['PAID']
														,'paidDate'=> new Date(self::$app, 'now')
														,'paymentId'=> $paymentId
												),self::$app);

				return $obj->saveSafe();
				break;
		}
	}
	public function fetchAll(){
		if(!empty($this->memberId)){
			$result = $this->find($query=array('memberId'=>$this->memberId),$fields=array(),true,0,1000,$sort=array('_id'=>-1));
		}else{
			$result = $this->find($query=array(),$fields=array(),true,$sort=array('_id'=>-1));
		}
		return $result;
	}
	
}