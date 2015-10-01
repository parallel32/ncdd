<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Donate Model.
 * This class is the base class for all application-type forms to be submitted.
 */
class Donate extends Model {
	
	public $collection = 'donate';
	static public $status = array('SUBMITTED'=>10,'PAID'=>40);
	static public $statusReversed = array(10=>'SUBMITTED',40=>'PAID');
	public $currentStatus;
	static public $paymentType = array('CHECK'=>10,'CREDIT'=>40,'SCHOLARSHIP'=>60);
	static public $paymentTypeReversed = array(10=>'CHECK',40=>'CREDIT',60=>'SCHOLARSHIP');
	public $currentPaymentType;
	public $for;
	public $amount;
	public $firstName;
	public $middleName;
	public $lastName;
	public $phone;
	public $email;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $postalCode;
	public $country;
	public $memberId;
	public $paymentId;
	public $submittedDate;
	public $paidDate;
	public $timeZone='America/New_York';
	public $userAgent;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidAmount'),
        )));
        
	}
	/**
	 * validator helper function
	*/
	public function isValidAmount(ExecutionContext $context){
		if(!empty($this->amount) && !is_numeric($this->amount)){
            $propertyPath = $context->getPropertyPath().'amount';
        	$context->addViolationAtPath($propertyPath,'Only numbers are accepted.', array(), null);
		}
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->currentStatus = $doc['currentStatus'];
        $this->currentPaymentType = $doc['currentPaymentType'];
		$this->for = $doc['for'];
		$this->amount = $doc['amount'];
		$this->firstName = $doc['firstName'];
		$this->middleName = $doc['middleName'];
		$this->lastName = $doc['lastName'];
		$doc['phone'] = str_replace('(', '', str_replace(')', '', str_replace('-', '', str_replace(' ', '', $doc['phone']))));
		$this->phone = (is_numeric($doc['phone'])) ? $app['format_phone_number']($doc['phone']): $doc['phone'];
		$this->email = $doc['email'];
		$this->address1 = $doc['address1'];
		$this->address2 = $doc['address2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
		$this->postalCode = $doc['postalCode'];
		$this->country = $doc['country'];
		$this->paidDate = $doc['paidDate'];
		if(!empty($doc['memberId'])) $this->memberId = (is_object($doc['memberId'])) ? $doc['memberId'] : new \MongoId($doc['memberId']);
		if(!empty($doc['paymentId'])) $this->paymentId = (is_object($doc['paymentId'])) ? $doc['paymentId'] : new \MongoId($doc['paymentId']);
		$this->userAgent = $doc['userAgent'];
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->submittedDate = new Date(self::$app, 'now');
		$this->paidDate = $this->paidDate ?: new \stdClass();
		$this->currentStatus = $this->currentStatus ?: self::$status['SUBMITTED'];
		$this->currentPaymentType = $this->currentPaymentType ?: self::$paymentType['CREDIT'];
		$this->for = $this->for ?: '';
		$this->amount = $this->amount ?: '';
		$this->firstName = $this->firstName ?: '';
		$this->middleName = $this->middleName ?: '';
		$this->lastName = $this->lastName ?: '';
		$this->phone = $this->phone ?: '';
		$this->email = $this->email ?: '';
		$this->address1 = $this->address1 ?: '';
		$this->address2 = $this->address2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
		$this->postalCode = $this->postalCode ?: '';
		$this->country = $this->country ?: '';
		$this->memberId = $this->memberId ?: new \stdClass();
		$this->paymentId = $this->paymentId ?: new \stdClass();
		$this->timeZone = $this->timeZone ?: 'America/New_York';
		$this->userAgent = $this->userAgent ?: '';
		
	}
	
	public function saveEdit(){
		$this->saveSafe();
		return $this->_id;
	}
	
	public function fetch($offset=0,$limit=100,$filter=array()){
		$query = array();
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByStatus($status, $offset=0,$limit=100,$filter=array()){
		$query = array('currentStatus'=>self::$status[$status]);
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		//error_log('query fetchByStatus:'.print_r($query,true));
		$fields = array();
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('submittedDate.date'=>-1);
				break;
			case 'PAID':
				$sort=array('paidDate.date'=>-1);
				break;
			default:
				$sort=array('_id'=>-1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		// include the member payment record
		for ($i=0; $i < count($result); $i++) { 
			$member = new Member(array('_id'=>$result[$i]['memberId']),self::$app);
			$member = $member->findById();
			if(!empty($member) && is_array($member))
				$result[$i]['member'] = $member;
		}

		return $result;

	}
	
	public function fetchByDatePaid($days=90, $offset=0,$limit=100,$filter=array()){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-'.$days.' day')))
		);
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('paidDate.date'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));

		// include the member payment record
		for ($i=0; $i < count($result); $i++) { 
			$member = new Member(array('_id'=>$result[$i]['memberId']),self::$app);
			$member = $member->findById();
			if(!empty($member) && is_array($member))
				$result[$i]['member'] = $member;
		}
		
		return $result;

	}
	public function countByDatePaid($days=90, $filter=array()){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-'.$days.' day')))
		);
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$result = $this->count($query,$slaveOkay=true);
		return $result;

	}
	public function markPaid($paymentId){

		$this->paidDate = new Date(self::$app,'now');
		$this->currentStatus = self::$status['PAID'];
		$this->saveSafe();
				
		return true;
	}
		
}