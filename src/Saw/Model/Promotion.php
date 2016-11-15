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
	static public $status = array('NEWMEMBER'=>10,'RENEWAL'=>20,'STORE'=>30,'SEMINAR'=>40);
	static public $statusReversed = array(10=>'NEWMEMBER',20=>'RENEWAL',30=>'STORE',40=>'SEMINAR');
	public $currentStatus;
	static public $membership = array('PUBLIC DEFENDER'=>5,'GENERAL MEMBER'=>10,'SUSTAINING MEMBER'=>30,'FOUNDING MEMBER'=>40);
	static public $membershipReversed = array(5=>'PUBLIC DEFENDER',10=>'GENERAL MEMBER',30=>'SUSTAINING MEMBER', 40=>'FOUNDING MEMBER');
	public $currentMembership;
	static public $restriction = array('NO RESTRICTIONS'=>5,'PUBLIC DEFENDERS'=>10,'NON MEMBERS'=>30,'MEMBERS'=>40);
	static public $restrictionReversed = array(5=>'NO RESTRICTIONS',10=>'PUBLIC DEFENDERS',30=>'NON MEMBERS', 40=>'MEMBERS');
	public $currentRestriction;		// restricted to:  members | publicdefenders | nonmembers | norestrictions
	public $discountAmt; 			// based on type this is either a whole dollar amt or a percent
	public $optIn; 					// yes | no - this is for the optin to keep the payment method on file.
	public $optInDisclosure; 		// the actual disclosure statement
	public $optInOnOff; 			// on | off - if on then optIn checkbox must be set 
	public $paymentLite; 			// saved payment details
	public $gift; 					// yes | no - is there a gift; if so display it
	public $giftName;				// name of the gift
	public $giftDesc;				// description of the gift
	public $giftDollarValue;		// the dollar value for display purposes
	public $freeMembership;			// yes | no - do you want to give free membership
	public $freeMembershipRenewalDate; // how long will it last
	public $freeMembershipPmtAmt;	// the dollar amount that must be paid in order to receive the free membership
	public $image; 					// gift image
	public $isActive; 				// yes | no (determined by start and end date automaticall but can also be overwritten)
	public $proratedDiscount; 		// yes | no (does this discount apply to the pro-rated fee or the full fee.  if "no" then the full fee)
	public $add;
	public $timeZone='America/New_York';
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('code', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('startDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('endDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('discountAmt', new Constraints\Type(array('type'=>'numeric','message'=>'Must be a whole dollar value')));
		$metadata->addPropertyConstraint('freeMembershipPmtAmt', new Constraints\Type(array('type'=>'numeric','message'=>'Must be a whole dollar value')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('membershipValid')
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('giftValid')
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('optInValid')
            ,'groups' => array('onform')
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('codeValid')
            ,'groups' => array('onform')
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('codeActive'),
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
	public function membershipValid(ExecutionContext $context){
		if($this->freeMembership == 'yes' && (empty($this->freeMembershipPmtAmt) || (floor($this->freeMembershipPmtAmt) != $this->freeMembershipPmtAmt))){
			$propertyPath = $context->getPropertyPath().'freeMembershipPmtAmt';
        	$context->addViolationAtPath($propertyPath,'Must be a whole dollar value', array(), null);
        }
	}
	public function giftValid(ExecutionContext $context){
		if($this->gift == 'yes' && (empty($this->giftDollarValue) || (floor($this->giftDollarValue) != $this->giftDollarValue))){
			$propertyPath = $context->getPropertyPath().'giftDollarValue';
        	$context->addViolationAtPath($propertyPath,'Must be a whole dollar value', array(), null);
        }
	}
	public function codeActive(ExecutionContext $context){
	
		$result = $this->findOne($query=array('code'=>$this->code,'isActive'=>'yes'),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['_id'] != $this->_id){
			$propertyPath = $context->getPropertyPath().'code';
        	$context->addViolationAtPath($propertyPath,'This promo code is already active in the system.  Please select another one or wait until the active one expires or deactivate it manually.', array(), null);
        }
	}
	public function codeValid(ExecutionContext $context){
	
		$result = $this->findOne($query=array('code'=>$this->code,'isActive'=>'yes'),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['code'] != $this->code){
			$propertyPath = $context->getPropertyPath().'code';
        	$context->addViolationAtPath($propertyPath,'This promo code is invalid.  Please check the code and try again.', array(), null);
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
	public function isValidEndDate(ExecutionContext $context){
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
        $this->code = strtoupper($doc['code']);
        $this->startDate = (!empty($doc['startDate'])) ? (is_object($doc['startDate'])) ? $doc['startDate']->__toArray() : new Date(self::$app,$doc['startDate'], $this->timeZone)  : $doc['startDate'];
		$this->endDate = (!empty($doc['endDate'])) ? (is_object($doc['endDate'])) ? $doc['endDate']->__toArray() : new Date(self::$app,$doc['endDate'], $this->timeZone)  : $doc['endDate'];
        $this->currentType = $doc['currentType'];
        $this->currentStatus = $doc['currentStatus'];
        $this->currentMembership = $doc['currentMembership'];
        $this->discountAmt = $doc['discountAmt'];
        $this->optIn = $doc['optIn'];
		$this->optInDisclosure = $doc['optInDisclosure'];
		$this->optInOnOff = $doc['optInOnOff'];
		$this->paymentLite = $doc['paymentLite'];
		$this->gift = $doc['gift'];
		$this->giftName = $doc['giftName'];
		$this->giftDesc = $doc['giftDesc'];
		$this->giftDollarValue = $doc['giftDollarValue'];
		$this->image = $doc['image'];
		$this->isActive = $doc['isActive'];
		$this->proratedDiscount = $doc['proratedDiscount'];
        $this->add = $doc['add'];		
        $this->currentRestriction = $doc['currentRestriction'];
        $this->freeMembership = $doc['freeMembership'];
		$this->freeMembershipRenewalDate = (!empty($doc['freeMembershipRenewalDate'])) ? (is_object($doc['freeMembershipRenewalDate'])) ? $doc['freeMembershipRenewalDate']->__toArray() : new Date(self::$app,$doc['freeMembershipRenewalDate'], $this->timeZone)  : $doc['freeMembershipRenewalDate'];
		$this->freeMembershipPmtAmt = $doc['freeMembershipPmtAmt'];
	
	}
	protected function prepareInsert(){
		$this->code = $this->code ?: '';
		$this->startDate = $this->startDate ?: new \stdClass();
	    $this->endDate = $this->endDate ?: new \stdClass();
		$this->currentType = $this->currentType ?: self::$type['MONEY'];
		$this->currentStatus = $this->currentStatus ?: self::$status['NEWMEMBER'];
		$this->currentMembership = $this->currentMembership ?: '';
		$this->discountAmt = $this->discountAmt ?: 0;
		$this->optIn = $this->optIn ?: 'yes';
		$this->optInDisclosure = $this->optInDisclosure ?: '';
		$this->optInOnOff = $this->optInOnOff ?: 'on';
		$this->paymentLite = $this->paymentLite ?: new \stdClass();
		$this->gift = $this->gift ?: 'yes';
		$this->giftName = $this->giftName ?: '';
		$this->giftDesc = $this->giftDesc ?: '';
		$this->giftDollarValue = $this->giftDollarValue ?: 0;
		$this->freeMembership = $this->freeMembership ?: 'no';
		$this->freeMembershipRenewalDate = $this->freeMembershipRenewalDate ?: new \stdClass();
		$this->freeMembershipPmtAmt = $this->freeMembershipPmtAmt ?: 0;
		$this->image = $this->image ?: new \stdClass();
		$this->isActive = $this->isActive ?: 'yes';
		$this->proratedDiscount = $this->proratedDiscount ?: 'no';
		$this->add = $this->add ?: 'yes';
		$this->currentRestriction = $this->currentRestriction ?: array();		
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
	public function isValid($code){
		//date range prep
		$date = 'now';
		$end = new \MongoDate(strtotime($date));

		
		$code = strtoupper($code);
        $fields = array();
        $query = array('code'=>$code,'isActive'=>'yes','endDate.date'=>array('$gt'=>$end));
		$res = $this->findOne($query,$fields,$slaveOkay=true,$sort=array(),$offset=0,$limit=1000);
		return $res;
	}
	public function isValidMembership($code,$membership){

		$code = strtoupper($code);
        $fields = array();
		$res = $this->findOne($query=array('code'=>$code,'isActive'=>'yes'),$fields,$slaveOkay=true,$sort=array(),$offset=0,$limit=1000);
		
		if(!empty($res) && is_array($res) && count($res) > 0 && $res['currentRestriction'] > self::$restriction['NO RESTRICTIONS']):
			//static public $membership = array('PUBLIC DEFENDER'=>5,'GENERAL MEMBER'=>10,'SUSTAINING MEMBER'=>30,'FOUNDING MEMBER'=>40);
			//static public $restriction = array('NO RESTRICTIONS'=>5,'PUBLIC DEFENDERS'=>10,'NON MEMBERS'=>30,'MEMBERS'=>40);

			if($res['currentRestriction'] == self::$restriction['NO RESTRICTIONS']){
				return true;
			}
			switch ($membership) {
				case Member::$membership['PUBLIC DEFENDER']:
					if($res['currentRestriction'] == self::$restriction['NON MEMBERS']){
						return false;
					}
					if($res['currentRestriction'] == self::$restriction['PUBLIC DEFENDERS']){
						return true;
					}
					break;	
				case Member::$membership['FOUNDING MEMBER']:
				case Member::$membership['GENERAL MEMBER']:
				case Member::$membership['SUSTAINING MEMBER']:
					if($res['currentRestriction'] == self::$restriction['NON MEMBERS']){
						return false;
					}
					if($res['currentRestriction'] == self::$restriction['MEMBERS']){
						return true;
					}
					break;
			}
		endif;
		
		return false;
	}
	public function fetchByType($offset=0,$limit=1000){
        $fields = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('code'=>1),$offset,$limit);
		return $categories;
	}
	public function fetchByTypeFormatted($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('code'=>1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $category):
				$cat[$category['_id']->__toString()] = $category['code'];
			endforeach;
			return $cat;
		}else{
			return array();
		}
	}
	public function fetchByStatus($offset=0,$limit=1000){
        $fields = array();
        $query = array('currentStatus'=>$this->currentStatus);
		$res = $this->find($query,$fields,$slaveOkay=true,$sort=array('code'=>1),$offset,$limit);
		return $res;
	}
	public function fetchByStatusFormatted($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentStatus'=>$this->currentStatus),$fields,$slaveOkay=true,$sort=array('code'=>1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $category):
				$cat[$category['_id']->__toString()] = $category['code'];
			endforeach;
			return $cat;
		}else{
			return array();
		}
	}
	public function delete(){

		// delete topic
    	$this->remove();

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
		    
}
