<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Reference Model.
 * This class is the base class for all reference forms.
 */
class Reference extends Model {
	
	public $collection = 'reference';
	public $name;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $postalCode;
	public $country;
	public $phone;
	public $email;
	public $application;
	public $applicationId;
	public $submittedDate; // date the reference form was submitted
	public $timeZone='America/New_York';
	public $sittingJudge;
	public $licensedAttorney;
	public $substantialInvolvement;
	public $noProfessionalInquiry;
	public $personalComments;
	public $executed;
	public $executedDate;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('address1', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('state', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('postalCode', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('phone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addConstraint(new Callback(array('methods' => array('checkEmail'))));
		$metadata->addPropertyConstraint('executed', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('executedDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	/**
	 * validator helper function
	*/
	public function checkEmail(ExecutionContext $context){
		if(!empty($this->email)){
			if($this->emailExists()){
				$propertyPath = $context->getPropertyPath().'email';
	        	$context->addViolationAtPath($propertyPath,"We've detected that you have already submitted the reference form for this applicant.  If you believe this is an error, please contact support@ncdd.com.", array(), null);
	        }
	    }
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);

		$this->name = $doc['name'];
		$this->address1 = $doc['address1'];
		$this->address2 = $doc['address2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
		$this->postalCode = $doc['postalCode'];
		$this->country = $doc['country'];
		$this->phone = $doc['phone'];
		$this->email = $doc['email'];
		$this->submittedDate = $doc['submittedDate'];
		$this->application = (is_object($doc['application'])) ? $doc['application']->__toArray(false) : $doc['application'];
		if(!empty($doc['applicationId'])) $this->applicationId = (is_object($doc['applicationId'])) ? $doc['applicationId'] : new \MongoId($doc['applicationId']);
		$this->sittingJudge = $doc['sittingJudge'];
		$this->licensedAttorney = $doc['licensedAttorney'];
		$this->substantialInvolvement = $doc['substantialInvolvement'];
		$this->noProfessionalInquiry = $doc['noProfessionalInquiry'];
		$this->personalComments = $doc['personalComments'];
		$this->executed = $doc['executed'];
		$this->executedDate = $doc['executedDate'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->name = $this->name ?: '';
		$this->address1 = $this->address1 ?: '';
		$this->address2 = $this->address2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
		$this->postalCode = $this->postalCode ?: '';
		$this->country = $this->country ?: '';
		$this->phone = $this->phone ?: '';
		$this->email = $this->email ?: '';
		$this->submittedDate = new Date(self::$app, 'now');
		$this->timeZone = $this->timeZone ?: 'America/New_York';
		$this->application = $this->application ?: new \stdClass();
		$this->applicationId = $this->applicationId ?: new \stdClass();
		$this->sittingJudge = $this->sittingJudge ?: '';
		$this->licensedAttorney = $this->licensedAttorney ?: '';
		$this->substantialInvolvement = $this->substantialInvolvement ?: '';
		$this->noProfessionalInquiry = $this->noProfessionalInquiry ?: '';
		$this->personalComments = $this->personalComments ?: '';
		$this->executed = $this->executed ?: '';
		$this->executedDate = $this->executedDate ?: '';
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
	/**
	* this check if the email of the reference is already in the database in regards to the application.
	* this is also how the system knows how many unique reference forms have been submitted for each application
	*/
	public function emailExists(){
		
		$query = array('email'=>trim(strtolower($this->email)),'applicationId'=>$this->applicationId);
        $fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			return $result['_id'];
		else:
			return false;
		endif;
	}
	public function fetch($offset=0,$limit=100,$filter=array()){
		$query = array();
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$result = $this->find($query,array(),$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function getTotalSubmissions(){
		$query = array('applicationId'=>$this->applicationId);
		return $this->count($query,$slaveOkay=false);
	}
			
}