<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Apply Model.
 * This class is the base class for all application-type forms to be submitted.
 */
class Apply extends Model {
	
	public $collection = 'application';
	static public $status = array('DRAFT'=>0,'SUBMITTED'=>10, 'TRIAL'=>15, 'APPROVED'=>20, 'PAID'=>40);
	static public $statusReversed = array(0=>'DRAFT',10=>'SUBMITTED',15=>'TRIAL',20=>'APPROVED',40=>'PAID');
	public $currentStatus;
	public $firstName;
	public $middleName;
	public $lastName;
	public $phone;
	public $fax;
	public $cellphone;
	public $textAlertsOpt;
	public $barNumber;
	public $email;
	public $website;
	public $websites;
	public $addToListServ;
	public $listServEmail;
	public $formattedAddress;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $postalCode;
	public $country;
	public $lat;
	public $lon;
	public $memberId;
	public $paymentId;
	public $submittedDate;
	public $paidDate;
	public $approvedDate;
	public $references;
	public $timeZone='America/New_York';
	public $membershipDues;
	public $trial;
	public $referredBy;
	public $userAgent;
	public $termsAcknowledgement;
	public $twoSeminarsAcknowledgement;
	public $promotion;

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('firstName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('lastName', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('phone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('barNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('email', new Constraints\Email(array('message'=>'invalid email')));
		$metadata->addPropertyConstraint('listServEmail', new Constraints\Email(array('message'=>'invalid email','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('addToListServ', new Constraints\NotBlank(array('message'=>'cannot be blank','groups' => array('update_member'))));
		$metadata->addPropertyConstraint('formattedAddress', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('address1', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('city', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('state', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('postalCode', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('country', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		//$metadata->addConstraint(new Callback(array('methods' => array('listServ'))));
		$metadata->addConstraint(new Callback(array('methods' => array('latLonValidate'))));
		//$metadata->addConstraint(new Callback(array('methods' => array('termsAckValidate'))));
	}
	/* --commented out because it's no longer necessary
	public function listServ(ExecutionContext $context){
		if($this->addToListServ == 'yes' && empty($this->listServEmail)){
			$propertyPath = $context->getPropertyPath().'listServEmail';
			$context->addViolationAtPath($propertyPath,'cannot be blank.', array(), null);
		}
	}
	*/
	public function latLonValidate(ExecutionContext $context){
		if(empty($this->lat) && empty($this->lon)){
			$propertyPath = $context->getPropertyPath().'geocodeaddress';
			$context->addViolationAtPath($propertyPath,'Please Geocode your address by clicking "Submit for Geocoding"', array(), null);
		}
	}
	public function termsAckValidate(ExecutionContext $context){
		if(empty($this->termsAcknowledgement) || $this->termsAcknowledgement == false || $this->termsAcknowledgement == 'no'){
			$propertyPath = $context->getPropertyPath().'termsAcknowledgement';
			$context->addViolationAtPath($propertyPath,'Please read and accept our terms in order to submit the application.', array(), null);
		}
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->currentStatus = $doc['currentStatus'];
		$this->firstName = $doc['firstName'];
		$this->middleName = $doc['middleName'];
		$this->lastName = $doc['lastName'];
		$doc['phone'] = str_replace('(', '', str_replace(')', '', str_replace('-', '', str_replace(' ', '', $doc['phone']))));
		$this->phone = (is_numeric($doc['phone'])) ? $app['format_phone_number']($doc['phone']): $doc['phone'];
		$doc['fax'] = str_replace('(', '', str_replace(')', '', str_replace('-', '', str_replace(' ', '', $doc['fax']))));
		$this->fax = (is_numeric($doc['fax'])) ? $app['format_phone_number']($doc['fax']): $doc['fax'];
		$doc['cellphone'] = str_replace('(', '', str_replace(')', '', str_replace('-', '', str_replace(' ', '', $doc['cellphone']))));
		$this->cellphone = (is_numeric($doc['cellphone'])) ? $app['format_phone_number']($doc['cellphone']): $doc['cellphone'];
		$this->textAlertsOpt = (string)$doc['textAlertsOpt'];
		$this->barNumber = (string)$doc['barNumber'];
		$this->email = $doc['email'];
		$this->website = $doc['website'];
		$this->websites = $doc['websites'];
		$this->addToListServ = $doc['addToListServ'];
		$this->listServEmail = $doc['listServEmail'];
		$this->formattedAddress = $doc['formattedAddress'];
		$this->address1 = $doc['address1'];
		$this->address2 = $doc['address2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
		$this->postalCode = $doc['postalCode'];
		$this->country = $doc['country'];
		$this->lat = $doc['lat'];
		$this->lon = $doc['lon'];
		$this->paidDate = $doc['paidDate'];
		$this->approvedDate = $doc['approvedDate'];
		$this->references = $doc['references'];
		if(!empty($doc['memberId'])) $this->memberId = (is_object($doc['memberId'])) ? $doc['memberId'] : new \MongoId($doc['memberId']);
		if(!empty($doc['paymentId'])) $this->paymentId = (is_object($doc['paymentId'])) ? $doc['paymentId'] : new \MongoId($doc['paymentId']);
		$this->membershipDues = $doc['membershipDues'];
		$this->referredBy = $doc['referredBy'];
		$this->userAgent = $doc['userAgent'];
		$this->termsAcknowledgement = $doc['termsAcknowledgement'];
		$this->twoSeminarsAcknowledgement = $doc['twoSeminarsAcknowledgement'];
		$this->trial = (is_object($doc['trial'])) ? $doc['trial']->__toArray(false) : $doc['trial'];
		$this->promotion = (is_object($doc['promotion'])) ? $doc['promotion']->__toArray(false) : $doc['promotion'];

	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->submittedDate = new Date(self::$app, 'now');
		$this->paidDate = $this->paidDate ?: new \stdClass();
		$this->approvedDate = $this->approvedDate ?: new \stdClass();
		$this->currentStatus = $this->currentStatus ?: self::$status['SUBMITTED'];
		$this->firstName = $this->firstName ?: '';
		$this->middleName = $this->middleName ?: '';
		$this->lastName = $this->lastName ?: '';
		$this->phone = $this->phone ?: '';
		$this->fax = $this->fax ?: '';
		$this->cellphone = $this->cellphone ?: '';
		$this->textAlertsOpt = $this->textAlertsOpt ?: '';
		$this->barNumber = $this->barNumber ?: '';
		$this->email = $this->email ?: '';
		$this->website = $this->website ?: '';
		$this->websites = $this->websites ?: '';
		$this->addToListServ = $this->addToListServ ?: '';
		$this->listServEmail = $this->listServEmail ?: '';
		$this->formattedAddress = $this->formattedAddress ?: '';
		$this->address1 = $this->address1 ?: '';
		$this->address2 = $this->address2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
		$this->postalCode = $this->postalCode ?: '';
		$this->country = $this->country ?: '';
		$this->lat = $this->lat ?: 33.7489;//atlanta
		$this->lon = $this->lon ?: 84.3881;//atlanta
		$this->memberId = $this->memberId ?: new \stdClass();
		$this->paymentId = $this->paymentId ?: new \stdClass();
		$this->timeZone = $this->timeZone ?: 'America/New_York';
		$this->references = $this->references ?: '';
		$this->membershipDues = $this->membershipDues ?: '';
		$this->referredBy = $this->referredBy ?: '';
		$this->trial = $this->trial ?: new \stdClass();
		$this->promotion = $this->promotion ?: new \stdClass();
		$this->userAgent = $this->userAgent ?: '';
		$this->termsAcknowledgement = $this->termsAcknowledgement ?: '';
		$this->twoSeminarsAcknowledgement = $this->twoSeminarsAcknowledgement ?: '';

	}
	
	public function saveEdit(){
		$this->saveSafe();
		return $this->_id;
	}
	
	public function findByEmail(){
		$query = array('email'=>trim(strtolower($this->email)));
        $fields = array('_id'=>1);
        //error_log('$this->collection: '.print_r($this->collection,true));
        //error_log('$query: '.print_r($query,true));
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		//error_log('$result: '.print_r($result,true));
		if(!empty($result)):
			$this->_id = $result['_id'];
			return true;
		else:
			return false;
		endif;
	}
	public function checkEmailExists(){
		$query = array('email'=>trim(strtolower($this->email)));
        $fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			return $result['_id'];
		else:
			return false;
		endif;
	}
	public function fetch($offset=0,$limit=100,$filter=array()){
		$query = array();
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array('firstName'=>true
						,'middleName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'references'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByStatus($status, $offset=0,$limit=100,$filter=array()){
		$query = array('currentStatus'=>self::$status[$status]);
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		//error_log('query fetchByStatus:'.print_r($query,true));
		$fields = array('firstName'=>true
						,'middleName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'references'=>true
						,'trial'=>true
						,'timeZone'=>true
						,'promocode'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('submittedDate.date'=>-1);
				break;
			case 'APPROVED':
				$sort=array('approvedDate.date'=>-1);
				break;
			case 'PAID':
				$sort=array('paidDate.date'=>-1);
				break;
			case 'TRIAL':
				$sort=array('trial.startDate.date'=>-1);
				break;
			default:
				$sort=array('_id'=>-1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		// include the member payment record
		for ($i=0; $i < count($result); $i++) { 
			$member = new Member(array('_id'=>$result[$i]['memberId']),self::$app);
			$member = $member->findById();
			if(!empty($member) && is_array($member))
				$result[$i]['member'] = $member;
		}

		return $result;

	}
	public function countByStatus($status,$filter=array()){
		$query = array('currentStatus'=>self::$status[$status]);
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$result = $this->count($query,$slaveOkay=true);
		return $result;

	}
	public function countByFilter($filter){
		$result = $this->count($filter,$slaveOkay=true);
		return $result;

	}
	public function fetchByMember($status, $offset=0,$limit=100){
		$user = User::getUserAccessLevelBySession(self::$app);
		$query = array('currentStatus'=>self::$status[$status]
						,'memberId'=>$user['_id']);
		$fields = array('firstName'=>true
						,'middleName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'references'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('submittedDate.date'=>-1);
				break;
			case 'APPROVED':
				$sort=array('approvedDate.date'=>-1);
				break;
			case 'PAID':
				$sort=array('paidDate.date'=>-1);
				break;
			default:
				$sort=array('_id'=>-1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		return $result;

	}

	public function fetchByDateRangeMember($memberId, $start,$end, $offset=0,$limit=100,$filter=array()){
		$memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
		$query = array('memberId'=>$memberId
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime($start))
												,'$gte'=>new \MongoDate(strtotime($end)))
		);
		
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array('firstName'=>true
						,'middleName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'references'=>true
						,'termsAcknowledgement'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));

		return $result;

	}

	public function fetchByDatePaidRange($start, $finish, $offset=0,$limit=100,$filter=array()){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$gte'=>new \MongoDate(strtotime($start))
												,'$lte'=>new \MongoDate(strtotime($finish)))
		);
		
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array('firstName'=>true
						,'middleName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'references'=>true
						,'termsAcknowledgement'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('paidDate.date'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));

		// include the member payment record
		for ($i=0; $i < count($result); $i++) { 
			$member = new Member(array('_id'=>$result[$i]['memberId']),self::$app);
			$member = $member->findById();
			if(!empty($member) && is_array($member))
				$result[$i]['member'] = $member;
		}
		
		return $result;

	}
	public function fetchByDatePaid($days=90, $offset=0,$limit=100,$filter=array()){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-'.$days.' day')))
		);
		
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array('firstName'=>true
						,'middleName'=>true
						,'lastName'=>true
						,'email'=>true
						,'city'=>true
						,'state'=>true
						,'type'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'approvedDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'references'=>true
						,'termsAcknowledgement'=>true
						);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('paidDate.date'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));

		// include the member payment record
		for ($i=0; $i < count($result); $i++) { 
			$member = new Member(array('_id'=>$result[$i]['memberId']),self::$app);
			$member = $member->findById();
			if(!empty($member) && is_array($member))
				$result[$i]['member'] = $member;
		}
		
		return $result;

	}
	public function countByDatePaid($days=90, $filter=array()){
		$query = array('currentStatus'=>self::$status['PAID']
						,'paidDate.date'=>array('$lte'=>new \MongoDate(strtotime('now'))
												,'$gte'=>new \MongoDate(strtotime('-'.$days.' day')))
		);
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$result = $this->count($query,$slaveOkay=true);
		return $result;

	}
	public function markPaid($resetSession=true){

		$this->paidDate = new Date(self::$app,'now', $this->timeZone);
		$this->currentStatus = self::$status['PAID'];
		$this->saveSafe();
		
		// set the member's accessLevel to MEMBER
		$query = array('_id'=>$this->_id);
        $fields = array('memberId'=>1);
		$result = $this->findOne($query,$fields);
		
		if(!empty($result)):
			$memberId = $result['memberId'];
		else:
			$memberId = 'notfound';
		endif;

		$member = new Member(array('_id'=>$memberId,'accessLevel'=>MEMBER,'changeAccessLevelTo'=>MEMBER,'listed'=>1),self::$app);
		$member->saveSafe();
		if($resetSession){
			$member->setUserSession();
		}
	}
	
	public function updateMemberProfile($memberId){

		$apply = new Apply($doc=array('_id'=>$this->_id), self::$app);
        $a = $apply->findById();
        
        if(!empty($a)){
            $new_doc = array();
            $member = new Member($doc=array('_id'=>$memberId), self::$app);
            $member = $member->findById();

            $location = new Location($doc=array('member'=>array('_id'=>$memberId)), self::$app);
            $loc = $location->getPrimary($memberId);
            if(empty($loc)){
                $locations = $location->findById('member._id'); 
                if(count($locations) > 1){
                    $location = array(); // no need to proceed because we won't know which one they're wanting to update.
                }
            }else{
                $location = $loc;
            }

            
            $now = new Date(self::$app,'now');                
            $change = new Change(array(),self::$app);
            $change_res_m = $change->find(array('context'=>'Member','belongsTo'=>$member['_id'],'date'=>array('$gte'=>new \MongoDate(strtotime($a['submittedDate']['fullDateTime'])),'$lt'=>new \MongoDate(strtotime($now->fullDateTime)))),$fields=array());
            $change_res_l = $change->find(array('context'=>'Location','belongsTo'=>$member['_id'],'date'=>array('$gte'=>new \MongoDate(strtotime($a['submittedDate']['fullDateTime'])),'$lt'=>new \MongoDate(strtotime($now->fullDateTime)))),$fields=array());
            

            if(!empty($a['firstName']) || !empty($a['middleName']) || !empty($a['lastName'])){ 
                
                $tmp = explode(' ', $member['displayName']);
                if(count($tmp) > 2){
                    if($member['displayName'] != $a['firstName'].' '.$a['middleName'].' '.$a['lastName']){
                        
                        if(is_array($change_res_m) && is_array($change_res_m['values']) && array_key_exists('displayName', $change_res_m['values'])){
                            // do nothing cause the user has already done a change since they submitted their app
                        }else{
                            $new_doc['displayName'] = $a['firstName'].' '.$a['middleName'].' '.$a['lastName'];
                        }
                        
                    }
                }elseif(count($tmp) <= 2){
                    if($member['displayName'] != $a['firstName'].' '.$a['lastName']){
                        
                        if(is_array($change_res_m) && is_array($change_res_m['values']) && array_key_exists('displayName', $change_res_m['values'])){
                            // do nothing cause the user has already done a change since they submitted their app
                        }else{
                            $new_doc['displayName'] = $a['firstName'].' '.$a['lastName'];
                        }

                    }
                }

                
            }
            if(!empty($a['email']) 
                && $member['email'] != $a['email']){

                if(is_array($change_res_m) && is_array($change_res_m['values']) && array_key_exists('email', $change_res_m['values'])){
                    // do nothing cause the user has already done a change since they submitted their app
                }else{
                    $new_doc['email'] = $a['email'];
                }

            }
            if(!empty($a['barNumber']) 
                && $member['barNumber'] != $a['barNumber']){
                if(is_array($change_res_m) && is_array($change_res_m['values']) && array_key_exists('barNumber', $change_res_m['values'])){
                    // do nothing cause the user has already done a change since they submitted their app
                }else{
                    $new_doc['barNumber'] = $a['barNumber'];
                }
            }
            // check the websites
        	if(array_key_exists('websites', $a)){
        		$new_doc['websites'] = $a['websites'];
        	}
        	error_log('new_doc:'.print_r($new_doc,true));
            if(!empty($new_doc)){

                $new_doc['_id'] = $member['_id'];
                $member = new Member($new_doc,self::$app);
                $member->saveEdit();
            }
        }
		return true;
	}
	
	public function proRate($date=''){
		//error_log('approvedDate:'.$this->approvedDate['iso']);
		$date = (!empty($date)) ? new \DateTime($date): new \DateTime($this->approvedDate['iso']);
		$curMonth = date("n", $date->getTimeStamp());
		$curDay = date("j", $date->getTimeStamp());
		$curQuarter = ceil($curMonth/3);
		//error_log('curMonth:'.$curMonth);
		//error_log('curQuarter:'.$curQuarter);
		//error_log('curDay:'.$curDay);
		if($curQuarter <= 1){
			switch ($this->membershipDues) {
				case 175:
					return array('q'=>1,'a'=>175);
					break;
				case 225:
					return array('q'=>1,'a'=>225);
					break;
				case 50:
					return array('q'=>1,'a'=>50);
					break;
			}
		} else if($curQuarter > 1 && $curQuarter <= 2){
			switch ($this->membershipDues) {
				case 175:
					return array('q'=>2,'a'=>150);
					break;
				case 225:
					return array('q'=>2,'a'=>175);
					break;
				case 50:
					return array('q'=>2,'a'=>50);
					break;
			}
		} else if($curQuarter > 2 && $curQuarter <= 3){
			switch ($this->membershipDues) {
				case 175:
					return array('q'=>3,'a'=>100);
					break;
				case 225:
					return array('q'=>3,'a'=>125);
					break;
				case 50:
					return array('q'=>3,'a'=>25);
					break;
			}
		} else if($curQuarter > 3 && $curQuarter <= 4){
			if($curMonth == 12 && $curDay >= 10){
				switch ($this->membershipDues) {
					case 175:
						return array('q'=>1,'a'=>175);
						break;
					case 225:
						return array('q'=>1,'a'=>225);
						break;
					case 50:
						return array('q'=>1,'a'=>50);
						break;
				}
			}else{
				switch ($this->membershipDues) {
					case 175:
						return array('q'=>4,'a'=>50);
						break;
					case 225:
						return array('q'=>4,'a'=>75);
						break;
					case 50:
						return array('q'=>4,'a'=>25);
						break;
				}	
			}
		}
	}	
}