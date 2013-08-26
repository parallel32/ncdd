<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Apply Model.
 * This class is the base class for all application-type forms to be submitted.
 */
class Apply extends Model {
	
	public $collection = 'application';
	static public $status = array('DRAFT'=>0,'SUBMITTED'=>10, 'APPROVED'=>20, 'PAID'=>40);
	static public $statusReversed = array(0=>'DRAFT',10=>'SUBMITTED', 20=>'APPROVED', 40=>'PAID');
	public $currentStatus;
	public $firstName;
	public $lastName;
	public $phone;
	public $fax;
	public $barNumber;
	public $email;
	public $website;
	public $addToListServ;
	public $listServEmail;
	public $formattedAddress;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $postalCode;
	public $country;
	public $lat;
	public $lon;
	public $memberId;
	public $paymentId;
	public $submittedDate;
	public $paidDate;
	public $approvedDate;
	public $timeZone='America/New_York';

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('firstName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('lastName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('phone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('fax', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('barNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addPropertyConstraint('listServEmail', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addPropertyConstraint('website', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('addToListServ', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('formattedAddress', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('address1', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('state', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('postalCode', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('lat', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('lon', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array('methods' => array('listServ'))));
	}
	public function listServ(ExecutionContext $context){
		if($this->addToListServ == 'yes' && empty($this->listServEmail)){
			$propertyPath = $context->getPropertyPath().'listServEmail';
			$context->addViolationAtPath($propertyPath,'cannot be blank.', array(), null);
		}
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->currentStatus = $doc['currentStatus'];
		$this->firstName = $doc['firstName'];
		$this->lastName = $doc['lastName'];
		$this->phone = $doc['phone'];
		$this->fax = $doc['fax'];
		$this->barNumber = $doc['barNumber'];
		$this->email = $doc['email'];
		$this->website = $doc['website'];
		$this->addToListServ = $doc['addToListServ'];
		$this->listServEmail = $doc['listServEmail'];
		$this->formattedAddress = $doc['formattedAddress'];
		$this->address1 = $doc['address1'];
		$this->address2 = $doc['address2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
		$this->postalCode = $doc['postalCode'];
		$this->country = $doc['country'];
		$this->lat = $doc['lat'];
		$this->lon = $doc['lon'];
		$this->paidDate = $doc['paidDate'];
		$this->approvedDate = $doc['approvedDate'];
		if(!empty($doc['memberId'])) $this->memberId = (is_object($doc['memberId'])) ? $doc['memberId'] : new \MongoId($doc['memberId']);
		if(!empty($doc['paymentId'])) $this->paymentId = (is_object($doc['paymentId'])) ? $doc['paymentId'] : new \MongoId($doc['paymentId']);

	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->submittedDate = new Date(self::$app, 'now');
		$this->paidDate = $this->paidDate ?: new \stdClass();
		$this->approvedDate = $this->approvedDate ?: new \stdClass();
		$this->currentStatus = $this->currentStatus ?: self::$status['SUBMITTED'];
		$this->firstName = $this->firstName ?: '';
		$this->lastName = $this->lastName ?: '';
		$this->phone = $this->phone ?: '';
		$this->fax = $this->fax ?: '';
		$this->barNumber = $this->barNumber ?: '';
		$this->email = $this->email ?: '';
		$this->website = $this->website ?: '';
		$this->addToListServ = $this->addToListServ ?: '';
		$this->listServEmail = $this->listServEmail ?: '';
		$this->formattedAddress = $this->formattedAddress ?: '';
		$this->address1 = $this->address1 ?: '';
		$this->address2 = $this->address2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
		$this->postalCode = $this->postalCode ?: '';
		$this->country = $this->country ?: '';
		$this->lat = $this->lat ?: 33.7489;//atlanta
		$this->lon = $this->lon ?: 84.3881;//atlanta
		$this->memberId = $this->memberId ?: new \stdClass();
		$this->paymentId = $this->paymentId ?: new \stdClass();
		$this->timeZone = $this->timeZone ?: 'America/New_York';

	}
	
	public function findByEmail(){
		$query = array('email'=>trim(strtolower($this->email)));
        $fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			$this->_id = $result['_id'];
			return true;
		else:
			return false;
		endif;
	}

	public function fetch($offset=0,$limit=100){
		$query = array();
		$fields = array('firstName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByStatus($status, $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status[$status]);
		$fields = array('firstName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByMember($status, $offset=0,$limit=100){
		$user = User::getUserAccessLevelBySession(self::$app);
		$query = array('currentStatus'=>self::$status[$status]
						,'memberId'=>$user['_id']);
		$fields = array('firstName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		return $result;

	}
	public function fetchByDatePaid($days=90, $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-'.$days.' day')))
		);
		$fields = array('firstName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));
		return $result;

	}
	public function markPaid(){

		$this->paidDate = new Date(self::$app,'now', $this->timeZone);
		$this->currentStatus = self::$status['PAID'];
		$this->saveSafe();	

	}
	
}