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
	public $renewalpromocode;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('everBeenArrested', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everChargedByBar', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everConvictedCrime', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everInvestigation', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('everLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('futureLawEnforcement', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('twoSeminarsAcknowledgement', new Constraints\NotBlank(array('message'=>'please acknowledge','groups' => array('update_member'))));
		//$metadata->addPropertyConstraint('seminarAttendance', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('executed', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('executedPrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('membershipDues', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addConstraint(new Callback(array('methods' => array('explain'),'groups' => array('update_member'))));
		$metadata->addConstraint(new Callback(array('methods' => array('termsAckValidate'),'groups' => array('update_member'))));
		$metadata->addConstraint(new Callback(array('methods' => array('checkPayByCheck'),'groups' => array('update_member'))));
	}
	public function checkPayByCheck(ExecutionContext $context){
		// if valid promo code and eligble then cannot submit as a pay by check
		$is_eligible = $this->checkPromoCodeEligibility();

		if($is_eligible && ($this->payByCheck == 'yes' || $this->payByCheck == 'no-store')){
			$propertyPath = $context->getPropertyPath().'payByCheck';
			$context->addViolationAtPath($propertyPath,'When using the RENEW2016 promo code you cannot pay with a check. You must enter a credit card.  If you want to pay by check, please clear out the promo code first then select to pay by check.', array(), null);
		}
	}
	public function termsAckValidate(ExecutionContext $context){
		// first check if they entered a promocode && if they're authorized to use it and if so then they must check the acknowledgement
		$is_eligible = $this->checkPromoCodeEligibility();
		if($is_eligible && (empty($this->termsAcknowledgement) || $this->termsAcknowledgement == false || $this->termsAcknowledgement == 'no')){
			$propertyPath = $context->getPropertyPath().'termsAcknowledgement';
			$context->addViolationAtPath($propertyPath,'When using the RENEW2016 promo code you must agree to this authorization', array(), null);
		}
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
		$this->renewalpromocode = (array_key_exists('renewalpromocode', $doc) && !empty($doc['renewalpromocode'])) ? strtoupper($doc['renewalpromocode']) : $doc['renewalpromocode'];
		

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
		$this->renewalpromocode = $this->renewalpromocode ?: '';
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	private function checkPromoCodeEligibility(){
		$is_eligible = true;
		if(!empty($this->renewalpromocode) && (strtoupper($this->renewalpromocode) == 'RENEW2016')){
	    	if(!empty($this->_id)){
	    		$tmp = new Apply(array('_id'=>$this->_id),self::$app);
	    		$tmp = $tmp->findById();
	    		$memberId = $tmp['memberId'];
	    	}else{
	    		$memberId = $this->memberId;	
	    	}
			
			$valid = 'yes';
	    	$message = 'Valid Promo Code.';
	    	// is member eligible? - meaning is it their first time subscribing to auto-renew?
	    	// if part of the EAGLE2016 promo then not eligible
	    	$application = new Apply(array(),self::$app);
			$eagle2016promocode = $application->fetchByStatus('PAID',$offset=0, $limit=10000,$filter=array('promocode'=>'EAGLE2016'));
			foreach ($eagle2016promocode as $record) {
				if((string)$record['memberId'] == $memberId){
					$is_eligible = false;
					$valid = 'no';
					$message = 'Sorry, you cannot use this promo because you already received the EAGLE2016 promo';
				}
			}
	    	// if have termsAcknowledge checked in last cycle's renewal form then not eligible
			$apply = new Apply(array(),self::$app);
			$query = array('termsAcknowledgement'=>'yes'
							,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
													,'$gte'=>new \MongoDate(strtotime('-395 day')))
			);
			$renewals = $apply->find($query,$fields=array('memberId'=>1,'termsAcknowledgement'=>1),$slaveOkay=true,$sort=array(),(int)$offset=0,(int)$limit=10000);

			foreach ($renewals as $record) {
				if($record['memberId'] == $memberId){
					error_log('found it: '.print_r('found it',true));
				}
				if($record['termsAcknowledgement'] == 'yes' && $record['memberId'] == $memberId){
					$is_eligible = false;
					$valid = 'no';
					$message = 'Sorry, you cannot use this promo because you already received a discount last time for signing up for auot-pay and we thank you for that!';
				}
			}

	    	// if a public defender then not eligible
			$member = new Member(array('_id'=>$memberId),self::$app);
			$member = $member->findById();
			if($member['currentMembership'] == Member::$membership['PUBLIC DEFENDER']){
				$is_eligible = false;
				$valid = 'no';
				$message = 'Sorry, you cannot us this promo because you are a pulbic defender';
			}
	    	
	    	$type = (strtoupper($this->renewalpromocode) == 'RENEW2016') ? 'discount'.'-'.strtoupper($this->renewalpromocode): '';
	    }else{
	    	$is_eligible = false;
	    	$type = '';
	    	$valid = 'no';
	    	$message = 'Invalid Promo Code.';
	    }
	    return $is_eligible;
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

		parent::updateMemberProfile($this->memberId);
		
		return $member;
	}
	
	public function markPaid($resetSession=true){
		parent::markPaid($resetSession);

		$member = new Member(array('_id'=>$this->memberId), self::$app);
		$member = $member->findById();

		$member['renewal']['currentStatus'] = Renewal::$status['PAID'];
		$member['renewal']['paidDate'] = new Date(self::$app, 'now', $this->timeZone); 
		$member['renewal']['paymentId'] = $this->paymentId; 
		if(!empty($this->payByCheck)){
			$member['renewal']['payByCheck'] = $this->payByCheck; 
		}
		
		$renewal = new Renewal($member['renewal'],self::$app);
		$renewal->setRenewalByMember($member['_id']);

		parent::updateMemberProfile($this->memberId);

	}
	
	public function remove(){

		$renewal = new Renewal(array(),self::$app);
		$renewal->prepareInsert();
		$renewal->setRenewalByMember($this->memberId);

		return parent::remove();
	}


}