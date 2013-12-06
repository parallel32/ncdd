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
class UpdateMember extends Apply {
	
	public $type = 'UPDATE MEMBER APPLICATION';
	public $class = 'UpdateMember';
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
	public $seminarAttendance;
	public $seminarAttendanceExplain;
	public $executed;
	public $executedPrintedName;
	public $contributionAmount;
	public $firmName;
	public $payByCheck;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('everBeenArrested', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everChargedByBar', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everConvictedCrime', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everInvestigation', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('futureLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('seminarAttendance', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('executed', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('executedPrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('membershipDues', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addConstraint(new Callback(array('methods' => array('explain'),'groups' => array('update_member'))));
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
		if($this->seminarAttendance == 'yes' && empty($this->seminarAttendanceExplain)){
			$propertyPath = $context->getPropertyPath().'seminarAttendanceExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}
		/* commented out by request from Rhea to make this question simply a yes or no answer.
		if($this->futureLawEnforcement == 'yes' && empty($this->futureLawEnforcementExplain)){
			$propertyPath = $context->getPropertyPath().'futureLawEnforcementExplain';
			$context->addViolationAtPath($propertyPath,'Please explain your answer.', array(), null);
		}*/

	}
	public function __construct($doc, Application $app){
		parent::__construct($doc,$app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
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
		$this->seminarAttendance = $doc['seminarAttendance'];
		$this->seminarAttendanceExplain = $doc['seminarAttendanceExplain'];
		$this->executed = (!empty($doc['executed']) && strpos($doc['executed'], 'Executed at') === false) ? $this->prepareExecuted($doc['executed']) : $doc['executed'];
		$this->executedPrintedName = $doc['executedPrintedName'];
		$this->contributionAmount = $doc['contributionAmount'];
		$this->firmName = $doc['firmName'];
		$this->payByCheck = $doc['payByCheck'];
		

	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
		$this->type = $this->type ?: 'UPDATE MEMBER APPLICATION';
		$this->class = $this->class ?: 'UpdateMember';
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
		$this->seminarAttendance = $this->seminarAttendance ?: '';
		$this->seminarAttendanceExplain = $this->seminarAttendanceExplain ?: '';
		$this->executed = $this->executed ?: '';
		$this->executedPrintedName = $this->executedPrintedName ?: '';
		$this->contributionAmount = $this->contributionAmount ?: 0;
		$this->firmName = $this->firmName ?: '';
		$this->payByCheck = $this->payByCheck ?: '';
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

	public function approve(){
		

		$member = new Member(array('_id'=>$this->memberId), self::$app);
		$member = $member->findById();

		$member['renewal']['currentStatus'] = Renewal::$status['APPROVED'];
		$member['renewal']['approvedDate'] = new Date(self::$app, 'now', $this->timeZone); 
		$member['renewal']['payByCheck'] = $this->payByCheck; 
		
		$renewal = new Renewal($member['renewal'],self::$app);
		$renewal->setRenewalByMember($member['_id']);

		$this->currentStatus = self::$status['APPROVED'];
		$this->approvedDate = new Date(self::$app,'now', $this->timeZone);
		$this->saveSafe();

		
		return $member;
	}
	
	public function markPaid($resetSession=true){
		parent::markPaid($resetSession);

		$member = new Member(array('_id'=>$this->memberId), self::$app);
		$member = $member->findById();

		$member['renewal']['currentStatus'] = Renewal::$status['PAID'];
		$member['renewal']['paidDate'] = new Date(self::$app, 'now', $this->timeZone); 
		$member['renewal']['paymentId'] = $this->paymentId; 
		
		$renewal = new Renewal($member['renewal'],self::$app);
		$renewal->setRenewalByMember($member['_id']);

		

	}
	
	public function remove(){

		$renewal = new Renewal(array(),self::$app);
		$renewal->prepareInsert();
		$renewal->setRenewalByMember($this->memberId);

		return parent::remove();
	}


}