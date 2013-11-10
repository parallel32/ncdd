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
	public $hardCopyFee;
	public $total;
	public $seminarId;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('nameTag', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('barNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('rsvp', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('attendanceCertificationStatement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	public function __construct($doc, Application $app){
		parent::__construct($doc,$app);
		$this->init($doc);
		
		$this->nameTag = $doc['nameTag'];
		$this->barNumber = (string)$doc['barNumber'];
		$this->rsvp = (string)$doc['rsvp'];
		$date = new \DateTime();
		$acs_text = ', on this '.$date->format('dS').' day of '.$date->format('F').', 20'.$date->format('y');
		$this->attendanceCertificationStatement = (!empty($doc['attendanceCertificationStatement']))  ? $doc['attendanceCertificationStatement'].$acs_text : '';
		$this->hardCopy = $doc['hardCopy'];
		$this->registrationFee = $doc['registrationFee'];
		$this->hardCopyFee = $doc['hardCopyFee'];
		$this->total = $doc['total'];
		if(!empty($doc['seminarId'])) $this->seminarId = (is_object($doc['seminarId'])) ? $doc['seminarId'] : new \MongoId($doc['seminarId']);
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
		$this->hardCopyFee = $this->hardCopyFee ?: 0;
		$this->total = $this->total ?: 0;
		$this->seminarId = $this->seminarId ?: new \stdClass();
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
	
		
}