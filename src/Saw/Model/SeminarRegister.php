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
	
	static public $status = array('ON'=>10, 'OFF'=>15);
	static public $statusReversed = array(10=>'ON',15=>'OFF');
	public $currentStatus;
	public $memberPrice;
	public $nonMemberPrice;
	public $hardCopyPrice;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidPrice'),
        )));   
	}
	/**
	 * validator helper function
	*/
	public function isValidPrice(ExecutionContext $context){
		if(!empty($this->memberPrice) && !is_int($this->memberPrice)){
            $propertyPath = $context->getPropertyPath().'memberPrice';
        	$context->addViolationAtPath($propertyPath,'Only integers are accepted.', array(), null);
		}
		if(!empty($this->nonMemberPrice) && !is_int($this->nonMemberPrice)){
            $propertyPath = $context->getPropertyPath().'nonMemberPrice';
        	$context->addViolationAtPath($propertyPath,'Only integers are accepted.', array(), null);
		}
		if(!empty($this->hardCopyPrice) && !is_int($this->hardCopyPrice)){
            $propertyPath = $context->getPropertyPath().'hardCopyPrice';
        	$context->addViolationAtPath($propertyPath,'Only integers are accepted.', array(), null);
		}
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->currentStatus = (int)$doc['currentStatus'];
		$this->memberPrice = (!empty($doc['memberPrice'])) ? (int)$doc['memberPrice']: '';
		$this->nonMemberPrice = (!empty($doc['nonMemberPrice'])) ? (int)$doc['nonMemberPrice']: '';
		$this->hardCopyPrice = (!empty($doc['hardCopyPrice'])) ? (int)$doc['hardCopyPrice']: '';
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['OFF'];
		$this->memberPrice = $this->memberPrice ?: '';
		$this->nonMemberPrice = $this->nonMemberPrice ?: '';
		$this->hardCopyPrice = $this->hardCopyPrice ?: '';
	}
	
	public function saveEdit(){
		$this->saveSafe();
		return $this->_id;
	}
	
	
}