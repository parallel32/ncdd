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
	public $orderNumState;

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
	static public $order = array('DEAN'=>65,'FELLOW'=>60,'DEAN EMERITUS'=>58,'ASSISTANT DEAN'=>57,'SECRETARY'=>56,'TREASURER'=>55,'REGENT'=>50,'BOARD CERTIFIED SR'=>47,'BOARD CERTIFIED'=>45,'FOUNDING MEMBER'=>40,'SUSTAINING MEMBER'=>35,'DELEGATE'=>20,'FORMER REGENT'=>15,'GENERAL MEMBER'=>5,'PUBLIC DEFENDER'=>3);
	static public $orderReversed = array(65=>'DEAN',60=>'FELLOW',58=>'DEAN EMERITUS',57=>'ASSISTANT DEAN',56=>'SECRETARY',55=>'TREASURER',50=>'REGENT',47=>'BOARD CERTIFIED SR',45=>'BOARD CERTIFIED',40=>'FOUNDING MEMBER',35=>'SUSTAINING MEMBER',20=>'DELEGATE',15=>'FORMER REGENT',5=>'GENERAL MEMBER',3=>'PUBLIC DEFENDER');
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
	public $boardCertifiedSr; // yes | no
	public static $boardCertifiedBadgeSr = './../../../www/ncdd.com/public_html/assets/img/badges/boardcertifiedsr.png';
	public $listed;
	public $joinDate;
	public $timeZone='America/New_York';
	public $yearsinpractice;
	public $changeAccessLevelTo;
	public $renewal;
	public $payment;
	public $credit;
	
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
			$this->boardCertifiedSr = 0;
		}else if(strtolower($doc['boardCertified']) == 'yes2'){
			$this->boardCertified = 0;
			$this->boardCertifiedSr = 1;
		}else if(strtolower($doc['boardCertified']) == 'no'){
			$this->boardCertified = 0;
			$this->boardCertifiedSr = 0;
		}else if(is_numeric($doc['boardCertified'])){
			$this->boardCertified = (int)$doc['boardCertified'];
		}
		if(is_numeric($doc['boardCertifiedSr'])){
			$this->boardCertifiedSr = (int)$doc['boardCertifiedSr'];
		}

		if(!empty($doc['joinDate'])){
			if(is_object($doc['joinDate'])){
				$this->joinDate = $doc['joinDate']->__toArray();
			}
			if(is_array($doc['joinDate'])){
				$this->joinDate = $doc['joinDate'];
			}
			if(is_string($doc['joinDate'])){
				$this->joinDate = new Date(self::$app,$doc['joinDate'], $this->timeZone);
			}	
		}else{
			$this->joinDate = '';
		}
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
		$this->credit = $doc['credit'];
		$this->renewal = (is_object($doc['renewal'])) ? $doc['renewal']->__toArray(): $doc['renewal'];
		$this->payment = (is_object($doc['payment'])) ? $doc['payment']->__toArray(): $doc['payment'];

		// * means no order number present. use this because can't use zero, they'll shoot strait to the top
		$this->orderNum = (!empty($doc['orderNum'])) ? ( $doc['orderNum'] == '*') ? $doc['orderNum']: (int)$doc['orderNum'] : ''; 
		// * means no order number present. use this because can't use zero, they'll shoot strait to the top
		$this->orderNumState = (!empty($doc['orderNumState'])) ? ( $doc['orderNumState'] == '*') ? $doc['orderNumState']: (int)$doc['orderNumState'] : ''; 
		

		$this->currentMembership = (!empty($doc['currentMembership'])) ? (int)$doc['currentMembership']: null;

		if($doc['currentFacultyPosition'] === 0 || $doc['currentFacultyPosition'] == "0"){
			$this->currentFacultyPosition = 0;
			$this->staff = 0;	 
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
		if($this->boardCertifiedSr){
			array_push($order_arr, self::$order['BOARD CERTIFIED SR']);	
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

		if(strtolower($doc['staff']) == 'yes'){
			$this->staff = 1;
		}else if(strtolower($doc['staff']) == 'no'){
			$this->staff = 0;
		}else if(is_numeric($doc['staff'])){
			$this->staff = (int)$doc['staff'];
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
		$this->boardCertifiedSr = $this->boardCertifiedSr ?: 0;
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
		$this->orderNumState = $this->orderNumState ?: '*';
		$this->changeAccessLevelTo = $this->changeAccessLevelTo ?: $this->accessLevel;
		$this->renewal = $this->renewal ?: null;
		$this->payment = $this->payment ?: null;
		$this->credit = $this->credit ?: null;

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

	public static function isState($string){
		$res=false;
		$states = array('alabama'=>'AL','alaska'=>'AK','arizona'=>'AZ','arkansas'=>'AR','california'=>'CA','colorado'=>'CO','connecticut'=>'CT','delaware'=>'DE','washington dc'=>'DC','florida'=>'FL','georgia'=>'GA','hawaii'=>'HI','idaho'=>'ID','illinois'=>'IL','indiana'=>'IN','iowa'=>'IA','kansas'=>'KS','kentucky'=>'KY','louisiana'=>'LA','maine'=>'ME','maryland'=>'MD','massachusetts'=>'MA','michigan'=>'MI','minnesota'=>'MN','mississippi'=>'MS','missouri'=>'MO','montana'=>'MT','nebraska'=>'NE','nevada'=>'NV','new hampshire'=>'NH','new jersey'=>'NJ','new mexico'=>'NM','new york'=>'NY','north carolina'=>'NC','north dakota'=>'ND','ohio'=>'OH','oklahoma'=>'OK','oregon'=>'OR','pennsylvania'=>'PA','rhode island'=>'RI','south carolina'=>'SC','south dakota'=>'SD','tennessee'=>'TN','texas'=>'TX','utah'=>'UT','vermont'=>'VT','virginia'=>'VA','washington'=>'WA','west virginia'=>'WV','wisconsin'=>'WI','wyoming'=>'WY','ontario'=>'ON','quebec'=>'QC','saskatchewan'=>'SK');
		if(array_key_exists(strtolower($string),$states)){
			$res = $states[strtolower($string)];
		}
		if(in_array(strtoupper($string),$states)){
			$res = strtoupper($string);
		}

		return $res;
	}
	public function search($string,$listedOnly=false){
		$result = array();
		if(self::isState($string) !== false){
			$state = self::isState($string);
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
					,'boardCertifiedSr'=>1
					,'staff'=>1
					,'listed'=>1
					,'websites'=>1
					,'orderNum'=>1
					,'orderNumState'=>1
					,'location'=>1
					,'aboutMe'=>1
					);

		switch ($string) {
			case 'email':
				$search = new \MongoRegex("/".$email."/i");
				if($listedOnly){
					$result = $this->find($query=array('email'=>$search,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('email'=>$search),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'state':
				//$result = $this->find($query=array('location.state'=>$state,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				//*
				$m_fields = array();
				foreach ($fields as $key => $value) {
					$m_fields['member.'.$key]=$value;
				}
				if($listedOnly){
					$query=array('state'=>$state,'member.listed'=>1);
				}else{
					$query=array('state'=>$state);
				}
				$m_result = self::$app['mongo']->find('location', $query,$m_fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1,'member.orderNumState'=>1));
				//error_log('query:'.print_r($query,true));
				//error_log('result:'.print_r($m_result,true));
				//echo "<pre>".print_r($m_result);echo "</pre>";
				$i=0;
				foreach ($m_result as $key => $value) {
					$result[$i]['_id'] = (array_key_exists('_id',$value['member'])) ? $value['member']['_id'] : '';
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
					$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr',$value['member'])) ? $value['member']['boardCertifiedSr']: '';
					$result[$i]['staff'] = (array_key_exists('staff',$value['member'])) ? $value['member']['staff']: '';
					$result[$i]['listed'] = $value['member']['listed'];
					$result[$i]['websites'] = $value['member']['websites'];
					$result[$i]['orderNum'] = $value['member']['orderNum'];
					$result[$i]['orderNumState'] = (array_key_exists('orderNumState',$value['member'])) ? $value['member']['orderNumState']: '';
					$result[$i]['aboutMe'] = $value['member']['aboutMe'];
					$i++;
				}
				//*/
				break;
			case 'Sustaining Members':
				if($listedOnly){
					$result = $this->find($query=array('currentMembership'=>self::$membership['SUSTAINING MEMBER'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentMembership'=>self::$membership['SUSTAINING MEMBER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'General Members':
				if($listedOnly){
					$result = $this->find($query=array('currentMembership'=>self::$membership['GENERAL MEMBER'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentMembership'=>self::$membership['GENERAL MEMBER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'Public Defenders':
				if($listedOnly){
					$result = $this->find($query=array('currentMembership'=>self::$membership['PUBLIC DEFENDER'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentMembership'=>self::$membership['PUBLIC DEFENDER']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
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
				if($listedOnly){
					$result = $this->find($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW']),'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'])),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'Fellows':
				if($listedOnly){
					$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'Former Regents':
				if($listedOnly){
					$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FORMER REGENT'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['FORMER REGENT']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'State Delegates':
				if($listedOnly){
					$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['DELEGATE'],'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('currentFacultyPosition'=>self::$facultyPosition['DELEGATE']),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				$i=0;
				foreach ($result as $key => $value) {
					$location_result = self::$app['mongo']->findOne('location', $query=array('member._id'=>$value['_id']),array('raw'=>true),$slaveOkay=true);
					$result[$i]['location'] = array('raw'=>$location_result['raw']);
					$i++;
				}
				break;
			case 'Faculty':
				if($listedOnly){
					//$result = $this->find($query=array('currentFacultyPosition'=>array('$gte'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'],'$ne'=>self::$facultyPosition['REGENT']),'listed'=>1),$fields,true,$sort=array('lastName'=>1,'firstName'=>1),$offset=0,$limit=3000);
					$result = $this->find($query=array(
						'staff'=>1
						,'currentFacultyPosition'=>array(
							'$nin'=>array(
								self::$facultyPosition['FELLOW']
								,self::$facultyPosition['DEAN']
								,self::$facultyPosition['DEAN EMERITUS']
								,self::$facultyPosition['ASSISTANT DEAN']
								,self::$facultyPosition['SECRETARY']
								,self::$facultyPosition['TREASURER']
								,self::$facultyPosition['REGENT']
								,self::$facultyPosition['FORMER REGENT']
							)
						)
						,'listed'=>1
					),$fields,true,$sort=array('lastName'=>1,'firstName'=>1),$offset=0,$limit=3000);
				}else{
					//$result = $this->find($query=array('currentFacultyPosition'=>array('$gte'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'],'$ne'=>self::$facultyPosition['REGENT'])),$fields,true,$sort=array('lastName'=>1,'firstName'=>1),$offset=0,$limit=3000);
					$result = $this->find($query=array(
						'staff'=>1
						,'currentFacultyPosition'=>array(
							'$nin'=>array(
								self::$facultyPosition['FELLOW']
								,self::$facultyPosition['DEAN']
								,self::$facultyPosition['DEAN EMERITUS']
								,self::$facultyPosition['ASSISTANT DEAN']
								,self::$facultyPosition['SECRETARY']
								,self::$facultyPosition['TREASURER']
								,self::$facultyPosition['REGENT']
								,self::$facultyPosition['FORMER REGENT']
							)
						)
					),$fields,true,$sort=array('lastName'=>1,'firstName'=>1),$offset=0,$limit=3000);
				}
				$i=0;
				foreach ($result as $key => $value) {
					$location_result = self::$app['mongo']->findOne('location', $query=array('member._id'=>$value['_id']),array('raw'=>true),$slaveOkay=true);
					$result[$i]['location'] = array('raw'=>$location_result['raw']);
					$i++;
				}
				break;
			case 'Board Certified':
				if($listedOnly){
					$result = $this->find($query=array('boardCertified'=>1,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('boardCertified'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'Board Certified Sr':
				if($listedOnly){
					$result = $this->find($query=array('boardCertifiedSr'=>1,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('boardCertifiedSr'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			case 'Staff':
				if($listedOnly){
					$result = $this->find($query=array('staff'=>1,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}else{
					$result = $this->find($query=array('staff'=>1),$fields,true,$sort=array('currentOrder'=>-1,'orderNum'=>1),$offset=0,$limit=3000);		
				}
				break;
			
			default:
			/* regex parts

			/^  --> the first part

			.*?\bkeyword1\b
			.*?\bkeyword2\b
			.*?\bkeyword3\b

			.*?$/im --> the last part

			ref: http://stackoverflow.com/questions/2219830/regular-expression-to-find-two-strings-anywhere-in-input

			//*/
				$result = array();
				$search_arr = explode(' ', $string);
				if(is_array($search_arr)){
					$regex = '/^';
					foreach ($search_arr as $key) {
						$regex .= '.*?\b'.addslashes($key).'\b';
					}
					$regex.= '.*?$/im';

					$regex = new \MongoRegex($regex);
					if($listedOnly){
						$result = $this->find($query=array('displayName'=>$regex,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1),$offset=0,$limit=3000);		
					}else{
						$result = $this->find($query=array('displayName'=>$regex),$fields,true,$sort=array('currentOrder'=>-1),$offset=0,$limit=3000);		
					}
				}
				break;
		}
		
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) {
				$result[$i]['image'] = (!empty($result[$i]['image'])) ? $result[$i]['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
				$result[$i]['currentOrder'] = (!empty($result[$i]['currentOrder'])) ? self::$orderReversed[$result[$i]['currentOrder']] : '';
				$result[$i]['currentMembership'] = (!empty($result[$i]['currentMembership'])) ? self::$membershipReversed[$result[$i]['currentMembership']] : '';
				$result[$i]['currentFacultyPosition'] = (!empty($result[$i]['currentFacultyPosition'])) ? self::$facultyPositionReversed[$result[$i]['currentFacultyPosition']] : '';
				$result[$i]['boardCertified'] = ($result[$i]['boardCertified']) ? "Yes" : "No";
				$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $result[$i]) && $result[$i]['boardCertifiedSr']) ? "Yes" : "No";
				$result[$i]['staff'] = ((array_key_exists('staff',$result[$i])) ? $result[$i]['staff']: '') ? "Yes" : "No";
				$result[$i]['listed'] = ($result[$i]['listed']) ? "Yes" : "No";
				$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
				$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
				$result[$i]['staffBadge'] = self::$staffBadge;
			}
		endif;
		return $result;
	}

	public function searchBio($string,$listedOnly=false){
		$result = array();
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
					,'boardCertifiedSr'=>1
					,'staff'=>1
					,'listed'=>1
					,'websites'=>1
					,'orderNum'=>1
					,'orderNumState'=>1
					,'location'=>1
					,'aboutMe'=>1
					);
		/* regex parts

		/^  --> the first part

		.*?\bkeyword1\b
		.*?\bkeyword2\b
		.*?\bkeyword3\b

		.*?$/im --> the last part

		ref: http://stackoverflow.com/questions/2219830/regular-expression-to-find-two-strings-anywhere-in-input

		//*/
		$result = array();
		$search_arr = explode(' ', $string);
		if(is_array($search_arr)){
			$regex = '/^';
			foreach ($search_arr as $key) {
				$regex .= '.*?\b'.addslashes($key).'\b';
			}
			$regex.= '.*?$/im';

			$regex = new \MongoRegex($regex);
			if($listedOnly){
				$result = $this->find($query=array('aboutMe'=>$regex,'listed'=>1),$fields,true,$sort=array('currentOrder'=>-1),$offset=0,$limit=3000);		
			}else{
				$result = $this->find($query=array('aboutMe'=>$regex),$fields,true,$sort=array('currentOrder'=>-1),$offset=0,$limit=3000);		
			}
		}
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) {
				$result[$i]['image'] = (!empty($result[$i]['image'])) ? $result[$i]['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
				$result[$i]['currentOrder'] = (!empty($result[$i]['currentOrder'])) ? self::$orderReversed[$result[$i]['currentOrder']] : '';
				$result[$i]['currentMembership'] = (!empty($result[$i]['currentMembership'])) ? self::$membershipReversed[$result[$i]['currentMembership']] : '';
				$result[$i]['currentFacultyPosition'] = (!empty($result[$i]['currentFacultyPosition'])) ? self::$facultyPositionReversed[$result[$i]['currentFacultyPosition']] : '';
				$result[$i]['boardCertified'] = ($result[$i]['boardCertified']) ? "Yes" : "No";
				$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $result[$i]) && $result[$i]['boardCertifiedSr']) ? "Yes" : "No";
				$result[$i]['staff'] = ((array_key_exists('staff',$result[$i])) ? $result[$i]['staff']: '') ? "Yes" : "No";
				$result[$i]['listed'] = ($result[$i]['listed']) ? "Yes" : "No";
				$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
				$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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
					,'member.boardCertifiedSr'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		// order number
		$result = self::$app['mongo']->find('location',array('state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1,'member.orderNumState'=>1));
		// join date
		//$result = self::$app['mongo']->find('location',array('state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1));
		
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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
					,'member.boardCertifiedSr'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.currentMembership'=>self::$membership['FOUNDING MEMBER'], 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1,'member.orderNumState'=>1));
		
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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

	public function searchSustainingMembersByState($state){

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
					,'member.boardCertifiedSr'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.currentMembership'=>self::$membership['SUSTAINING MEMBER'], 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1,'member.orderNumState'=>1));
		
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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
	public function searchFacultyByState($state){

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
					,'member.boardCertifiedSr'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.staff'=>1,'member.currentFacultyPosition'=>array(
			'$nin'=>array(
				self::$facultyPosition['FELLOW']
				,self::$facultyPosition['DEAN']
				,self::$facultyPosition['DEAN EMERITUS']
				,self::$facultyPosition['ASSISTANT DEAN']
				,self::$facultyPosition['SECRETARY']
				,self::$facultyPosition['TREASURER']
				,self::$facultyPosition['REGENT']
				,self::$facultyPosition['FORMER REGENT']
			)
		), 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.lastName'=>1,'member.firstName'=>1));
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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

	public function searchBoardCertifiedByState($state){

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
					,'member.boardCertifiedSr'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.boardCertified'=>1, 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1,'member.orderNumState'=>1));
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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

	public function searchBoardCertifiedSrByState($state){

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
					,'member.boardCertifiedSr'=>1
					,'member.staff'=>1
					,'member.websites'=>1
					,'raw'=>1
					);
		
		$result = self::$app['mongo']->find('location',array('member.boardCertifiedSr'=>1, 'state'=>$state,'member.listed'=>1),$fields,$slaveOkay=true,$offset=0,$limit=3000,$sort=array('member.currentOrder'=>-1,'member.joinDate.date'=>1,'member.orderNumState'=>1));
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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
					,'member.boardCertifiedSr'=>1
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
			$result[$i]['image'] = (!empty($value['member']['image'])) ? $value['member']['image']['urls']['small']['SSLCDN'] : '/noprofileimage';
			$result[$i]['currentMembership'] = (!empty($value['member']['currentMembership'])) ? self::$membershipReversed[$value['member']['currentMembership']] : '';;
			$result[$i]['currentFacultyPosition'] = (!empty($value['member']['currentFacultyPosition'])) ? self::$facultyPositionReversed[$value['member']['currentFacultyPosition']] : '';
			$result[$i]['boardCertified'] = ($value['member']['boardCertified']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadge'] = self::$boardCertifiedBadge;
			$result[$i]['boardCertifiedSr'] = (array_key_exists('boardCertifiedSr', $value['member']) && $value['member']['boardCertifiedSr']) ? "Yes" : "No";
			$result[$i]['boardCertifiedBadgeSr'] = self::$boardCertifiedBadgeSr;
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

	public function searchCount($string,$listedOnly=true){
		$result = array();
		
		switch ($string) {
			case 'Sustaining Members':
				if($listedOnly){
					$result = $this->count($query=array('currentMembership'=>self::$membership['SUSTAINING MEMBER'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentMembership'=>self::$membership['SUSTAINING MEMBER']),true);		
				}
				break;
			case 'General Members':
				if($listedOnly){
					$result = $this->count($query=array('currentMembership'=>self::$membership['GENERAL MEMBER'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentMembership'=>self::$membership['GENERAL MEMBER']),true);		
				}
				break;
			case 'Public Defenders':
				if($listedOnly){
					$result = $this->count($query=array('currentMembership'=>self::$membership['PUBLIC DEFENDER'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentMembership'=>self::$membership['PUBLIC DEFENDER']),true);		
				}
				break;
			case 'Founding Members':
				if($listedOnly){
					$result = $this->count($query=array('currentMembership'=>self::$membership['FOUNDING MEMBER'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentMembership'=>self::$membership['FOUNDING MEMBER']),true);		
				}
				break;
			case 'Regents':
				if($listedOnly){
					$result = $this->count($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW']),'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentFacultyPosition'=>array('$gt'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'])),true);		
				}
				break;
			case 'Fellows':
				if($listedOnly){
					$result = $this->count($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentFacultyPosition'=>self::$facultyPosition['FELLOW']),true);		
				}
				break;
			case 'Former Regents':
				if($listedOnly){
					$result = $this->count($query=array('currentFacultyPosition'=>self::$facultyPosition['FORMER REGENT'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentFacultyPosition'=>self::$facultyPosition['FORMER REGENT']),true);		
				}
				break;
			case 'State Delegates':
				if($listedOnly){
					$result = $this->count($query=array('currentFacultyPosition'=>self::$facultyPosition['DELEGATE'],'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('currentFacultyPosition'=>self::$facultyPosition['DELEGATE']),true);		
				}
				break;
			case 'Faculty':
				if($listedOnly){
					//$result = $this->count($query=array('currentFacultyPosition'=>array('$gte'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'],'$ne'=>self::$facultyPosition['REGENT']),'listed'=>1),true,$sort=array('lastName'=>1,'firstName'=>1),$offset=0,$limit=3000);
					$result = $this->count($query=array(
						'staff'=>1
						,'currentFacultyPosition'=>array(
							'$nin'=>array(
								self::$facultyPosition['FELLOW']
								,self::$facultyPosition['DEAN']
								,self::$facultyPosition['DEAN EMERITUS']
								,self::$facultyPosition['ASSISTANT DEAN']
								,self::$facultyPosition['SECRETARY']
								,self::$facultyPosition['TREASURER']
								,self::$facultyPosition['REGENT']
								,self::$facultyPosition['FORMER REGENT']
							)
						)
						,'listed'=>1
						,'status'=>USER_STATUS_ACTIVE
					),true);
				}else{
					//$result = $this->count($query=array('currentFacultyPosition'=>array('$gte'=>self::$facultyPosition['DELEGATE'],'$lt'=>self::$facultyPosition['FELLOW'],'$ne'=>self::$facultyPosition['REGENT'])),true,$sort=array('lastName'=>1,'firstName'=>1),$offset=0,$limit=3000);
					$result = $this->count($query=array(
						'staff'=>1
						,'currentFacultyPosition'=>array(
							'$nin'=>array(
								self::$facultyPosition['FELLOW']
								,self::$facultyPosition['DEAN']
								,self::$facultyPosition['DEAN EMERITUS']
								,self::$facultyPosition['ASSISTANT DEAN']
								,self::$facultyPosition['SECRETARY']
								,self::$facultyPosition['TREASURER']
								,self::$facultyPosition['REGENT']
								,self::$facultyPosition['FORMER REGENT']
							)
						)
					),true);
				}
				break;
			case 'Board Certified':
				if($listedOnly){
					$result = $this->count($query=array('boardCertified'=>1,'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('boardCertified'=>1),true);		
				}
				break;
			case 'Board Certified Sr':
				if($listedOnly){
					$result = $this->count($query=array('boardCertifiedSr'=>1,'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('boardCertifiedSr'=>1),true);		
				}
				break;
			case 'Staff':
				if($listedOnly){
					$result = $this->count($query=array('staff'=>1,'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
				}else{
					$result = $this->count($query=array('staff'=>1),true);		
				}
				break;
			
			default:
			/* regex parts

			/^  --> the first part

			.*?\bkeyword1\b
			.*?\bkeyword2\b
			.*?\bkeyword3\b

			.*?$/im --> the last part

			ref: http://stackoverflow.com/questions/2219830/regular-expression-to-find-two-strings-anywhere-in-input

			//*/
				$result = array();
				$search_arr = explode(' ', $string);
				if(is_array($search_arr)){
					$regex = '/^';
					foreach ($search_arr as $key) {
						$regex .= '.*?\b'.addslashes($key).'\b';
					}
					$regex.= '.*?$/im';

					$regex = new \MongoRegex($regex);
					if($listedOnly){
						$result = $this->count($query=array('displayName'=>$regex,'listed'=>1,'status'=>USER_STATUS_ACTIVE),true);		
					}else{
						$result = $this->count($query=array('displayName'=>$regex),true);		
					}
				}
				break;
		}
		
		return $result;
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
	public function updateOrderNumState(){
    	if(!empty($this->_id) && !empty($this->orderNumState)){
    		$this->saveEdit();
    	}
    	return true;
    }

    public function fetchByRenewalStatus($status, $membership=array(), $offset=0,$limit=100,$filter=array()){
		$query = array('status'=>USER_STATUS_ACTIVE,
						'renewal.currentStatus'=>Renewal::$status[$status],
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
						,'payment'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('renewal.submittedDate.date'=>-1);
				break;
			case 'APPROVED':
				$sort=array('renewal.approvedDate.date'=>-1);
				break;
			case 'PAID':
				$sort=array('renewal.paidDate.date'=>-1);
				break;
			default:
				$sort=array('lastName'=>1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		
		return $result;

	}

    public function fetchByRenewalStatusPaymentType($status, $membership=array(), $offset=0,$limit=100,$filter=array()){
		$query = array('status'=>USER_STATUS_ACTIVE,
						'renewal.currentStatus'=>Renewal::$status[$status],
						'renewal.payByCheck'=>array('$in'=>array('no','no-store','')),
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
						,'payment'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('renewal.submittedDate.date'=>-1);
				break;
			case 'APPROVED':
				$sort=array('renewal.approvedDate.date'=>-1);
				break;
			case 'PAID':
				$sort=array('renewal.paidDate.date'=>-1);
				break;
			default:
				$sort=array('lastName'=>1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		
		return $result;

	}

    public function fetchByPaymentStatus($status, $membership=array(), $offset=0,$limit=100,$filter=array()){

    	switch ($status) {
    		case 'unpaid-PAYBYCHECK':
    			$query = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['APPROVED']
						,'renewal.payByCheck'=>'yes'
						,'currentMembership'=>array('$in'=>$membership)
						);		
    			break;
    		case 'paid-PAYBYCHECK':
    			$query = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'renewal.payByCheck'=>'yes'
						,'currentMembership'=>array('$in'=>$membership)
						);
    			break;
    		case 'paid-CC':
    			$query = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'payment.renewalREUSE'=>array('$ne'=>'yes')
						,'payment.number'=>array('$exists'=>true)
						,'$where'=>'this.payment.number.length > 3'
						,'currentMembership'=>array('$in'=>$membership)
						);
    			break;
    		case 'paid-CCRECUR':
    			$query = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'payment.renewalREUSE'=>'yes'
						,'payment.number'=>array('$exists'=>true)
						,'$where'=>'this.payment.number.length > 3'
						,'currentMembership'=>array('$in'=>$membership)
						);
    			break;    		
    	}

		
		if(!empty($filter)){
			$query = array_merge($filter, $query);
		}
		$fields = array('displayName'=>true
						,'_id'=>true
						,'renewal'=>true
						,'payment'=>true
						);
		
		$result = $this->find($query,$fields,$slaveOkay=true,array(),(int)$offset,(int)$limit);
		
		if($status == 'paid-CC'){
			$fields = array('_id'=>true);	
			$query1 = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'currentMembership'=>array('$in'=>$membership)
						);
			$result1 = $this->find($query1,$fields,$slaveOkay=true,array(),(int)$offset,(int)$limit);
			for ($i=0; $i < count($result1); $i++) { 
				$result1[$i] = $result1[$i]['_id']->__toString();
			}
			$query2 = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'renewal.payByCheck'=>'yes'
						,'currentMembership'=>array('$in'=>$membership)
						);
			$result2 = $this->find($query2,$fields,$slaveOkay=true,array(),(int)$offset,(int)$limit);
			for ($i=0; $i < count($result2); $i++) { 
				$result2[$i] = $result2[$i]['_id']->__toString();
			}
			$query3 = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'payment.renewalREUSE'=>array('$ne'=>'yes')
						,'payment.number'=>array('$exists'=>true)
						,'$where'=>'this.payment.number.length > 3'
						,'currentMembership'=>array('$in'=>$membership)
						);
			$result3 = $this->find($query3,$fields,$slaveOkay=true,array(),(int)$offset,(int)$limit);
			for ($i=0; $i < count($result3); $i++) { 
				$result3[$i] = $result3[$i]['_id']->__toString();
			}
			
			$query4 = array('status'=>USER_STATUS_ACTIVE
						,'renewal.currentStatus'=>Renewal::$status['PAID']
						,'payment.renewalREUSE'=>'yes'
						,'payment.number'=>array('$exists'=>true)
						,'$where'=>'this.payment.number.length > 3'
						,'currentMembership'=>array('$in'=>$membership)
						);
			$result4 = $this->find($query4,$fields,$slaveOkay=true,array(),(int)$offset,(int)$limit);
			for ($i=0; $i < count($result4); $i++) { 
				$result4[$i] = $result4[$i]['_id']->__toString();
			}
			
			
			$final = array_diff($result1, $result2, $result3, $result4);
			$result = array_merge($result,$final);
			
		}
		
		return count($result);

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
    public function fetchByRenewalCredit($offset=0,$limit=100){
		$query = array('payment.renewalCredit'=>array('$exists'=>true),
						'payment.renewalCredit'=>array('$ne'=>null));
		
		$fields = array('displayName'=>true
						,'email'=>true
						,'primaryPhone'=>true
						,'timeZone'=>true
						,'_id'=>true
						,'renewal'=>true
						,'payment'=>true
						);
		$sort=array('lastName'=>11);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		$resultb = array();
		for ($i=0; $i < count($result); $i++) { 
			if($result[$i]['payment']['renewalCredit'] != '-' && strlen($result[$i]['payment']['renewalCredit']) > 1){
				$resultb[] = $result[$i];	
			}
			
		}
		//error_log('fetch:'.print_r($result,true));
		return $resultb;

	}

	public function fetchForCSV($membership,$filter=array()){

		$fields=array(
					'member.firstName'=>1
					,'member.middleName'=>1
					,'member.lastName'=>1
					,'member.primaryPhone'=>1
					,'member.email'=>1
					,'addressLine1'=>1
					,'addressLine2'=>1
					,'city'=>1
					,'state'=>1
					,'zip'=>1
					,'country'=>1
					);
		
		switch ($membership) {
			case self::$membership['PUBLIC DEFENDER']:
				$query = array('member.currentMembership'=>self::$membership['PUBLIC DEFENDER'],'member.listed'=>1);
				$query = array_merge($filter, $query);
				break;
			case self::$membership['SUSTAINING MEMBER']:
				$query = array('member.currentMembership'=>self::$membership['SUSTAINING MEMBER'],'member.listed'=>1);
				$query = array_merge($filter, $query);
				break;
			case self::$membership['GENERAL MEMBER']:
				$query = array('member.currentMembership'=>self::$membership['GENERAL MEMBER'],'member.listed'=>1);
				$query = array_merge($filter, $query);
				break;
			case self::$membership['FOUNDING MEMBER']:
				$query = array('member.currentMembership'=>self::$membership['FOUNDING MEMBER'],'member.listed'=>1);
				$query = array_merge($filter, $query);
				break;
		}
		$result = self::$app['mongo']->find('location',$query,$fields,$slaveOkay=true,$offset=0,$limit=4000,$sort=array('member.lastName'=>1));
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

    	// delete drive files
		$drive = new Drive(array('belongsTo'=>$this->_id),self::$app);
		$drive->deleteAll();

    }
 	
}