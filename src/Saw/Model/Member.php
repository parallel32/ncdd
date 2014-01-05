<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Member Model.  Extends User.
 * This is a concrete class.
 * board position progession: 
 *	regent(12 years), 
 *	dean(1yr), 
 *	dean ameritus(1yr following dean w/board vote), 
 *	fellow (forever no vote)
 * 
 */
class Member extends User {
	
	public $collection = 'member';
	public $location;// this is the member's primary address | used for primary contact
	public $barNumber;
	public $websites;// array of websites
	public $listServEmail;

	public $linkedInUrl;
	public $googlePlusUrl;
	public $twitterUrl;
	public $facebookUrl;
	public $primaryPhone;
	public $primaryFax;
	public $languages;//array of values
	public $specializeIn; // open text field
	public $aboutMe;
	public $financialFees;
	public $financialPayment;
	public $practiceAreas; //array('95'=>'DUI 22 years, 400 cases') // array indexes should add up to 100
	public $orderNum;

	// order not relevant
	static public $membership = array('PUBLIC DEFENDER'=>5,'GENERAL MEMBER'=>10,'SUSTAINING MEMBER'=>30,'FOUNDING MEMBER'=>40);
	static public $membershipReversed = array(5=>'PUBLIC DEFENDER',10=>'GENERAL MEMBER',30=>'SUSTAINING MEMBER', 40=>'FOUNDING MEMBER');
	public $currentMembership;
	static public $membershipBadge = array(5=>'./../../../www/ncdd.com/public_html/assets/img/badges/public-defender.png'
											,10=>'./../../../www/ncdd.com/public_html/assets/img/badges/general.png'
											,20=>'./../../../www/ncdd.com/public_html/assets/img/badges/faculty.png'
											,40=>'./../../../www/ncdd.com/public_html/assets/img/badges/founding.png'
											,30=>'./../../../www/ncdd.com/public_html/assets/img/badges/sustaining.png'
											);
	// order descending
	static public $order = array('DEAN'=>65,'FELLOW'=>60,'DEAN EMERITUS'=>58,'ASSISTANT DEAN'=>57,'SECRETARY'=>56,'TREASURER'=>55,'REGENT'=>50,'BOARD CERTIFIED'=>45,'FOUNDING MEMBER'=>40,'SUSTAINING MEMBER'=>35,'DELEGATE'=>20,'FORMER REGENT'=>15,'GENERAL MEMBER'=>5,'PUBLIC DEFENDER'=>3);
	static public $orderReversed = array(65=>'DEAN',60=>'FELLOW',58=>'DEAN EMERITUS',57=>'ASSISTANT DEAN',56=>'SECRETARY',55=>'TREASURER',50=>'REGENT',45=>'BOARD CERTIFIED',40=>'FOUNDING MEMBER',35=>'SUSTAINING MEMBER',20=>'DELEGATE',15=>'FORMER REGENT',5=>'GENERAL MEMBER',3=>'PUBLIC DEFENDER');
	public $currentOrder;
	
	// order descending
	static public $facultyPosition = array('FELLOW'=>90,'DEAN'=>80,'DEAN EMERITUS'=>70,'ASSISTANT DEAN'=>60,'SECRETARY'=>50,'TREASURER'=>40,'REGENT'=>30,'DELEGATE'=>20,'FORMER REGENT'=>10);
	static public $facultyPositionReversed = array(90=>'FELLOW',80=>'DEAN',70=>'DEAN EMERITUS',60=>'ASSISTANT DEAN',50=>'SECRETARY',40=>'TREASURER',30=>'REGENT',20=>'DELEGATE',10=>'FORMER REGENT');
	public $currentFacultyPosition;
	static public $facultyBadge = array(90=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/fellow.png'
										,80=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/dean.png'
										,70=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/dean_emeritus.png'
										,60=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/assisstant_dean.png'
										,50=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/secretary.png'
										,40=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/treasurer.png'
										,30=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/regent.png'
										,20=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/delegate.png'
										,10=>'./../../../www/ncdd.com/public_html/assets/img/badges-exec/former_regent.png');
	
	public $staff; // yes | no
	public static $staffBadge = './../../../www/ncdd.com/public_html/assets/img/badges/faculty.png';
	public $boardCertified; // yes | no
	public static $boardCertifiedBadge = './../../../www/ncdd.com/public_html/assets/img/badges/boardcertified.png';
	public $listed;
	public $joinDate;
	public $timeZone='America/New_York';
	public $yearsinpractice;
	public $changeAccessLevelTo;
	public $renewal;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		
		
	}
	public function __construct($doc, Application $app, $location=array()){
		parent::__construct($doc,$app,$location);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->accessLevel = $doc['accessLevel'];
		$this->location = (is_object($location)) ? $location->__toArray() : $doc['location'];
		$this->barNumber = $doc['barNumber'];
		$this->websites = $doc['websites'];
		$this->listServEmail = $doc['listServEmail'];
		
		if(strtolower($doc['listed']) == 'yes'){
			$this->listed = 1;
		}else if(strtolower($doc['listed']) == 'no'){
			$this->listed = 0;
		}else if(is_numeric($doc['listed'])){
			$this->listed = (int)$doc['listed'];
		}
		
        if(strtolower($doc['boardCertified']) == 'yes'){
			$this->boardCertified = 1;
		}else if(strtolower($doc['boardCertified']) == 'no'){
			$this->boardCertified = 0;
		}else if(is_numeric($doc['boardCertified'])){
			$this->boardCertified = (int)$doc['boardCertified'];
		}
		
		if(strtolower($doc['staff']) == 'yes'){
			$this->staff = 1;
		}else if(strtolower($doc['staff']) == 'no'){
			$this->staff = 0;
		}else if(is_numeric($doc['staff'])){
			$this->staff = (int)$doc['staff'];
		}
		
        $this->joinDate = (!empty($doc['joinDate'])) ? (is_object($doc['joinDate'])) ? $doc['joinDate']->__toArray() : new Date(self::$app,$doc['joinDate'], $this->timeZone)  : $doc['joinDate'];
        include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->aboutMe = (!empty($doc['aboutMe'])) ? wptexturize(wpautop($doc['aboutMe'])) : '';
		// for import only $this->aboutMe = $doc['aboutMe'];
		$this->linkedInUrl = $doc['linkedInUrl'];
		$this->googlePlusUrl = $doc['googlePlusUrl'];
		$this->twitterUrl = $doc['twitterUrl'];
		$this->facebookUrl = $doc['facebookUrl'];
		$this->primaryPhone = $doc['primaryPhone'];
		$this->primaryFax = $doc['primaryFax'];
		$this->languages = $doc['languages'];
		$this->specializeIn = $doc['specializeIn'];
		$this->financialFees = $doc['financialFees'];
		$this->financialPayment = $doc['financialPayment'];
		$this->practiceAreas = $doc['practiceAreas'];
		$this->yearsinpractice = $doc['yearsinpractice'];
		$this->changeAccessLevelTo = $doc['changeAccessLevelTo'];
		$this->renewal = (is_object($doc['renewal'])) ? $doc['renewal']->__toArray(): $doc['renewal'];

		// * means no order number present. use this because can't use zero, they'll shoot strait to the top
		$this->orderNum = (!empty($doc['orderNum'])) ? ( $doc['orderNum'] == '*') ? $doc['orderNum']: (int)$doc['orderNum'] : ''; 
		// for import only $this->orderNum = $doc['orderNum'];

		$this->currentMembership = (!empty($doc['currentMembership'])) ? (int)$doc['currentMembership']: null;
		if($doc['currentFacultyPosition'] === 0){
			$this->currentFacultyPosition = (int)$doc['currentFacultyPosition'];	
		}elseif(!empty($doc['currentFacultyPosition'])){
			$this->currentFacultyPosition = $doc['currentFacultyPosition'];
		}
		$order_arr = array();
		if(!empty($this->currentMembership)){
			array_push($order_arr, self::$order[self::$membershipReversed[$this->currentMembership]]);
		}
		if(!empty($this->currentFacultyPosition)){
			array_push($order_arr, self::$order[self::$facultyPositionReversed[$this->currentFacultyPosition]]);
		}
		if($this->boardCertified){
			array_push($order_arr, self::$order['BOARD CERTIFIED']);	
		}
		rsort($order_arr);
		if(!empty($order_arr)){
			$this->currentOrder = $order_arr[0];
		}
		
		if(!empty($doc['renewalStatus'])){
			if($doc['renewalStatus'] == 'ACTIVATE'){
				$renewal = new Renewal(array(),$app);
				$renewal->prepareInsert();
				$this->renewal = $renewal->__toArray();
			}elseif($doc['renewalStatus'] == 'DEACTIVATE'){
				$this->renewal = new \StdClass();
			}
		}else{
			$this->renewal = $doc['renewal'];
		}
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->accessLevel = $this->accessLevel ?: UNPAIDMEMBER;		
		$this->location = $this->location ?: new \StdClass();
		$this->barNumber = $this->barNumber ?: '';
		$this->websites = $this->websites ?: new \StdClass();
		$this->listServEmail = $this->listServEmail ?: '';
		$this->listed = ($this->listed == 0) ? 0 : 1;
		$this->currentMembership = $this->currentMembership ?: self::$membership['GENERAL MEMBER'];
		$this->currentOrder = $this->currentOrder ?: self::$order['GENERAL MEMBER'];
		$this->currentFacultyPosition = $this->currentFacultyPosition ?: 0;
		$this->boardCertified = $this->boardCertified ?: 0;
		$this->staff = $this->staff ?: 0;
		$this->joinDate = (!empty($this->joinDate)) ? (is_object($this->joinDate)) ? $this->joinDate->__toArray() : $this->joinDate  : new Date(self::$app,'now', $this->timeZone);
		$this->timeZone = $this->timeZone ?: 'America/New_York';

		$this->aboutMe = $this->aboutMe ?: '';
		$this->linkedInUrl = $this->linkedInUrl ?: '';
		$this->googlePlusUrl = $this->googlePlusUrl ?: '';
		$this->twitterUrl = $this->twitterUrl ?: '';
		$this->facebookUrl = $this->facebookUrl ?: '';
		$this->primaryPhone = $this->primaryPhone ?: '';
		$this->primaryFax = $this->primaryFax ?: '';
		$this->languages = $this->languages ?: array();
		$this->specializeIn = $this->specializeIn ?: '';
		$this->financialFees = $this->financialFees ?: '';
		$this->financialPayment = $this->financialPayment ?: '';
		$this->practiceAreas = $this->practiceAreas ?: array();
		$this->yearsinpractice = $this->yearsinpractice ?: '';
		$this->orderNum = $this->orderNum ?: '*';
		$this->changeAccessLevelTo = $this->changeAccessLevelTo ?: $this->accessLevel;
		$this->renewal = $this->renewal ?: null;

		parent::prepareInsert();
	}
	public function insert(){
		if($this->findByEmail()){
			$this->saveEdit();
		}else{
			$this->prepareInsert();
			if(parent::insert()){
	        	return $this->_id;
	        }else{
				throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
			}
		}
	}
	public function saveEdit(){
		// save the member
		$this->saveSafe();
		// update info in all the locations
		$location = new Location(array('ownerId'=>$this->_id),self::$app);
		$this->findById($id='_id', $slaveOkay=false);
		$location->updateMember($this->__toArray(false));

	}
	public static function parseWebsite($address){
		if(strpos($address,'://') !== false){
			$parts = parse_url($address);
			$address = $parts['host'];
		}
		return $address;
	}
	public function addWebSite($website){
				
		$website['website'] = self::parseWebsite($website['website']);
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$addToSet'=>array('websites'=>$website));
		
		self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));

		return $website['website'];
	}
	public function removeWebsite($address){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$pull'=>array('websites'=>array('website'=>$address)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function getWebsites(){
		$result = $this->findOne($query=array('_id'=>$this->_id),$fields=array('websites'=>1));
		$this->websites = $result['websites'];
		return $result['websites'];
	}
	public function addPracticeArea($pa){
		$pa['percent'] = str_replace('%','',$pa['percent']);
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$addToSet'=>array('practiceAreas'=>$pa));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function removePracticeArea($pa){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$pull'=>array('practiceAreas'=>array('pa'=>$pa)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function getPracticeAreas(){
		$result = $this->findOne($query=array('_id'=>$this->_id),$fields=array('practiceAreas'=>1),false);
		$this->practiceAreas = $result['practiceAreas'];
		return $result['practiceAreas'];
	}
	public function addLanguage($language){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$addToSet'=>array('languages'=>$language));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function removeLanguage($language){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$pull'=>array('languages'=>array('language'=>$language)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function getLanguages(){
		$result = $this->findOne($query=array('_id'=>$this->_id),$fields=array('languages'=>1));
		$this->languages = $result['languages'];
		return $result['languages'];
	}
	public static function getAccountBySession(Application $app, $fields=array(),$collection=''){
		
		$fields = array('_id','image','displayName','businessName','firstName','middleName','lastName','email','dob','gender',
						'location.phone','location.addressLine1','location.addressLine2',
						'location.city','location.state','location.zip',
						'shareWithMerchant','connections');
	
		return parent::getAccountBySession($app,$fields,$this->collection);
	}


	public static function getAccountById($userId, Application $app, $fields=array(),$collection=''){
		$fields = array('businessName','firstName','middleName','lastName','email','passwordOriginal');
		$user_doc = parent::getAccountById($userId,$app,$fields,'member');
		return $user_doc;
	}
	
    // Use this instead of a raw query because it filters the fields down to those most commonly needed protecting redemption data etc.
    public static function getUser(Application $app, $query, $fields=array(),$collection='') {
        $fields = array('_id','displayName','shortCode','slug','image','karma','QR','location');
		return parent::getUser($app,$query,$fields,'member');
    }

	public static function getUserBySession(Application $app,$collection=''){
		return parent::getUserBySession($app,'member');

	}
	public function distinctStates(){
		return $this->distinct('location.state');
	}

	public function search($string,$listedOnly=false){
		$states = array('alabama'=>'AL','alaska'=>'AK','arizona'=>'AZ','arkansas'=>'AR','california'=>'CA','colorado'=>'CO','connecticut'=>'CT','delaware'=>'DE','washington dc'=>'DC','florida'=>'FL','georgia'=>'GA','hawaii'=>'HI','idaho'=>'ID','illinois'=>'IL','indiana'=>'IN','iowa'=>'IA','kansas'=>'KS','kentucky'=>'KY','louisiana'=>'LA','maine'=>'ME','maryland'=>'MD','massachusetts'=>'MA','michigan'=>'MI','minnesota'=>'MN','mississippi'=>'MS','missouri'=>'MO','montana'=>'MT','nebraska'=>'NE','nevada'=>'NV','new hampshire'=>'NH','new jersey'=>'NJ','new mexico'=>'NM','new york'=>'NY','north carolina'=>'NC','north dakota'=>'ND','ohio'=>'OH','oklahoma'=>'OK','oregon'=>'OR','pennsylvania'=>'PA','rhode island'=>'RI','south carolina'=>'SC','south dakota'=>'SD','tennessee'=>'TN','texas'=>'TX','utah'=>'UT','vermont'=>'VT','virginia'=>'VA','washington'=>'WA','west virginia'=>'WV','wisconsin'=>'WI','wyoming'=>'WY','ontario'=>'ON','quebec'=>'QC','saskatchewan'=>'SK');
		if(array_key_exists(strtolower($string),$states)){
			$state = $states[strtolower($string)];
			$string = "state";
		}
		if(strpos($string,'@')!== false){
			$email = $string;
			$string = 'email';
		}
		$fields=array('_id'=>1
					,'firstName'=>1
					,'middleName'=>1
					,'lastName'=>1
					,'slug'=>1
					,'displayName'=>1
					,'primaryPhone'=>1
					,'email'=>1
					,'image'=>1
					,'currentOrder'=>1
					,'currentMembership'=>1
					,'currentFacultyPosition'=>1
					,'boardCertified'=>1
					,'staff'=>1
					,'listed'=>1
					,'websites'=>1
					,'orderNum'=>1
					,'location'=>1
					);

		switch ($string) {
			case 'email':
				$search = new \MongoRegex("/".$email."/i");
				$result = $this->find($query=array('email'=>$search),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'state':
				//$result = $this->find($query=array('location.state'=>$state,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				//*
				$m_fields = array();
				foreach ($fields as $key => $value) {
					$m_fields['member.'.$key]=$value;
				}
				$query=array('state'=>$state,'member.listed'=>1);
				$m_result = self::$app['mongo']->find('location', $query,$m_fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.orderNum'=>1));
				//error_log('result:'.print_r($m_result,true));
				$i=0;
				foreach ($m_result as $key => $value) {
					$result[$i]['_id'] = $value['member']['_id'];
					$result[$i]['firstName'] = $value['member']['firstName'];
					$result[$i]['middleName'] = (array_key_exists('middleName',$value['member'])) ? $value['member']['middleName'] : '';
					$result[$i]['lastName'] = $value['member']['lastName'];
					$result[$i]['slug'] = $value['member']['slug'];
					$result[$i]['displayName'] = $value['member']['displayName'];
					$result[$i]['primaryPhone'] = $value['member']['primaryPhone'];
					$result[$i]['email'] = $value['member']['email'];
					$result[$i]['image'] = $value['member']['image'];
					$result[$i]['currentOrder'] = $value['member']['currentOrder'];
					$result[$i]['currentMembership'] = $value['member']['currentMembership'];
					$result[$i]['currentFacultyPosition'] = $value['member']['currentFacultyPosition'];
					$result[$i]['boardCertified'] = $value['member']['boardCertified'];
					$result[$i]['staff'] = (array_key_exists('staff',$value['member'])) ? $value['member']['staff']: '';
					$result[$i]['listed'] = $value['member']['listed'];
					$result[$i]['websites'] = $value['member']['websites'];
					$result[$i]['orderNum'] = $value['member']['orderNum'];
					$i++;
				}
				//*/
				break;
			case 'Sustaining Members':
				$result = $this->find($query=array('currentMembership'=>self::$membership['SUSTAINING MEMBER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'General Members':
				$result = $this->find($query=array('currentMembership'=>self::$membership['GENERAL MEMBER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'Public Defenders':
				$result = $this->find($query=array('currentMembership'=>self::$membership['PUBLIC DEFENDER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'Founding Members':
				if($listedOnly){
					$result = $this->find($query=array('currentMembership'=>self::$membership['FOUNDING MEMBER'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentMembership'=>self::$membership['FOUNDING MEMBER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				$i=0;
				foreach ($result as $key => $value) {
					$location_result = self::$app['mongo']->findOne('location', $query=array('member._id'=>$value['_id']),array('raw'=>true),$slaveOkay=true);
					$result[$i]['location'] = array('raw'=>$location_result['raw']);
					$i++;
				}
				break;
			case 'Regents and Fellows':
				if($listedOnly){
					$regents = $this->find($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW']),'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);			
					$fellows = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);			
					foreach($fellows as $fellow):
						array_push($regents,$fellow);
					endforeach;
					$result = $regents;
				}else{
					$regents = $this->find($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'])),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);			
					$fellows = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);			
					foreach($fellows as $fellow):
						array_push($regents,$fellow);
					endforeach;
					$result = $regents;
				}
				$i=0;
				foreach ($result as $key => $value) {
					$location_result = self::$app['mongo']->findOne('location', $query=array('member._id'=>$value['_id']),array('raw'=>true),$slaveOkay=true);
					$result[$i]['location'] = array('raw'=>$location_result['raw']);
					$i++;
				}
				break;
			case 'Regents':
				$result = $this->find($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'])),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'Fellows':
				$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'Former Regents':
				$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FORMER REGENT']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'State Delegates':
				$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['DELEGATE']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				$i=0;
				foreach ($result as $key => $value) {
					$location_result = self::$app['mongo']->findOne('location', $query=array('member._id'=>$value['_id']),array('raw'=>true),$slaveOkay=true);
					$result[$i]['location'] = array('raw'=>$location_result['raw']);
					$i++;
				}
				break;
			case 'Board Certified':
				$result = $this->find($query=array('boardCertified'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			case 'Staff':
				$result = $this->find($query=array('staff'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				break;
			
			default:
				$search = new \MongoRegex("/".$string."/i");
				$result = $this->find($query=array('displayName'=>$search),$fields,true,$sort=array('currentOrder'=>-1),$offset=0,$limit=3000);		
				break;
		}
		
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) {
				$result[$i]['image'] = (!empty($result[$i]['image'])) ? $result[$i]['image']['urls']['small']['CDN'] : '/noprofileimage';
				$result[$i]['currentOrder'] = (!empty($result[$i]['currentOrder'])) ? self::$orderReversed[$result[$i]['currentOrder']] : '';
				$result[$i]['currentMembership'] = (!empty($result[$i]['currentMembership'])) ? self::$membershipReversed[$result[$i]['currentMembership']] : '';
				$result[$i]['currentFacultyPosition'] = (!empty($result[$i]['currentFacultyPosition'])) ? self::$facultyPositionReversed[$result[$i]['currentFacultyPosition']] : '';
				$result[$i]['boardCertified'] = ($result[$i]['boardCertified']) ? "Yes" : "No";
				$result[$i]['staff'] = ((array_key_exists('staff',$result[$i])) ? $result[$i]['staff']: '') ? "Yes" : "No";
				$result[$i]['listed'] = ($result[$i]['listed']) ? "Yes" : "No";
				$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
				$result[$i]['staffBadge'] = self::$staffBadge;
			}
		endif;
		return $result;
	}

	public function searchByState($state){

		$fields=array('member._id'=>1
					,'member.firstName'=>1
					,'member.middleName'=>1
					,'member.lastName'=>1
					,'member.slug'=>1
					,'member.primaryPhone'=>1
					,'member.email'=>1
					,'member.image'=>1
					,'member.currentMembership'=>1
					,'member.currentFacultyPosition'=>1
					,'member.boardCertified'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.orderNum'=>1));
		
		$i=0;
		foreach ($result as $key => $value) {
			$result[$i]['_id'] = $value['member']['_id'];
			$result[$i]['firstName'] = $value['member']['firstName'];
			$result[$i]['middleName'] = (array_key_exists('middleName',$value['member'])) ? $value['member']['middleName']: '';
			$result[$i]['lastName'] = $value['member']['lastName'];
			$result[$i]['slug'] = $value['member']['slug'];
			$result[$i]['primaryPhone'] = $value['member']['primaryPhone'];
			$result[$i]['email'] = $value['member']['email'];
			// do some extra processing with the values here
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['CDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['staff'] = ((array_key_exists('staff',$value['member'])) ? $value['member']['staff']: '') ? "Yes" : "No";
			$result[$i]['staffBadge'] = self::$staffBadge;
			
			$result[$i]['websites'] = $value['member']['websites'];
			$result[$i]['location']['raw'] = $value['raw'];
			$i++;
		}
		$_result = array();
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) {
				$_result[(string)$result[$i]['_id']] = $result[$i];
			}

		endif;
		return $_result;
	}

	public function searchFoundingMembersByState($state){

		$fields=array('member._id'=>1
					,'member.firstName'=>1
					,'member.middleName'=>1
					,'member.lastName'=>1
					,'member.slug'=>1
					,'member.primaryPhone'=>1
					,'member.email'=>1
					,'member.image'=>1
					,'member.currentMembership'=>1
					,'member.currentFacultyPosition'=>1
					,'member.boardCertified'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.currentMembership'=>self::$membership['FOUNDING MEMBER'], 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.orderNum'=>1));
		
		$i=0;
		foreach ($result as $key => $value) {
			$result[$i]['_id'] = $value['member']['_id'];
			$result[$i]['firstName'] = $value['member']['firstName'];
			$result[$i]['middleName'] = (array_key_exists('middleName',$value['member'])) ? $value['member']['middleName']: '';
			$result[$i]['lastName'] = $value['member']['lastName'];
			$result[$i]['slug'] = $value['member']['slug'];
			$result[$i]['primaryPhone'] = $value['member']['primaryPhone'];
			$result[$i]['email'] = $value['member']['email'];
			// do some extra processing with the values here
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['CDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['staff'] = ((array_key_exists('staff',$value['member'])) ? $value['member']['staff']: '') ? "Yes" : "No";
			$result[$i]['staffBadge'] = self::$staffBadge;
			
			$result[$i]['websites'] = $value['member']['websites'];
			$result[$i]['location']['raw'] = $value['raw'];
			$i++;
		}
		$_result = array();
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) {
				$_result[(string)$result[$i]['_id']] = $result[$i];
			}

		endif;
		return $_result;
	}

	public function searchStateDelegatesByState($state){

		$fields=array('member._id'=>1
					,'member.firstName'=>1
					,'member.middleName'=>1
					,'member.lastName'=>1
					,'member.slug'=>1
					,'member.primaryPhone'=>1
					,'member.email'=>1
					,'member.image'=>1
					,'member.currentMembership'=>1
					,'member.currentFacultyPosition'=>1
					,'member.boardCertified'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.currentFacultyPosition'=>self::$facultyPosition['DELEGATE'], 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.orderNum'=>1));
		
		if(!empty($result)):
		$i=0;
		foreach ($result as $key => $value) {
			$result[$i]['_id'] = $value['member']['_id'];
			$result[$i]['firstName'] = $value['member']['firstName'];
			$result[$i]['middleName'] = (array_key_exists('middleName',$value['member'])) ? $value['member']['middleName']: '';
			$result[$i]['lastName'] = $value['member']['lastName'];
			$result[$i]['slug'] = $value['member']['slug'];
			$result[$i]['primaryPhone'] = $value['member']['primaryPhone'];
			$result[$i]['email'] = $value['member']['email'];
			// do some extra processing with the values here
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['CDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['staff'] = ((array_key_exists('staff',$value['member'])) ? $value['member']['staff']: '') ? "Yes" : "No";
			$result[$i]['staffBadge'] = self::$staffBadge;
			
			$result[$i]['websites'] = $value['member']['websites'];
			$result[$i]['location']['raw'] = $value['raw'];
			$i++;
		}
		endif;
		$_result = array();
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) {
				$_result[(string)$result[$i]['_id']] = $result[$i];
			}

		endif;
		return $_result;
	}

	public function fetchByMembership($membership,$filter=array()){

		$fields=array('_id'=>1
					,'renewal'=>1
		);

		switch ($membership) {
			case self::$membersip['SUSTAINING MEMBER']:
				$query = array('currentMembership'=>self::$membership['SUSTAINING MEMBER']);
				$query = array_merge($filter, $query);
				break;
			case self::$membersip['GENERAL MEMBER']:
				$query = array('currentMembership'=>self::$membership['GENERAL MEMBER']);
				$query = array_merge($filter, $query);
				break;
			case self::$membersip['FOUNDING MEMBER']:
				$query = array('currentMembership'=>self::$membership['FOUNDING MEMBER']);
				$query = array_merge($filter, $query);
				break;
		}
		$result = $this->find($query,$fields,true,$sort=array(),$offset=0,$limit=3000);					
		return $result;
	}

	// saves user_id into session
	public function setUserSession($accessLevel=false) {
        $user = $this->findOne($query=array('_id'=>$this->_id),$fields=array('_id'=>1,'accessLevel'=>1,'displayName'=>1,'status'=>1,));
        if(!empty($user)) {
			$sess_user['user_id'] 		= $user['_id'];
			$sess_user['accessLevel'] 	= (empty($accessLevel)) ? $user['accessLevel'] : $accessLevel;
			$sess_user['displayName'] 	= $user['displayName'];
			$sess_user['status']	 	= $user['status'];
			self::$app['session']->set('user',$sess_user);
			return true;
        }
        return false;
    }
    public static function getChangeAccessLevelTo($_id,$app){
    	if(!empty($_id)) $_id = (is_object($_id)) ? $_id : new \MongoId($_id);
    	$result = $app['mongo']->findOne('member',$query=array('_id'=>$_id),$fields=array('changeAccessLevelTo'=>1));
		return (array_key_exists('changeAccessLevelTo',$result)) ? $result['changeAccessLevelTo']: '';
		
    }
    public function changeMemberAccessLevel($changeTo){
    	$this->accessLevel = $changeTo;
		$this->saveSafe();
		$this->setUserSession($changeTo);
    }
    public function updateOrderNum(){
    	if(!empty($this->_id) && !empty($this->orderNum)){
    		$this->saveEdit();
    	}
    	return true;
    }

    public function fetchByRenewalStatus($status, $membership=array(), $offset=0,$limit=100,$filter=array()){
		$query = array('renewal.currentStatus'=>Renewal::$status[$status],
						'currentMembership'=>array('$in'=>$membership));
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array('displayName'=>true
						,'primaryPhone'=>true
						,'email'=>true
						,'timeZone'=>true
						,'_id'=>true
						,'renewal'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('renewal.submittedDate.date'=>-1);
				break;
			case 'APPROVED':
				$sort=array('renewal.approvedDate.date'=>-1);
				break;
			default:
				$sort=array('lastName'=>1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		
		return $result;

	}
    public function fetchByRenewalDonations($offset=0,$limit=100){
		$query = array('renewal'=>array('$exists'=>true),
						'renewal.contributionPaymentId'=>array('$ne'=>null));
		
		$fields = array('displayName'=>true
						,'email'=>true
						,'primaryPhone'=>true
						,'timeZone'=>true
						,'_id'=>true
						,'renewal'=>true
						);
		$sort=array('renewal.contributionPaymentId'=>-1);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
    // route for this is in c.utilities.php
    public function removeMember(){
    	// delete member
    	$this->remove();

    	// purge applications
    	self::$app['mongo']->remove(array('memberId'=>$this->_id), 'application', $justOne=false, $options=array('fsync'=>true));

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

		// purge locations
    	self::$app['mongo']->remove(array('ownerId'=>$this->_id), 'location', $justOne=false, $options=array('fsync'=>true));

    	// purge payments
    	self::$app['mongo']->remove(array('memberId'=>$this->_id), 'payment', $justOne=false, $options=array('fsync'=>true));
    	
    	// purge registrations
    	self::$app['mongo']->remove(array('memberId'=>$this->_id), 'registration', $justOne=false, $options=array('fsync'=>true));

    }
 	
}