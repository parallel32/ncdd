<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Apply Model.
 * This class is the base class for all scholarship-type forms to be submitted.
 */
class Scholarship extends Model {
	
	public $collection = 'scholarship';
	static public $status = array('SUBMITTED'=>10, 'APPROVED'=>20);
	static public $statusReversed = array(10=>'SUBMITTED',20=>'APPROVED');
	public $currentStatus;
	public $for;
	public $name;
	public $phone;
	public $fax;
	public $barNumber;
	public $email;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $postalCode;
	public $country;
	public $yearsInLawPractice;
	public $yearsInNCDD;
	public $numberDUITrialsHandeled;
	public $everBeenArrested;
	public $everBeenArrestedExplain;
	public $everInvestigation;
	public $everInvestigationExplain;
	public $everLawEnforcement;
	public $everLawEnforcementExplain;
	public $reasonForScholarship;
	public $submittedDate;
	public $approvedDate;
	public $registrationNumber;
	public $timeZone='America/New_York';

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('for', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('phone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('barNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addPropertyConstraint('address1', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('state', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('postalCode', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('yearsInLawPractice', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('yearsInNCDD', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('numberDUITrialsHandeled', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everBeenArrested', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everInvestigation', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('reasonForScholarship', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array('methods' => array('explain'))));
	}
	public function explain(ExecutionContext $context){
		if($this->everBeenArrested == 'yes' && empty($this->everBeenArrestedExplain)){
			$propertyPath = $context->getPropertyPath().'everBeenArrestedExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->everInvestigation == 'yes' && empty($this->everInvestigationExplain)){
			$propertyPath = $context->getPropertyPath().'everInvestigationExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->everLawEnforcement == 'yes' && empty($this->everLawEnforcementExplain)){
			$propertyPath = $context->getPropertyPath().'everLawEnforcementExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}


	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->currentStatus = $doc['currentStatus'];
    	$this->for = $doc['for'];
		$this->name = $doc['name'];
		$this->phone = $doc['phone'];
		$this->fax = $doc['fax'];
		$this->barNumber = (string)$doc['barNumber'];
		$this->email = $doc['email'];
		$this->address1 = $doc['address1'];
		$this->address2 = $doc['address2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
		$this->postalCode = $doc['postalCode'];
		$this->country = $doc['country'];
		$this->yearsInLawPractice = $doc['yearsInLawPractice'];
		$this->yearsInNCDD = $doc['yearsInNCDD'];
		$this->numberDUITrialsHandeled = $doc['numberDUITrialsHandeled'];
		$this->everBeenArrested = $doc['everBeenArrested'];
		$this->everBeenArrestedExplain = $doc['everBeenArrestedExplain'];
		$this->everInvestigation = $doc['everInvestigation'];
		$this->everInvestigationExplain = $doc['everInvestigationExplain'];
		$this->everLawEnforcement = $doc['everLawEnforcement'];
		$this->everLawEnforcementExplain = $doc['everLawEnforcementExplain'];
		$this->reasonForScholarship = $doc['reasonForScholarship'];
		$this->submittedDate = $doc['submittedDate'];
		$this->approvedDate = $doc['approvedDate'];
		$this->registrationNumber = $doc['registrationNumber'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->submittedDate = new Date(self::$app, 'now');
		$this->approvedDate = $this->approvedDate ?: new \stdClass();
		$this->currentStatus = $this->currentStatus ?: self::$status['SUBMITTED'];
		$this->for = $this->for ?: '';
		$this->name = $this->name ?: '';
		$this->phone = $this->phone ?: '';
		$this->fax = $this->fax ?: '';
		$this->barNumber = $this->barNumber ?: '';
		$this->email = $this->email ?: '';
		$this->address1 = $this->address1 ?: '';
		$this->address2 = $this->address2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
		$this->postalCode = $this->postalCode ?: '';
		$this->country = $this->country ?: '';
		$this->yearsInLawPractice = $this->yearsInLawPractice ?: '';
		$this->yearsInNCDD = $this->yearsInNCDD ?: '';
		$this->numberDUITrialsHandeled = $this->numberDUITrialsHandeled ?: '';
		$this->everBeenArrested = $this->everBeenArrested ?: '';
		$this->everBeenArrestedExplain = $this->everBeenArrestedExplain ?: '';
		$this->everInvestigation = $this->everInvestigation ?: '';
		$this->everInvestigationExplain = $this->everInvestigationExplain ?: '';
		$this->everLawEnforcement = $this->everLawEnforcement ?: '';
		$this->everLawEnforcementExplain = $this->everLawEnforcementExplain ?: '';
		$this->reasonForScholarship = $this->reasonForScholarship ?: '';
		$this->timeZone = $this->timeZone ?: 'America/New_York';
		$this->registrationNumber = $this->registrationNumber ?: '';
	}
	
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
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
	public function checkEmailExists(){
		$query = array('email'=>trim(strtolower($this->email)));
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
		$fields = array('name'=>true
						,'for'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'timeZone'=>true
						,'registrationNumber'=>true
						);
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
		$fields = array('name'=>true
						,'for'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'timeZone'=>true
						,'registrationNumber'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('submittedDate.date'=>-1);
				break;
			case 'APPROVED':
				$sort=array('approvedDate.date'=>-1);
				break;
			default:
				$sort=array('_id'=>-1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
		
	public function approve(){

		$this->approvedDate = new Date(self::$app,'now', $this->timeZone);
		$this->registrationNumber = $password = substr(time(),-4);
		$this->saveSafe();

		return true;
	}
		
}