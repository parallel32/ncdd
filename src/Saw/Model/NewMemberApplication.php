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
class NewMemberApplication extends Apply {
	
	public $type = 'NEW MEMBER APPLICATION';
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
	public $executed;
	public $executedPrintedName;
	public $membershipDues;
	public $authorizationReleasePrintedName;

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('hearAboutNCDD', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('yearsInLawPractice', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('percentDUIDefense', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('juryTrialsAvailableInYourState', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('numberDUITrialsHandeled', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('numberNonDUITrialsHandeled', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everBeenArrested', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everChargedByBar', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everConvictedCrime', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everInvestigation', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('everLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('futureLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('executed', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('executedPrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('membershipDues', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('authorizationReleasePrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array('methods' => array('explain'))));
	}
	public function explain(ExecutionContext $context){
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
		if($this->everInvestigation == 'yes' && empty($this->everInvestigationExplain)){
			$propertyPath = $context->getPropertyPath().'everInvestigationExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->everLawEnforcement == 'yes' && empty($this->everLawEnforcementExplain)){
			$propertyPath = $context->getPropertyPath().'everLawEnforcementExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		if($this->futureLawEnforcement == 'yes' && empty($this->futureLawEnforcementExplain)){
			$propertyPath = $context->getPropertyPath().'futureLawEnforcementExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}

	}
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
		$this->futureLawEnforcementExplain = $doc['futureLawEnforcementExplain'];
		$this->prepareExecuted($doc['executed']);
		$this->executedPrintedName = $doc['executedPrintedName'];
		$this->membershipDues = $doc['membershipDues'];
		$this->authorizationReleasePrintedName = $doc['authorizationReleasePrintedName'];


	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
		$this->type = $this->type ?: 'NEW MEMBER APPLICATION';
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
		$this->everLawEnforcementExplain = $this->everLawEnforcementExplain ?: '';
		$this->futureLawEnforcement = $this->futureLawEnforcement ?: '';
		$this->futureLawEnforcementExplain = $this->futureLawEnforcementExplain ?: '';
		$this->executed = $this->executed ?: '';
		$this->executedPrintedName = $this->executedPrintedName ?: '';
		$this->membershipDues = $this->membershipDues ?: '';
		$this->authorizationReleasePrintedName = $this->authorizationReleasePrintedName ?: '';
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
		 $this->executed = "Executed at ".$executed.', this '.$day.' day of '.$month.', 20'.$year;
	}
}