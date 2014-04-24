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

	public $amount; // charge amount (the full total and includes tax and shipping)
	public $orderTotal;
	public $shippingTotal;
	public $discountTotal;
	
	public $description;
	public $title;
	public $ownerId; // can be anything: application, seminar, product
	public $ownerClass; // the class to which the ownerId belongs
	public $transactionId;
	public $paidDate;
	public $items;
	public $memberId; //either loggedin user or has no value because it's a public store purchase

	// FDGG specific
	public $transactionOrigin;
	public $invoiceNumber;
	public $orderId;
	public $referenceNumber;
	public $poNumber;

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
		$this->number = $doc['number'];        
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
		$this->orderTotal = $doc['orderTotal'];
		$this->shippingTotal = $doc['shippingTotal'];
		$this->discountTotal = $doc['discountTotal'];
		$this->description = $doc['description'];
		$this->title = $doc['title'];
		$this->ownerId = $doc['ownerId'];
		$this->ownerClass = $doc['ownerClass'];
		$this->transactionId = $doc['transactionId'];
		$this->paidDate = $doc['paidDate'];
		$this->items = $doc['items'];
		$this->memberId = $doc['memberId'];
		$this->transactionOrigin = $doc['transactionOrigin'];
		$this->invoiceNumber = $doc['invoiceNumber'];
		$this->orderId = $doc['orderId'];
		$this->referenceNumber = $doc['referenceNumber'];
		$this->poNumber = $doc['poNumber'];

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
		$this->orderTotal = $this->orderTotal ?: '';
		$this->shippingTotal = $this->shippingTotal ?: '';
		$this->discountTotal = $this->discountTotal ?: '';
		$this->description = $this->description ?: '';
		$this->title = $this->title ?: '';
		$this->ownerClass = $this->ownerClass ?: '';
		$this->ownerId = (!empty($this->ownerId)) ? (is_object($this->ownerId)) ? $this->ownerId : new \MongoId($this->ownerId) : new \stdClass();
		$this->transactionId = $this->transactionId ?: '';
		$this->paidDate = $this->paidDate ?: new Date(self::$app, 'now');
		$this->items = $this->items ?: array();
		$this->memberId = (!empty($this->memberId)) ? (is_object($this->memberId)) ? $this->memberId : new \MongoId($this->memberId) : null;
		$this->transactionOrigin = $this->transactionOrigin ?: '';
		$this->invoiceNumber = $this->invoiceNumber ?: '';
		$this->orderId = $this->orderId ?: '';
		$this->referenceNumber = $this->referenceNumber ?: '';
		$this->poNumber = $this->poNumber ?: '';

	}
	
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Exceptions\DomainException("Adding failed.  Please try again.");
		}
	}
	

	private function prepareCurl($body){

		// initializing cURL with the FDGGWS API URL: 
		$ch = curl_init(SAW_FDGG_URL); 
		// setting the request type to POST: 
		curl_setopt($ch, CURLOPT_POST, 1); 
		// setting the content type: 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml")); 
		// setting the authorization method to BASIC: 
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
		// supplying your credentials: 
		curl_setopt($ch, CURLOPT_USERPWD, SAW_FDGG_USERPWD); 
		// filling the request body with your SOAP message: 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
		// configuring cURL not to verify the server certificate: 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		// setting the path where cURL can find the client certificate: 
		curl_setopt($ch, CURLOPT_SSLCERT, SAW_FDGG_SSLCERT); 
		// setting the path where cURL can find the client certificate’s 
		// private key: 
		curl_setopt($ch, CURLOPT_SSLKEY, SAW_FDGG_SSLKEY);
		// setting the key password: 
		curl_setopt($ch, CURLOPT_SSLKEYPASSWD, SAW_FDGG_SSLKEYPASSWD);
		// telling cURL to return the HTTP response body as operation result 
		// value when calling curl_exec: 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		return $ch;
	}
	
	private function sendCharge(){
		$date = new Date(self::$app,'now');
$body = <<< EOT
<fdggwsapi:FDGGWSApiOrderRequest xmlns:v1="http://secure.linkpt.net/fdggwsapi/schemas_us/v1" First Data Corp. Web Service API v6.0 14 xmlns:fdggwsapi="http://secure.linkpt.net/fdggwsapi/schemas_us/fdggwsapi">
<v1:Transaction>
<v1:CreditCardTxType>
<v1:Type>sale</v1:Type>
</v1:CreditCardTxType>
<v1:CreditCardData>
<v1:CardNumber>{$this->number}</v1:CardNumber>
<v1:ExpMonth>{$this->expMonth}</v1:ExpMonth>
<v1:ExpYear>{$this->expYear}</v1:ExpYear>
<v1:CardCodeValue>{$this->cvc}</v1:CardCodeValue>
</v1:CreditCardData>
<v1:Payment>
<v1:SubTotal>{$this->orderTotal}</v1:SubTotal>
<v1:VATTax>0.00</v1:VATTax>
<v1:Shipping>{$this->shippingTotal}</v1:Shipping>
<v1:ChargeTotal>{$this->amount}</v1:ChargeTotal>
</v1:Payment>
<v1:TransactionDetails>
<v1:UserID>{$this->memberId}</v1:UserID>
<v1:InvoiceNumber>{$this->invoiceNumber}</v1:InvoiceNumber>
<v1:OrderId>{$this->orderId}</v1:OrderId>
<v1:Ip></v1:Ip>
<v1:ReferenceNumber>{$this->referenceNumber}</v1:ReferenceNumber>
<v1:Date>{$date->detail}</v1:Date>
<v1:Recurring>No</v1:Recurring>
<v1:TrasactionOrigin>{$this->transactionOrigin}</v1:TransactionOrigin>
<v1:PONumber>{$this->poNumber}</v1:PONumber>
</v1:TransactionDetails>
<v1:Billing>
<v1:CustomerID>{$this->memberId}</v1:CustomerID>
<v1:Name>{$this->name}</v1:Name>
<v1:Address1>{$this->addressLine1}</v1:Address1>
<v1:Address2>{$this->addressLine2}</v1:Address2>
<v1:City>{$this->city}</v1:City>
<v1:State>{$this->stateProvinceRegion}</v1:State>
<v1:Zip>{$this->zipPostalCode}</v1:Zip>
<v1:Country>{$this->country}</v1:Country>
<v1:Phone>{$this->phone}</v1:Phone>
<v1:Fax></v1:Fax>
<v1:Email>{$this->email}</v1:Email>
</v1:Billing>
<v1:Shipping>
<v1:Type></v1:Type>
<v1:Name>{$this->name}</v1:Name>
<v1:Address1>{$this->addressLine1Shipping}</v1:Address1>
<v1:Address2>{$this->addressLine2Shipping}</v1:Address2>
<v1:City>{$this->cityShipping}</v1:City>
<v1:State>{$this->stateProvinceRegionShipping}</v1:State>
<v1:Zip>{$this->zipPostalCodeShipping}</v1:Zip>
<v1:Country>{$this->countryShipping}</v1:Country>
</v1:Shipping>
</v1:Transaction>
</fdggwsapi:FDGGWSApiOrderRequest>
EOT;
		error_log('envelope:'.$body);
		$ch = $this->prepareCurl($body);
		// calling cURL and saving the SOAP response message in a variable which 
		// contains a string like "<SOAP-ENV:Envelope ...>...</SOAP-ENV:Envelope>":
		$result = curl_exec($ch); 
		error_log('charge response:'.print_r($result,true));
		// closing cURL: 
		curl_close($ch);
	}
	/**
	 * Initiate a credit card charge
	 */
	public function charge(){
		try {
			/*
			// FDGG
			$this->transactionOrigin = 'web';
			$this->invoiceNumber = new \MongoId();
			$this->orderId = new \MongoId();
			$this->referenceNumber = new \MongoId();
			$this->poNumber = new \MongoId();

			$this->sendCharge();

			return new \MongoId();
			//*/

			//*
			// prepare charge request here
			$request['amount'] = $this->amount*100; // because Stripe treats a dollar amount as 100 pennies
			$request['currency'] = $this->currency;
			$request['description'] = $this->description;
			$request['card'] = $this->token;
			$response = \Stripe_Charge::create($request, $this->secretKey);

			$this->transactionId = $response->id;
			$this->number = substr($this->number,-4);
			$paymentId = $this->insert();
			$this->markOwnerClassPaid($paymentId);
			return $paymentId;
			//*/
			
		} catch (\Exception $e) {
			throw new \Saw\Exceptions\SawException(new Exceptions\DomainException(),"The transaction failed.  Please try again. Processing Message: ".$e->getMessage()." Code:".$e->getCode());
		}
		
	}
	/**
	 * Issue a credit card refund on a previous charge
	 * NOTE: currently not in use.
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
	 * Initiate a credit card charge
	 */
	public function chargeStripe(){
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
	 * NOTE: currently not in use.
	 */
	public function refundStripe($transactionId, $amount){
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
	 * This manually marks an item as paid by creating this 
	 * record and marking the owner class paid the the factory method.
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