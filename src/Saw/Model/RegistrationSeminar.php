<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * RegistrationSeminar Model Extends Registration.
 * This class is the seminar registration model to handle the specific attributes.
 */
class RegistrationSeminar extends Registration {
	 
	public $type = 'NEW SEMINAR REGISTRATION';
	public $class = 'RegistrationSeminar';
	public $nameTag;
	public $barNumber;
	public $rsvp;
	public $attendanceCertificationStatement;
	public $hardCopy; // YES | NO
	public $registrationFee;
	public $registrationFeeOriginal;
	public $hardCopyFee;
	public $total;
	public $seminarId;
	public $previouslyAttended;
	public $previouslyAttendedExists;
	public $depositQuestion; // yes | no
	public $deposit; // the amount for the initial deposit
	public $depositDueDate; // the due date for payment of the remainer of the deposit
	public $registrationNumber; // the scholarship registration number

	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('nameTag', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('barNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('attendanceCertificationStatement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('previouslyAttended'),
        )));
	}
	public function previouslyAttended(ExecutionContext $context){
		
		if($this->previouslyAttendedExists == 'yes' && empty($this->previouslyAttended)){
			$propertyPath = $context->getPropertyPath().'previouslyAttended';
        	$context->addViolationAtPath($propertyPath,'Please enter how many times you have previously attended this seminar.', array(), null);
		}
		
	}
	
	public function __construct($doc, Application $app){
		$this->previouslyAttendedExists = (array_key_exists('previouslyAttended',$doc)) ? 'yes': 'no';
		parent::__construct($doc,$app);
		$this->init($doc);
		$this->nameTag = $doc['nameTag'];
		$this->barNumber = (string)$doc['barNumber'];
		$this->rsvp = (string)$doc['rsvp'];
		$date = new \DateTime();
		$acs_text = ', on this '.$date->format('dS').' day of '.$date->format('F').', 20'.$date->format('y');
		if(!empty($doc['attendanceCertificationStatement']) && strpos($doc['attendanceCertificationStatement'],'day of') === false){
			$this->attendanceCertificationStatement = $doc['attendanceCertificationStatement'].$acs_text;
		}else{
			$this->attendanceCertificationStatement = $doc['attendanceCertificationStatement'];
		}
		$this->hardCopy = $doc['hardCopy'];
		$this->registrationFee = $doc['registrationFee'];
		$this->registrationFeeOriginal = $doc['registrationFeeOriginal'];
		$this->hardCopyFee = $doc['hardCopyFee'];
		$this->total = $doc['total'];
		$this->previouslyAttended = $doc['previouslyAttended'];
		if(!empty($doc['seminarId'])) $this->seminarId = (is_object($doc['seminarId'])) ? $doc['seminarId'] : new \MongoId($doc['seminarId']);
		$this->deposit = $doc['deposit'];
        $this->depositDueDate = $doc['depositDueDate'];
        $this->depositQuestion = $doc['depositQuestion'];
        $this->registrationNumber = $doc['registrationNumber'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
		$this->nameTag = $this->nameTag ?: '';
		$this->barNumber = $this->barNumber ?: '';
		$this->rsvp = $this->rsvp ?: '';
		$this->attendanceCertificationStatement = $this->attendanceCertificationStatement ?: '';
		$this->hardCopy = $this->hardCopy ?: 'NO';
		$this->registrationFee = $this->registrationFee ?: 0;
		$this->registrationFeeOriginal = $this->registrationFeeOriginal ?: 0;
		$this->hardCopyFee = $this->hardCopyFee ?: 0;
		$this->total = $this->total ?: 0;
		$this->seminarId = $this->seminarId ?: new \stdClass();
		$this->previouslyAttended = $this->previouslyAttended ?: '';
		$this->deposit = $this->deposit ?: 0;
		$this->depositDueDate = $this->depositDueDate ?: new \stdClass();
		$this->depositQuestion = $this->depositQuestion ?: 'no';
		$this->registrationNumber = $this->registrationNumber ?: 'no';
	}
	
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Registration Failed due to a server.  Wait a moment and please try again.");
		}
	}
	public function markPaid(){

		$this->paidDate = new Date(self::$app,'now');
		$this->currentStatus = self::$status['PAID'];
		$this->saveSafe();

	}
	

	public function fetchByStatus($seminarId, $status, $offset=0,$limit=100){
		$seminarId = (is_object($seminarId)) ? $seminarId : new \MongoId($seminarId);
		$query = array('seminarId'=>$seminarId,'currentStatus'=>self::$status[$status]);
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
						,'seminarId'=>true
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
	
		
}