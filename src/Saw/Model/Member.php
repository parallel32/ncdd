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
 */
class Member extends User {
	
	public $collection = 'member';
	public $businessName;
	public $location;// this is the member's primary address | used for primary contact and billing

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('businessName', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('signup','account-edit'))
		));
		$metadata->addPropertyConstraint('firstName', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('signup','account-edit'))
		));
		$metadata->addPropertyConstraint('lastName', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('signup','account-edit'))
		));
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('signup','account-edit'))
		));
		$metadata->addPropertyConstraint('email', new Constraints\Email(
			array('message'=>'invalid email','groups' => array('signup','account-edit'))
		));
		$metadata->addPropertyConstraint('password', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('signup'))
		));
		
	}
	public function __construct($doc, Application $app, $location=array(),$preference=array()){
		parent::__construct($doc,$app,$location,$preference);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
		$this->businessName = $doc['businessName'];
        $this->accessLevel = $doc['accessLevel'];
		$this->location = (is_object($location)) ? $location->__toArray() : $doc['location'];
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->businessName = $this->businessName ?: '';
		$this->accessLevel = MEMBER;		
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