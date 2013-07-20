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
 * board position progression progession: 
 *	regent(12 years), 
 *	dean(1yr), 
 *	dean ameritus(1yr following dean w/board vote), 
 *	fellow (forever no vote)
 * 
 */
class Member extends User {
	
	public $collection = 'member';
	public $location;// this is the member's primary address | used for primary contact and billing
	public $locations; // an array office locations
	public $barNumber;
	public $webSite;// primary website
	public $webSites;// all websites
	public $listServEmail;
	
	// order not relevant
	static public $membership = array('FACULTY'=>10,'GENERAL MEMBER'=>20,'SUSTAINING MEMBER'=>30,'FOUNDING MEMBER'=>40);
	static public $membershipReversed = array(10=>'FACULTY',20=>'GENERAL MEMBER',30=>'SUSTAINING MEMBER',40=>'FOUNDING MEMBER');
	public $currentMembership = 0;

	// order descending
	static public $order = array('FELLOW'=>60,'REGENT'=>50,'BOARD CERTIFIED'=>40,'STATE DELEGATE'=>30,'SUSTAINING MEMBER'=>20,'GENERAL MEMBER'=>10);
	static public $orderReversed = array(60=>'FELLOW',50=>'REGENT',40=>'BOARD CERTIFIED',30=>'STATE DELEGATE',20=>'SUSTAINING MEMBER',10=>'GENERAL MEMBER');
	public $currentOrder = 0;
	
	// order descending
	static public $facultyPosition = array('FELLOW'=>90,'DEAN AMERITUS'=>80,'DEAN'=>70, 'REGENT'=>60,'ASSISSTANT DEAN'=>50,'SECRETARY'=>40,'TREASURER'=>30,'DELEGATE'=>20,'FORMER REGENT'=>10);
	static public $facultyPositionReversed = array(90=>'FELLOW',80=>'DEAN AMERITUS',70=>'DEAN',60=>'REGENT',50=>'ASSISSTANT DEAN',40=>'SECRETARY',30=>'TREASURER',20=>'DELEGATE',10=>'FORMER REGENT');
	public $currentFacultyPosition = 0;
	
	public $boardCertified; // yes | no

	public $joinDate;
	public $timeZone='America/New_York';

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		
		
	}
	public function __construct($doc, Application $app, $location=array()){
		parent::__construct($doc,$app,$location);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->accessLevel = $doc['accessLevel'];
		$this->location = (is_object($location)) ? $location->__toArray() : $doc['location'];
		$this->locations = $doc['locations'];
		$this->barNumber = $doc['barNumber'];
		$this->webSite = $doc['webSite'];
		$this->webSites = $doc['webSites'];
		$this->listServEmail = $doc['listServEmail'];
		$this->currentMembership = $doc['currentMembership'];
		$this->currentOrder = $doc['currentOrder'];
		$this->currentFacultyPosition = $doc['currentFacultyPosition'];
		$this->boardCertified = $doc['boardCertified'];
        $this->joinDate = (!empty($doc['joinDate'])) ? (is_object($doc['joinDate'])) ? $doc['joinDate']->__toArray() : new Date(self::$app,$doc['joinDate'], $this->timeZone)  : $doc['joinDate'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->accessLevel = MEMBER;		
		$this->location = $this->location ?: new \StdClass();
		$this->locations = $this->locations ?: array(0=>$this->location);
		$this->barNumber = $this->barNumber ?: '';
		$this->webSite = $this->webSite ?: '';
		$this->webSites = $this->webSites ?: array(0=>$this->webSite);
		$this->listServEmail = $this->listServEmail ?: '';
		$this->currentMembership = $this->currentMembership ?: self::$membership['GENERAL MEMBER'];
		$this->currentOrder = $this->currentOrder ?: self::$order['GENERAL MEMBER'];
		$this->currentFacultyPosition = $this->currentFacultyPosition ?: 0;
		$this->joinDate = (!empty($this->joinDate)) ? (is_object($this->joinDate)) ? $this->joinDate->__toArray() : $this->joinDate  : new Date(self::$app,'now', $this->timeZone);
		$this->timeZone = $this->timeZone ?: 'America/New_York';

		parent::prepareInsert();
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function addLocation(){

	}
	public function removeLocation(){

	}
	public function addWebSite(){

	}
	public function removeWebsite(){

	}
	public static function getAccountBySession(Application $app, $fields=array(),$collection=''){
		
		$fields = array('_id','image','displayName','businessName','firstName','lastName','email','dob','gender',
						'location.phone','location.addressLine1','location.addressLine2',
						'location.city','location.state','location.zip',
						'shareWithMerchant','connections');
	
		return parent::getAccountBySession($app,$fields,$this->collection);
	}


	public static function getAccountById($userId, Application $app, $fields=array(),$collection=''){
		$fields = array('businessName','firstName','lastName','email','passwordOriginal');
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
	
	// saves user_id into session
	public function setUserSession() {
        $user = $this->findById();
        if(!empty($user)) {
			$sess_user['user_id'] 		= $user['_id'];
			$sess_user['accessLevel'] 	= $user['accessLevel'];
			$sess_user['displayName'] 	= $user['displayName'];
			self::$app['session']->set('user',$sess_user);
			return true;
        }
        return false;
    }
 	
}