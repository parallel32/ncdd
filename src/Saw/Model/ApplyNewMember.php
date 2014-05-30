<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Extends Apply Model.  Used to facilitate the new member application and does not represent a mongo collection
 */
class ApplyNewMember extends Apply {
	
	public $type = 'NEW MEMBER APPLICATION';
	public $class = 'ApplyNewMember';
	public $hearAboutNCDD;
	public $yearsInLawPractice;
	public $percentDUIDefense;
	public $juryTrialsAvailableInYourState;
	public $numberDUITrialsHandeled;
	public $numberNonDUITrialsHandeled;
	public $everBeenArrested;
	public $everBeenArrestedExplain;
	public $everChargedByBar;
	public $everChargedByBarExplain;
	public $everConvictedCrime;
	public $everConvictedCrimeExplain;
	public $everInvestigation;
	public $everInvestigationExplain;
	public $everLawEnforcement;
	public $everLawEnforcementExplain;
	public $futureLawEnforcement;
	public $futureLawEnforcementExplain;
	public $licensedInUSAAustraliaCanada;
	public $licensedInUSAAustraliaCanadaExplain;
	public $executed;
	public $executedPrintedName;
	public $executedPrintedNameDate;
	public $authorizationReleasePrintedName;
	public $authorizationReleasePrintedNameDate;
	public $referenceFormDownload;

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('hearAboutNCDD', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('yearsInLawPractice', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('percentDUIDefense', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('juryTrialsAvailableInYourState', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('numberDUITrialsHandeled', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('numberNonDUITrialsHandeled', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('everBeenArrested', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('everChargedByBar', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('everConvictedCrime', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everInvestigation', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addPropertyConstraint('futureLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('licensedInUSAAustraliaCanada', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('executed', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('executedPrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('membershipDues', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('authorizationReleasePrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array('methods' => array('explain'))));
		/* dependency replaced by automated reference form
		$metadata->addConstraint(new Callback(array('methods' => array('referenceFormDownload'))));
		*/
	}
	public function explain(ExecutionContext $context){
		if($this->everInvestigation == 'no' && empty($this->everInvestigationExplain)){
			$propertyPath = $context->getPropertyPath().'everInvestigationExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->everLawEnforcement == 'no' && empty($this->everLawEnforcementExplain)){
			$propertyPath = $context->getPropertyPath().'everLawEnforcementExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->licensedInUSAAustraliaCanada == 'no' && empty($this->licensedInUSAAustraliaCanadaExplain)){
			$propertyPath = $context->getPropertyPath().'licensedInUSAAustraliaCanadaExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		
		/* commented out in preparation for the newly updated reference form
		if($this->everBeenArrested == 'yes' && empty($this->everBeenArrestedExplain)){
			$propertyPath = $context->getPropertyPath().'everBeenArrestedExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->everChargedByBar == 'yes' && empty($this->everChargedByBarExplain)){
			$propertyPath = $context->getPropertyPath().'everChargedByBarExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->everConvictedCrime == 'yes' && empty($this->everConvictedCrimeExplain)){
			$propertyPath = $context->getPropertyPath().'everConvictedCrimeExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		*/
		/* commented out by request from Rhea to make this question simply a yes or no answer.
		if($this->futureLawEnforcement == 'yes' && empty($this->futureLawEnforcementExplain)){
			$propertyPath = $context->getPropertyPath().'futureLawEnforcementExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}*/

	}
	/* dependency replaced by automated reference form
	public function referenceFormDownload(ExecutionContext $context){
		if($this->referenceFormDownload == 'no'){
			$propertyPath = $context->getPropertyPath().'referenceFormDownload';
			$context->addViolationAtPath($propertyPath,'Please confirm you have downloaded the Reference form.', array(), null);
		}
	}
	*/
	public function __construct($doc, Application $app){
		parent::__construct($doc,$app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->hearAboutNCDD = $doc['hearAboutNCDD'];
		$this->yearsInLawPractice = $doc['yearsInLawPractice'];
		$this->percentDUIDefense = $doc['percentDUIDefense'];
		$this->juryTrialsAvailableInYourState = $doc['juryTrialsAvailableInYourState'];
		$this->numberDUITrialsHandeled = $doc['numberDUITrialsHandeled'];
		$this->numberNonDUITrialsHandeled = $doc['numberNonDUITrialsHandeled'];
		$this->everBeenArrested = $doc['everBeenArrested'];
		$this->everBeenArrestedExplain = $doc['everBeenArrestedExplain'];
		$this->everChargedByBar = $doc['everChargedByBar'];
		$this->everChargedByBarExplain = $doc['everChargedByBarExplain'];
		$this->everConvictedCrime = $doc['everConvictedCrime'];
		$this->everConvictedCrimeExplain = $doc['everConvictedCrimeExplain'];
		$this->everInvestigation = $doc['everInvestigation'];
		$this->everInvestigationExplain = $doc['everInvestigationExplain'];
		$this->everLawEnforcement = $doc['everLawEnforcement'];
		$this->everLawEnforcementExplain = $doc['everLawEnforcementExplain'];
		$this->futureLawEnforcement = $doc['futureLawEnforcement'];
		$this->licensedInUSAAustraliaCanada = $doc['licensedInUSAAustraliaCanada'];
		$this->licensedInUSAAustraliaCanadaExplain = $doc['licensedInUSAAustraliaCanadaExplain'];
		$this->futureLawEnforcementExplain = $doc['futureLawEnforcementExplain'];
		$this->executed = (!empty($doc['executed']) && strpos($doc['executed'], 'Executed at') === false) ? $this->prepareExecuted($doc['executed']) : $doc['executed'];
		$this->executedPrintedName = $doc['executedPrintedName'];
		$this->executedPrintedNameDate = $doc['executedPrintedNameDate'];
		$this->authorizationReleasePrintedName = $doc['authorizationReleasePrintedName'];
		$this->authorizationReleasePrintedNameDate = $doc['authorizationReleasePrintedNameDate'];
		$this->referenceFormDownload = $doc['referenceFormDownload'];

	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
		$this->type = $this->type ?: 'NEW MEMBER APPLICATION';
		$this->class = $this->class ?: 'ApplyNewMember';
		$this->hearAboutNCDD = $this->hearAboutNCDD ?: '';
		$this->yearsInLawPractice = $this->yearsInLawPractice ?: '';
		$this->percentDUIDefense = $this->percentDUIDefense ?: '';
		$this->juryTrialsAvailableInYourState = $this->juryTrialsAvailableInYourState ?: '';
		$this->numberDUITrialsHandeled = $this->numberDUITrialsHandeled ?: '';
		$this->numberNonDUITrialsHandeled = $this->numberNonDUITrialsHandeled ?: '';
		$this->everBeenArrested = $this->everBeenArrested ?: '';
		$this->everBeenArrestedExplain = $this->everBeenArrestedExplain ?: '';
		$this->everChargedByBar = $this->everChargedByBar ?: '';
		$this->everChargedByBarExplain = $this->everChargedByBarExplain ?: '';
		$this->everConvictedCrime = $this->everConvictedCrime ?: '';
		$this->everConvictedCrimeExplain = $this->everConvictedCrimeExplain ?: '';
		$this->everInvestigation = $this->everInvestigation ?: '';
		$this->everInvestigationExplain = $this->everInvestigationExplain ?: '';
		$this->everLawEnforcement = $this->everLawEnforcement ?: '';
		$this->licensedInUSAAustraliaCanada = $this->licensedInUSAAustraliaCanada ?: '';
		$this->licensedInUSAAustraliaCanadaExplain = $this->licensedInUSAAustraliaCanadaExplain ?: '';
		$this->everLawEnforcementExplain = $this->everLawEnforcementExplain ?: '';
		$this->futureLawEnforcement = $this->futureLawEnforcement ?: '';
		$this->futureLawEnforcementExplain = $this->futureLawEnforcementExplain ?: '';
		$this->executed = $this->executed ?: '';
		$this->executedPrintedName = $this->executedPrintedName ?: '';
		$this->executedPrintedNameDate = $this->executedPrintedNameDate ?: '';
		$this->authorizationReleasePrintedName = $this->authorizationReleasePrintedName ?: '';
		$this->authorizationReleasePrintedNameDate = $this->authorizationReleasePrintedNameDate ?: '';
		$this->referenceFormDownload = $this->referenceFormDownload ?: '';
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	private function prepareExecuted($executed){
		 $date = new \DateTime(); 
		 $day = $date->format('dS');
		 $month = $date->format('F');
		 $year = $date->format('y');
		 return "Executed at ".$executed.', this '.$day.' day of '.$month.', 20'.$year;
	}

	public function approve($trial=false){
		// prepare member record
		$password = substr(time(),-4);
		$mem_doc['password'] = $password;
		$mem_doc['firstName'] = $this->firstName;
		$mem_doc['middleName'] = $this->middleName;
		$mem_doc['lastName'] = $this->lastName;
		$mem_doc['barNumber'] = $this->barNumber;
		$mem_doc['email'] = $this->email;
		$mem_doc['primaryPhone'] = $this->phone;
		$mem_doc['primaryFax'] = $this->fax;
		$mem_doc['websites'] = array(array('websiteDesc'=>'','website'=>Member::parseWebsite($this->website)));
		if($trial){
			$mem_doc['listed'] = 1;
			$mem_doc['accessLevel'] = MEMBER;
		}
		if(intval($this->membershipDues) == 50){
			$mem_doc['currentMembership'] = Member::$membership['PUBLIC DEFENDER'];
			$mem_doc['currentOrder'] = Member::$order['PUBLIC DEFENDER'];	
		}
		
		
		// prepare location record
		$loc_doc['raw'] = $this->formattedAddress;
		$loc_doc['name'] = 'primary';
		$loc_doc['point'] = array($this->lon, $this->lat);
		$loc_doc['addressLine1'] = $this->address1;
		$loc_doc['addressLine2'] = $this->address2;
		$loc_doc['city'] = $this->city;
		$loc_doc['state'] = $this->state;
		$loc_doc['zip'] = $this->postalCode;
		$loc_doc['country'] = $this->country;
		$loc_doc['phone'] = $this->phone;
		$loc_doc['fax'] = $this->fax;
		$location = new Location($loc_doc, self::$app);

		$member = new Member($mem_doc, self::$app, $location);
		$mem_id = $member->insert();
		$member->password = $password;

		$location->member = $member->__toArray(false);
		$location->ownerId = $mem_id;
		$location->insert();

		// update record to approved status
		if($trial){
			$this->currentStatus = self::$status['TRIAL'];
		}else{
			$this->currentStatus = self::$status['APPROVED'];
			$this->approvedDate = new Date(self::$app,'now', $this->timeZone);
		}
		
		$this->memberId = $mem_id;
		$this->saveSafe();

		return $member;
	}

	public function trial(){
		return $this->approve($trial=true);
	}

}