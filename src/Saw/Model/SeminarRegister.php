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
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidPrice'),
        )));
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
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->currentStatus = (int)$doc['currentStatus'];
		$this->memberPrice = (!empty($doc['memberPrice'])) ? (int)$doc['memberPrice']: '';
		$this->nonMemberPrice = (!empty($doc['nonMemberPrice'])) ? (int)$doc['nonMemberPrice']: '';
		$this->hardCopyPrice = (!empty($doc['hardCopyPrice'])) ? $doc['hardCopyPrice']: '';
		$this->confirmationLetter = $doc['confirmationLetter'];
		
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
	}
	
	public function saveEdit(){
		$this->saveSafe();
		return $this->_id;
	}
	
	
}