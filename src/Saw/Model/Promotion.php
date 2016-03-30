<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;

/**
 * Promotion model.  Used by apply and registration. This is a data class and also a nested class for all people who use the promo
 */
class Promotion extends Model {
	
    public $collection = 'promotion';
    public $code;					// actual promotion code will be checked for uniqueness based on if others are active
    public $startDate;				// promotion start date
    public $endDate;				// promotion end date
    static public $type = array('MONEY'=>10,'PERCENT'=>20);
	static public $typeReversed = array(10=>'MONEY',20=>'PERCENT');
	public $currentType;
	public $discountAmt; 			// based on type this is either a whole dollar amt or a percent
	public $optIn; 					// yes | no - this is for the optin to keep the payment method on file.
	public $optInDisclosure; 		// the actual disclosure statement
	public $optInOnOff; 			// on | off - if on then optIn checkbox must be set 
	public $paymentLite; 			// saved payment details
	public $gift; 					// yes | no - is there a gift; if so display it
	public $giftName;				// name of the gift
	public $giftDollarValue;		// the dollar value for display purposes
	public $image; 					// gift image
	public $isActive; 				// yes | no (determined by start and end date automaticall but can also be overwritten)
	public $add;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('code', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('discountAmt', new Constraints\Type(array('type'=>'numeric','message'=>'must be a number')));  j ,m,..
		$metadata->addPropertyConstraint('giftDollarValue', new Constraints\Type(array('type'=>'numeric','message'=>'must be a whole dollar value')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('optInValid'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('codeValid'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('isValidStartDate'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('isValidEndDate'),
        )));

	}
	public function optInValid(ExecutionContext $context){
	
		if($this->optInOnOff == 'on' && empty($this->optIn)){
			$propertyPath = $context->getPropertyPath().'optIn';
        	$context->addViolationAtPath($propertyPath,'You must accept our opt-in disclosure in order to receive the promotion', array(), null);
        }
	}
	public function codeValid(ExecutionContext $context){
	
		$result = $this->findOne($query=array('code'=>$this->code,'isActive'=>'yes'),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['_id'] != $this->_id){
			$propertyPath = $context->getPropertyPath().'code';
        	$context->addViolationAtPath($propertyPath,'This promo code is already active in the system.  Please select another one or wait until the active one expires or deactivate it manually.', array(), null);
        }
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
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->name = $doc['name'];
        $this->image = $doc['image'];
        $this->currentType = $doc['currentType'];
        $this->add = $doc['add'];
		$this->slug = (empty($doc['slug']) && !empty($doc['name'])) ? self::slugify($doc['name']): $doc['slug'];
		$this->slug = ($this->slug[0] != '/') ? '/'.$this->slug: $this->slug;
	}
	protected function prepareInsert(){
		$this->name = $this->name ?: '';
		$this->image = $this->image ?: new \stdClass();
		$this->currentType = $this->currentType ?: self::$type['BLOG'];
		$this->add = $this->add ?: 'yes';
		$this->slug = $this->slug ?: '';
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function saveEdit(){
		if($this->add == 'yes'){
			$this->prepareInsert();
			if(parent::insert()){
				return $this->_id;
	        }else{
				throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
			}
		}else{
			$this->saveSafe();
			return $this->_id;
		}
	}
	public function fetchByType($offset=0,$limit=1000){
        $fields = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('name'=>1),$offset,$limit);
		return $categories;
	}
	public function fetchByTypeFormatted($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('name'=>1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $category):
				$cat[$category['_id']->__toString()] = $category['name'];
			endforeach;
			return $cat;
		}else{
			return array();
		}
	}
	public function fetchByTypeFormattedSlug($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('name'=>1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $category):
				$cat[$category['_id']->__toString()] = array('name'=>$category['name'],'slug'=>$category['slug']);
			endforeach;
			return $cat;
		}else{
			return array();
		}
	}
	public static function slugify($str){

		$slugify = new \Cocur\Slugify\Slugify();//for iconv translit
		
		$arr = explode('/',$str);
		for ($i=0; $i < count($arr); $i++) { 
			$slug = $slugify->slugify($arr[$i]);
			$arr[$i] = ($slug == 'n-a') ? '':$slug;
		}
		$slug = implode('/',$arr);
		
		return $slug;
	}
	public function delete(){

		// delete topic
    	$this->remove();

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
		    
}
