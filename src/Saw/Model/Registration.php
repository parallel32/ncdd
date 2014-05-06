<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Registration Model.
 * This class is the base class for all registration-type forms to be submitted.
 */
class Registration extends Model {
	
	public $collection = 'registration';
	static public $status = array('SUBMITTED'=>10,'DEPOSIT'=>20,'DEPOSITBALANCE'=>30,'PAID'=>40,'SCHOLARSHIP'=>50);
	static public $statusReversed = array(10=>'SUBMITTED',20=>'DEPOSIT',30=>'DEPOSITBALANCE',40=>'PAID',50=>'SCHOLARSHIP');
	public $currentStatus;
	static public $paymentType = array('CHECK'=>10,'CREDIT'=>40,'SCHOLARSHIP'=>60);
	static public $paymentTypeReversed = array(10=>'CHECK',40=>'CREDIT',60=>'SCHOLARSHIP');
	public $currentPaymentType;
	public $name;
	public $phone;
	public $fax;
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

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('phone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('fax', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addPropertyConstraint('address1', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('state', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('postalCode', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->currentStatus = $doc['currentStatus'];
        $this->currentPaymentType = $doc['currentPaymentType'];
		$this->name = $doc['name'];
		$this->phone = $doc['phone'];
		$this->fax = $doc['fax'];
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
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->submittedDate = new Date(self::$app, 'now');
		$this->paidDate = $this->paidDate ?: new \stdClass();
		$this->currentStatus = $this->currentStatus ?: self::$status['SUBMITTED'];
		$this->currentPaymentType = $this->currentPaymentType ?: self::$paymentType['CREDIT'];
		$this->name = $this->name ?: '';
		$this->phone = $this->phone ?: '';
		$this->fax = $this->fax ?: '';
		$this->email = $this->email ?: '';
		$this->address1 = $this->address1 ?: '';
		$this->address2 = $this->address2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
		$this->postalCode = $this->postalCode ?: '';
		$this->country = $this->country ?: '';
		$this->memberId = $this->memberId ?: new \stdClass();
		$this->paymentId = $this->paymentId ?: new \stdClass();
	}
	
	public function saveEdit(){
		$this->saveSafe();
		return $this->_id;
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
		$fields = array();// get all fields
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByStatus($status, $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status[$status]);
		$fields = array('name'=>true
						,'email'=>true
						,'phone'=>true
						,'currentStatus'=>true
						,'currentPaymentType'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
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
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByMember($status, $offset=0,$limit=100){
		$user = User::getUserAccessLevelBySession(self::$app);
		$query = array('currentStatus'=>self::$status[$status]
						,'memberId'=>$user['_id']);
		$fields = array('name'=>true
						,'email'=>true
						,'phone'=>true
						,'currentStatus'=>true
						,'currentPaymentType'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
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
		//error_log('fetch:'.print_r($query,true));
		return $result;

	}
	public function fetchByDatePaid($days=90, $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-'.$days.' day')))
		);
		$fields = array('name'=>true
						,'email'=>true
						,'phone'=>true
						,'currentStatus'=>true
						,'currentPaymentType'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('paidDate.date'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));
		return $result;

	}
	
	public function markPaid(){

		$result = $this->findOne(array('_id'=>$this->_id),array('currentStatus'=>1));
		//error_log('RegistrationSeminar markPaid result:'.print_r($result,true));
		// mark the record as paid
		$this->paidDate = new Date(self::$app,'now', 'America/New_York');
		if($result['currentStatus'] == self::$status['SUBMITTED']){
			$this->currentStatus = self::$status['PAID'];
			$this->saveSafe();	
		}		

	}
			
}