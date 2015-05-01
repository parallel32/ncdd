<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * SeminarRegister Model.
 * This class is nested in the Seminar Document and controls the activation of the Registration for the Seminar.
 */
class SeminarRegister extends Model {
	
	static public $status = array('ON'=>10, 'MEMBERSONLY'=>13, 'OFF'=>15);
	static public $statusReversed = array(10=>'ON', 13=>'MEMBERSONLY', 15=>'OFF');
	public $currentStatus;
	public $memberPrice;
	public $nonMemberPrice;
	public $hardCopyPrice;
	public $confirmationLetter;
	public $depositConfirmationLetter;
	public $scholarshipConfirmationLetter;
	public $scholarshipApprovedConfirmationLetter;
	public $deposit; // the amount for the initial deposit
	public $depositDueDate; // the due date for payment of the remainer of the deposit
	public $scholarship;
	public $rsvpQuestion; // on | off
	public $attendanceQuestion; // on | off
	public $rsvpKidsQuestion; // on | off
	public $maxRegistrations; // max number of registrations


	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidMaxRegistration'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('isValidPrice'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('isValidDeposit'),
        )));
	}

	/**
	 * validator helper function
	*/
	public function isValidMaxRegistration(ExecutionContext $context){
		
		if(!empty($this->maxRegistrations) && !is_numeric($this->maxRegistrations)){
            $propertyPath = $context->getPropertyPath().'depositDueDate';
        	$context->addViolationAtPath($propertyPath,'Only numbers are allowed.', array(), null);
		}
		
	}
	/**
	 * validator helper function
	*/
	public function isValidPrice(ExecutionContext $context){

		if( $this->currentStatus < self::$status['OFF'] ){
			if(empty($this->memberPrice)){
	            $propertyPath = $context->getPropertyPath().'memberPrice';
	        	$context->addViolationAtPath($propertyPath,'Since you intend to activate registration you must include a Member Price.', array(), null);
			}			
		}
		if( $this->currentStatus == self::$status['ON'] ){
			if(empty($this->nonMemberPrice)){
	            $propertyPath = $context->getPropertyPath().'nonMemberPrice';
	        	$context->addViolationAtPath($propertyPath,'Setting Registration to ON requires a non member price.', array(), null);
			}			
		}

		if(!empty($this->memberPrice) && !is_numeric($this->memberPrice)){
            $propertyPath = $context->getPropertyPath().'memberPrice';
        	$context->addViolationAtPath($propertyPath,'Only integers are accepted.', array(), null);
		}
		if(!empty($this->nonMemberPrice) && !is_numeric($this->nonMemberPrice)){
            $propertyPath = $context->getPropertyPath().'nonMemberPrice';
        	$context->addViolationAtPath($propertyPath,'Only integers are accepted.', array(), null);
		}
		if(!empty($this->hardCopyPrice) && !is_numeric($this->hardCopyPrice)){
            $propertyPath = $context->getPropertyPath().'hardCopyPrice';
        	$context->addViolationAtPath($propertyPath,"If you don't want to leave it blank, then only integers are accepted.", array(), null);
		}
		if(!empty($this->deposit) && !is_numeric($this->deposit)){
            $propertyPath = $context->getPropertyPath().'deposit';
        	$context->addViolationAtPath($propertyPath,"If you don't want to leave it blank, then only integers are accepted.", array(), null);
		}
	}
	/**
	 * validator helper function
	*/
	public function isValidDeposit(ExecutionContext $context){
		
		if(!empty($this->deposit) && empty($this->depositDueDate)){
            $propertyPath = $context->getPropertyPath().'depositDueDate';
        	$context->addViolationAtPath($propertyPath,'Need to have a due date for the deposit remainder.', array(), null);
		}
		
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->currentStatus = (int)$doc['currentStatus'];
		$this->memberPrice = (!empty($doc['memberPrice'])) ? (int)$doc['memberPrice']: '';
		$this->nonMemberPrice = (!empty($doc['nonMemberPrice'])) ? (int)$doc['nonMemberPrice']: '';
		$this->hardCopyPrice = (!empty($doc['hardCopyPrice'])) ? $doc['hardCopyPrice']: '';
		$this->confirmationLetter = $doc['confirmationLetter'];
		$this->depositConfirmationLetter = $doc['depositConfirmationLetter'];
		$this->scholarshipConfirmationLetter = $doc['scholarshipConfirmationLetter'];
		$this->scholarshipApprovedConfirmationLetter = $doc['scholarshipApprovedConfirmationLetter'];
		$this->deposit = $doc['deposit'];
        $this->depositDueDate = $doc['depositDueDate'];
        $this->scholarship = $doc['scholarship'];
        $this->rsvpQuestion = $doc['rsvpQuestion'];
        $this->attendanceQuestion = $doc['attendanceQuestion'];
        $this->rsvpKidsQuestion = $doc['rsvpKidsQuestion'];
        $this->maxRegistrations = $doc['maxRegistrations'];

	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['OFF'];
		$this->memberPrice = $this->memberPrice ?: '';
		$this->nonMemberPrice = $this->nonMemberPrice ?: '';
		$this->hardCopyPrice = $this->hardCopyPrice ?: '';
		$this->confirmationLetter = $this->confirmationLetter ?: '';
		$this->depositConfirmationLetter = $this->depositConfirmationLetter ?: '';
		$this->scholarshipConfirmationLetter = $this->scholarshipConfirmationLetter ?: '';
		$this->scholarshipApprovedConfirmationLetter = $this->scholarshipApprovedConfirmationLetter ?: '';
		$this->deposit = $this->deposit ?: '';
		$this->depositDueDate = $this->depositDueDate ?: '';
		$this->scholarship = $this->scholarship ?: '';
		$this->rsvpQuestion = $this->rsvpQuestion ?: 'yes';
		$this->attendanceQuestion = $this->attendanceQuestion ?: 'no';
		$this->rsvpKidsQuestion = $this->rsvpKidsQuestion ?: 'no';
		$this->maxRegistrations = $this->maxRegistrations ?: 'no';

	}
	
	public function saveEdit(){
		$this->saveSafe();
		return $this->_id;
	}
	
	
}