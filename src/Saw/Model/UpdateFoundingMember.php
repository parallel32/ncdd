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
class UpdateFoundingMember extends Apply {
	
	public $type = 'UPDATE FOUNDING MEMBER APPLICATION';
	public $class = 'UpdateFoundingMember';
	public $inGoodStanding;
	public $inGoodStandingExplain;
	public $listedOnWebsite;
	public $futureMailings;
	public $executed;
	public $executedPrintedName;
	public $contributionAmount;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('inGoodStanding', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('listedOnWebsite', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('futureMailings', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('executed', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('executedPrintedName', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addConstraint(new Callback(array('methods' => array('explain'),'groups' => array('update_member'))));
	}
	public function explain(ExecutionContext $context){
		if($this->inGoodStanding == 'no' && empty($this->inGoodStandingExplain)){
			$propertyPath = $context->getPropertyPath().'inGoodStandingExplain';
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
        $this->inGoodStanding = $doc['inGoodStanding'];
		$this->inGoodStandingExplain = $doc['inGoodStandingExplain'];
		$this->listedOnWebsite = $doc['listedOnWebsite'];
		$this->futureMailings = $doc['futureMailings'];
		$this->executed = (!empty($doc['executed']) && strpos($doc['executed'], 'Executed at') === false) ? $this->prepareExecuted($doc['executed']) : $doc['executed'];
		$this->executedPrintedName = $doc['executedPrintedName'];
		$this->contributionAmount = $doc['contributionAmount'];
		

	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
		$this->type = $this->type ?: 'UPDATE FOUNDING MEMBER APPLICATION';
		$this->class = $this->class ?: 'UpdateFoundingMember';
		$this->inGoodStanding = $this->inGoodStanding ?: '';
		$this->inGoodStandingExplain = $this->inGoodStandingExplain ?: '';
		$this->listedOnWebsite = $this->listedOnWebsite ?: '';
		$this->futureMailings = $this->futureMailings ?: '';
		$this->executed = $this->executed ?: '';
		$this->executedPrintedName = $this->executedPrintedName ?: '';
		$this->contributionAmount = $this->contributionAmount ?: 0;
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
		
		$renewal = new Renewal($member['renewal'],self::$app);
		$renewal->setRenewalByMember($member['_id']);

		$this->currentStatus = self::$status['APPROVED'];
		$this->approvedDate = new Date(self::$app,'now', $this->timeZone);
		$this->saveSafe();

		
		return $member;
	}
	
	public function remove(){

		$renewal = new Renewal(array(),self::$app);
		$renewal->prepareInsert();
		$renewal->setRenewalByMember($this->memberId);

		return parent::remove();
	}

}