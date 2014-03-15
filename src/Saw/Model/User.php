<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * User model. This is the base class for Clients or future user types
 * This class does not represent a collection just base schema
 * and functionality for the concept of a User in the system
 */
class User extends Model {
	
	public static $invalidFieldsMessage = "Invalid fields found.";
	public $displayName;
	public $firstName;
	public $middleName;
	public $lastName;
	public $gender;
	public $dob;
	public $email;
	public $password;
	public $passwordOriginal;
	public $lastLogin;
    public $lastLogout;
	public $locale;
    public $image;
	public $profileImageUrl;
	public $slug;
	public $status;
    public $accessLevel;
	public $connections;
	public $timezone;
	public $forgotPasswordToken;
	public $verifyEmailToken;
	public $preference;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('email', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('login','forgot-password'))
		));
		$metadata->addPropertyConstraint('email', new Constraints\Email(
			array('message'=>'invalid email','groups' => array('login','forgot-password'))
		));
		$metadata->addPropertyConstraint('password', new Constraints\NotBlank(
			array('message'=>'cannot be blank','groups' => array('login','reset-password'))
		));
		
	}

	public function __construct($doc, Application $app, $location=array(),$preference=array()){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
		
		if(!empty($doc['firstName']) && !empty($doc['lastName']) && empty($doc['displayName'])){
			if(!empty($doc['middleName'])){
				$this->displayName = $doc['firstName'].' '.$doc['middleName'].' '.$doc['lastName'];
			}else{
				$this->displayName = $doc['firstName'].' '.$doc['lastName'];
			}
		}else
			$this->displayName = $doc['displayName'];
        $this->email = trim(strtolower($doc['email'])); 
		$this->password = (!empty($doc['password'])) ? self::sawPassword($doc['password']): '';
		$this->firstName = $doc['firstName'];
		$this->middleName = $doc['middleName'];
		$this->lastName = $doc['lastName'];
		$this->gender = $doc['gender'];
        $this->dob = (!empty($doc['dob'])) ? (is_object($doc['dob'])) ? $doc['dob']->__toArray() : new Date(self::$app,$doc['dob'])  : $doc['dob'];
		$this->locale = $doc['locale'];
        $this->image = $doc['image'];
		$this->profileImageUrl = $doc['profileImageUrl'];
		$this->slug = $doc['slug'];
		
		//$this->status = (!empty($doc['status'])) ? ($doc['status']=='yes') ? USER_STATUS_ACTIVE: USER_STATUS_INACTIVE : '' ;

		if(strtolower($doc['status']) == 'yes'){
			$this->status = USER_STATUS_ACTIVE;
		}else if(strtolower($doc['status']) == 'no'){
			$this->status = USER_STATUS_INACTIVE;
		}else if(is_numeric($doc['status'])){
			$this->status = (int)$doc['status'];
		}
		

		$this->accessLevel = $doc['accessLevel'];
		$this->connections = $doc['connections'];
		$this->location = (is_object($location)) ? $location->__toArray() : (array_key_exists('location',$doc)) ? $doc['location']: '' ;
		if(!empty($doc['timezone']['name'])){
			$tz = new TimeZone($doc=array('name'=>$doc['timezone']['name']),$app);
			$doc['timezone'] = $tz->getAttributes();
		}
		$this->timezone = $doc['timezone'];
		$this->forgotPasswordToken = (array_key_exists('forgotPasswordToken',$doc)) ? $doc['forgotPasswordToken'] : '';
		$this->verifyEmailToken = (array_key_exists('verifyEmailToken',$doc)) ? $doc['verifyEmailToken'] : '';
		if(is_object($preference)){
			$this->preference = $preference->__toArray();
		}else if (array_key_exists('preference',$doc)){
			$this->preference = $doc['preference'];
		}else{
			$this->preference = '';
		}
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->firstName = $this->firstName ?: '';
		$this->middleName = $this->middleName ?: '';
		$this->lastName = $this->lastName ?: '';        		
		$this->gender = $this->gender ?: '';
		$this->dob = (!empty($this->dob)) ? (is_object($this->dob)) ? $this->dob->__toArray() : $this->dob  : new \stdClass();
		$this->email = (!empty($this->email)) ? trim(strtolower($this->email)) : '';
		$this->password = $this->password ?: '';
		$this->lastLogin = new \MongoDate();
	    $this->lastLogout = new \MongoDate();
		$this->locale = $this->locale ?: 'en_US';
		$this->image = $this->image ?: new \stdClass();
		if(empty($this->image) && !empty($this->profileImageUrl)){
			 $this->image = $this->createProfileImageFromUrl($this->profileImageUrl);
		}else{
			$this->profileImageUrl = $this->profileImageUrl ?: '';
		}
        $this->accessLevel = $this->accessLevel ?: MEMBER;
        if($this->accessLevel <= ADMIN) {
            $this->displayName = $this->firstName;
            if(!empty($this->middleName)) $this->displayName.=' '.$this->middleName;
            if(!empty($this->lastName)) $this->displayName.=' '.$this->lastName;
        }
        $this->displayName = $this->displayName ?: $this->firstName.' '.$this->lastName;             
		$this->slug = $this->createSlug($this->displayName);
		$this->status = $this->status ?: USER_STATUS_ACTIVE;	    
		$this->connections = $this->connections ?: array();
		$this->location = $this->location ?: new \stdClass();
		$this->timezone = $this->timezone ?: array();
		$this->forgotPasswordToken = $this->forgotPasswordToken ?: '';
		$this->verifyEmailToken = $this->verifyEmailToken ?: '';
		$this->preference = $this->preference ?: new Preference($doc=array(),self::$app);
		
	}
	
	public function insert(){
		if(parent::insert()){
            if($this->saveSafe()) {
                return $this->_id;
            }
            else{
                throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed (password).  Please try again.");
            }            
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}

	public function upsert(){
		parent::upsert();
	}
	
	public static function getUser(Application $app,$query,$fields,$collection) {
		return $app['mongo']->findOne($collection,$query,$fields,$slaveOkay=true);
	}

	public static function getUserBySession(Application $app, $collection){
		
		$user_id = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
		$user_doc = array();
		if(!empty($user_id)) {
			$query = array('_id'=>$user_id);
			$user_doc = $app['mongo']->findOne($collection, $query, $fields=array(), $slaveOkay=true);
		}
		return (!empty($user_doc)) ? $user_doc : false ;

	}

	public static function getAccountBySession(Application $app,$fields,$collection){

		$user_id = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$app);
		$user_doc = array();
		if(!empty($user_id)) {
			$query = array('_id'=>$user_id);
			$user_doc = $app['mongo']->findOne($collection, $query, $fields, $slaveOkay=true);
		}
		return (!empty($user_doc)) ? $user_doc : false ;

	}

	public static function getAccountById($userId, Application $app,$fields,$collection){

		$userId = (is_object($userId)) ? $userId : new \MongoId($userId);

		$user_doc = array();
		if(!empty($userId)) {
			$query = array('_id'=>$userId);
			$user_doc = $app['mongo']->findOne($collection, $query, $fields, $slaveOkay=true);
		}
		return (!empty($user_doc)) ? $user_doc : false ;

	}
	
	public function isValidPassword(){
		$query = array('_id'=>$this->_id);
		$fields = array('password');
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		if(!empty($result)):
			error_log('db pass:'.$this->password);
			error_log('entered pass:'.$result['password']);
            if($this->password === $result['password']) {
                return true;
            }
            return false;
		else:
            return false;
		endif;

	}
	public function editSave(){
		return $this->saveSafe();
	}
	public function setTimezone(TimeZone $timezone){
		$this->timezone = $timezone->__toArray();
	}
	public function getTimeZone(){
		$query = array('_id'=>$this->_id);
		$fields = array('timezone'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result) && array_key_exists('timezone',$result)):
			return $result;
		else:
			return false;
		endif;
	}
	public function setLocation(Location $location){
		$this->location = $location->__toArray();
	}
	// loads up the user session always returns true 
	public function authenticate(){ 
		if($this->updateLastLogin()):
			return $this->setUserSession();
		else:
			// this could be false because it's Admin trying to log-in

			return false;
		endif;
	}
    
  	// saves session flash
	public static function setFlash($app, $message,$redirect) {
		$flash['message'] 	= $message;
		$flash['redirect']	= $redirect;
		$app['session']->set('flash',$flash);
		return true;
    }
    // gets the flash
    public static function getFlash($app){
    	return $app['session']->get('flash');
    }
	// logs user out
	public function deauthenticate(){
		
		if($this->updateLastLogout()):
			return $this->unsetUserSession();
		else:
			return false;
		endif;
	}
	// kills session
	public function unsetUserSession() {
        unset($_SESSION['SAW_SITE_MODE']);
        session_unset();
        return true;
    }    
	
    public static function getUserAccessLevelBySession($app){
		$sess_user = $app['session']->get('user');
		return array('_id'=>$sess_user['user_id'],
					 'accessLevel'=>$sess_user['accessLevel']);
	}
    
	public function findByEmailVerifyToken(){
		$query = array('verifyEmailToken'=>new \MongoId($this->verifyEmailToken));
		$fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			$this->_id = $result['_id'];
			return true;
		else:
			return false;
		endif;
	}
	
	public function findByForgotPasswordToken(){
		$query = array('forgotPasswordToken'=>new \MongoId($this->forgotPasswordToken));
		$fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			$this->_id = $result['_id'];
			return true;
		else:
			return false;
		endif;
	}
	
	public function resetPassword(){
		return $this->saveSafe();
	}
	
	public function findByEmail(){
		$query = array('email'=>trim(strtolower($this->email)));
                $fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			$this->_id = $result['_id'];
			return true;
		else:
			return false;
		endif;
	}
	public function findAllByDisplayName(){
		$regex = new \MongoRegex('/'.$this->displayName.'/i'); 
		$query = array('displayName'=>$regex);
		$fields = array();
		$result = self::$app['mongo']->find($this->collection, $query, $fields, $slaveOkay=true);
		if(!empty($result)):
			return $result;
		else:
			return false;
		endif;
	}
	public function findAllByEmail(){
		$regex = new \MongoRegex('/'.trim(strtolower($this->email)).'/i'); 
		$query = array('email'=>$regex);
		
		$fields = array();
		$result = self::$app['mongo']->find($this->collection, $query, $fields, $slaveOkay=true);
		if(!empty($result)):
			return $result;
		else:
			return false;
		endif;
	}
	
	public function findByEmailPassword(){
        
		$query = array('email'=>trim(strtolower($this->email)));
		$fields = array('_id','password','status','accessLevel');
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
        if(!empty($result) && $result['status'] === USER_STATUS_ACTIVE):
            $this->_id = $result['_id'];
            $this->accessLevel = $result['accessLevel'];
            if($this->password === $result['password']) {
                $this->password = '';                
                return $result;
            }
            return false;
		else:
            return false;
		endif;
	}
	
    public static function sawPassword($password) {
        //return md5($password.SAW_SALT_KEYWORD);
        return md5($password);

    }
	
	public function updateAccessLevel(){
		//retrieve current accessLevel
		$query = array('_id'=>$this->_id);
		$fields = array('accessLevel'=>1);
		$doc = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		// this is to attempt to maintain an accessLevel
		// which already has the payment number
		if(!empty($doc) && is_float($doc['accessLevel'])){
			$this->accessLevel = $this->accessLevel + PAYMENT_NUMBER;
			$this->accessLevel = (float)$this->accessLevel;
		}else{
			$this->accessLevel = (int)$this->accessLevel;
		}
		
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$set'=>array('accessLevel'=>$this->accessLevel));
		
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
	}
	
	public function findBySocialNetworkId($socialNetworkName, $socialNetworkId){
		
		$query = array("connections.".$socialNetworkName.".accessToken.user_id"=>$socialNetworkId);
		
		$fields = array('_id'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=true);
		
		if(!empty($result)):
			$this->_id = $result['_id'];
			return true;
		else:
			return false;
		endif;
	}
	
	public function updateLastLogin(){
		
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$set'=>array('lastLogin'=>new \MongoDate()));
		
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
	}
	public function updateLastLogout(){
		
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$set'=>array('lastLogout'=>new \MongoDate()));
		
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
	}    
	
	public function updateAccessToken($connectName,$overwriteAll=false){
		
		$criteria = array('_id'=>$this->_id);
		if($overwriteAll):
			$update_spec = array('$set'=>array('connections'=>$this->connections));
            return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
		else:
            $user_doc = $this->findById();
            $connections = $user_doc['connections'];
            $connections[$connectName] = $this->connections[$connectName];
            $this->connections = array();
            foreach($connections as $key=>$connection) {
                if($key=='facebook' || $key == 'twitter') {
                    $this->connections[$key] = $connection; // This is only done because bad data in $connections would simetimes get into the system:
                    /*
                    [Wed Mar 13 16:16:49 2013] [error] [client 10.108.14.3]  User con...Array\n(\n
                    [] => Array\n        (\n            
                    [active] => \n        )\n\n    
                    [facebook] => Array\n        (\n            
                    [accessToken] => Array\n                (\n                    
                    [access_token] => AAACUSNzZABW4BAEdwfEUxCQZBRChTwwkewQPK8obAZCHSlHOZBiWfcLgBbpR1NWGN0Uv7dMlmgPxn3oE3r4oU2QmWVDy9sRCgdy0ZBR8\n                    
                    [user_id] => 100008755266\n                    
                    [added_on] => 1353484437\n                    
                    [profileImageUrl] => http://graph.facebook.com/100008875266/picture?type=large\n                    
                    [screen_name] => Some User\n                    
                    [expires] => \n                )\n\n            
                    [active] => \n        )\n\n   
                    [twitter] => Array\n        (\n            
                    [accessToken] => Array\n                (\n                    
                    [oauth_token] => 536695732-KtQUiQ9JiMYNN0GZa3KLN5VITgosICbHZ\n                    
                    [oauth_token_secret] => fDvkj4UixTqEzFDNMsFU6PAVfq9cedngJQMw\n                    
                    [screen_name] => SomeScreenName\n                    
                    [expires] => \n                )\n\n            
                    [active] => 1\n        )\n\n)\n
                    [Wed Mar 13 16:16:49 2013] [error] [client 10.108.14.3] Saw\\Component\\Connect\\TwitterConnect::setToken:: 233::Exception::getMessage::zero-length keys are not allowed, did you use $ with double quotes? 
                     */                    
                }
            }          
            //$this->connections = $connections;
            return $this->saveSafe();
			//$update_spec = array('$set'=>array('connections.'.$connectName.'.accessToken'=>$this->connections[$connectName]['accessToken']));
		endif;
		//$this->setNetworkActive($connectName,$active=true);				
	}

	public function setNetworkActive($connectName,$active=true){
		
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$set'=>array('connections.'.$connectName.'.active'=>$active));
		$result = self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
				
		return $result;
	}
	
	public function removeNetwork($connectName){
		$this->setNetworkActive($connectName,$active=false);
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$set'=>array('connections.'.$connectName.'.accessToken'=>false));
		$result = self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
				
		return $result;
	}    
    
	// for an atomic save of one specific preference
	// example $preference: 'feed.settings.range' $value: 10 (miles)
	public function setPreference($preference,$value){
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$set'=>array($preference=>$value));
		$result = self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
		return $result;
	}

	public function deleteLocationFromPreference($address){
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$unset'=>array('preference.feed.settings.locations.'.$address=>1));
		$result = self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false);
		return $result;
	}
    
	public function getPreference(){
		$query = array('_id'=>$this->_id);
		$fields = array('preference'=>1);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields, $slaveOkay=false);
		return (!empty($result)) ? $result : false;
	}
	
    public function createProfileImageFromUrl($url){
        $doc = array(); $options = array();
        $doc['type'] = $this->collection;
        $doc['size'] = 200;
        $options['thumbnails'] = array(120,90,50);          
        $app = self::$app;
        return $app['imageFromUrl']($app,$url,$doc,$options);
    }
	
	
}