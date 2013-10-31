<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Trial Model.
 * This is a concrete class
 * This class belongs to Apply and defines the trial membership.
 */
class Trial extends Model {
	
	public $referredBy;
	public $timeZone='America/New_York';
	public $startDate;
	public $endDate;
	static public $status = array('ACTIVE'=>1,'EXPIRED'=>10);
	static public $statusReversed = array(1=>'ACTIVE',10=>'EXPIRED');
	public $currentStatus;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('referredBy', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('timeZone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('startDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('endDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidStartDate'),
        )));   
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidExpirationDate'),
        )));
	}
	/**
	 * validator helper function
	*/
	public function isValidStartDate(ExecutionContext $context){
		$date = '';
		if(is_object($this->startDate)){
			$date = $this->startDate->checkError;
		}
		if(is_array($this->startDate)){
			$date = $this->startDate['checkError'];
		}
		if(strpos($date,'1969-12-31') !== false){
            $propertyPath = $context->getPropertyPath().'startDate';
        	$context->addViolationAtPath($propertyPath,'Could not compute a valid start date. Please try again.', array(), null);
		}
		// start date sanity check .. can't be after expiration date
		if(!empty($date) && !empty($this->endDate)){
			$s_epoch = strtotime($date);
			$e_epoch = null;
			if(is_object($this->endDate)){
				$e_epoch = strtotime($this->endDate->checkError);
			}else if(is_array($this->endDate)){
				$e_epoch = strtotime($this->endDate['checkError']);
			}
			if(!empty($e_epoch)){
				$result = $e_epoch - $s_epoch;
				if($result < 0){
					$propertyPath = $context->getPropertyPath().'startDate';
		        	$context->addViolationAtPath($propertyPath,'Start Date cannot be after End Date.', array(), null);
				}
			}
		}
	}
	/**
	 * validator helper function
	*/
	public function isValidExpirationDate(ExecutionContext $context){
		$date = '';
		if(is_object($this->endDate)){
			$date = $this->endDate->checkError;
		}
		if(is_array($this->endDate)){
			$date = $this->endDate['checkError'];
		}
		if(strpos($date,'1969-12-31') !== false){
            $propertyPath = $context->getPropertyPath().'endDate';
        	$context->addViolationAtPath($propertyPath,'Could not compute a valid expiration date. Please try again.', array(), null);
		}
		
		// expiration date sanity check .. can't be before start date
		if(!empty($date) && !empty($this->startDate)){
			$e_epoch = strtotime($date);
			$s_epoch = null;
			if(is_object($this->startDate)){
				$s_epoch = strtotime($this->startDate->checkError);
			}else if(is_array($this->startDate)){
				$s_epoch = strtotime($this->startDate['checkError']);
			}
			if(!empty($s_epoch)){
				$result = $e_epoch - $s_epoch;
				if($result < 0){
					$propertyPath = $context->getPropertyPath().'endDate';
		        	$context->addViolationAtPath($propertyPath,'End Date cannot be before Start Date.', array(), null);
				}
			}
		}
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->currentStatus = (empty($doc['currentStatus'])) ? self::$status['ACTIVE']: $doc['currentStatus'];
		$this->referredBy = $doc['referredBy'];
        $this->timeZone = $doc['timeZone'];
        $this->startDate = (!empty($doc['startDate'])) ? (is_object($doc['startDate'])) ? $doc['startDate']->__toArray() : new Date(self::$app,$doc['startDate'], $this->timeZone)  : $doc['startDate'];
		$this->endDate = (!empty($doc['endDate'])) ? (is_object($doc['endDate'])) ? $doc['endDate']->__toArray() : new Date(self::$app,$doc['endDate'], $this->timeZone)  : $doc['endDate'];
	}
	
	
}