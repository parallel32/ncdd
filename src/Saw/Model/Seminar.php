<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Sessions and Seminars Model.
 * This is a concrete class.
 */
class Seminar extends Model {
	
	public $collection = 'seminar';
	public $headline;
	public $startDate;
	public $endDate;
	public $description;
	public $files; // array containing any files to be attached via upload.
	public $image; // image object

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('headline', new Constraints\NotBlank(array('message'=>'cannot be blank')));
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
		        	$context->addViolationAtPath($propertyPath,'Start Date cannot be after Expiration Date.', array(), null);
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
		        	$context->addViolationAtPath($propertyPath,'Expiration Date cannot be before Start Date.', array(), null);
				}
			}
		}
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->headline = $doc['headline'];
        $this->startDate = $doc['startDate'];
        $this->endDate = $doc['endDate'];
        $this->description = $doc['descriptino'];
        $this->files = $doc['files'];
        $this->image = (is_object($doc['image'])) ? $doc['image']->__toArray() : $doc['image'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->headline = $this->headline ?: '';
		$this->startDate = (!empty($this->startDate)) ? (is_object($this->startDate)) ? $this->startDate->__toArray() : $this->startDate  : new Date(self::$app,'now');
		$this->endDate = (!empty($this->endDate)) ? (is_object($this->endDate)) ? $this->endDate->__toArray() : $this->endDate  : new Date(self::$app,'now');
		$this->description = $this->description ?: '';
		$this->files = $this->files ?: array();
		$this->image = (!empty($this->image)) ? (is_object($this->image)) ? $this->image->__toArray() : $this->image  : new \stdClass();
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new \Saw\Model\Exceptions\DomainException("Adding failed.  Please try again.");
		}
	}
	public function edit(){
		if($this->saveSafe()){
			return $this->_id;
        }else{
			throw new \Saw\Model\Exceptions\DomainException("Editing failed.  Please try again.");
		}
	}
	public function delete(){
		try {
			$this->remove();
			// TODO remove all the Agenda records
		} catch (Exception $e) {
			throw new \Saw\Exceptions\InternalServerErrorException("Deleting <strong>".$this->headline."</strong> failed due to a database error.");
		}

	}
}