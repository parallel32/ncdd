<?php
namespace Saw\Component\Connect;

class FacebookConnect extends Connect {
	
	/**
	 * permissions ref: http://developers.facebook.com/docs/authentication/permissions/
	 * php SDK ref: http://developers.facebook.com/docs/reference/php/facebook-getUser/
	 * graph api ref: http://developers.facebook.com/docs/reference/api/
	 */
	public $permissions = 'publish_stream,read_friendlists';
	public $redirectUri = SAW_FACEBOOK_REDIRECT_URL;
	public $user;
	
	public function __construct(\Silex\Application $app, $accessToken=array()){
		$this->accessToken = $accessToken;
		parent::__construct($app);
	}
	
	public function requestToken(){
		
		try{
			
			$user = $this->app['facebook']->getUser();
			
			return $this->$user = $user;
			
		}catch(\Exception $e){
			
			$this->app->abort(400, json_encode(array('error'=>$e->getMessage())));
			
		}
		
	}
	
	public function accessToken($oauth_token){
		
		try {
			$access_token['access_token'] = $this->app['facebook']->getAccessToken();
			$access_token['user_id'] = $this->app['facebook']->getUser();
			// store the access_token
			$this->app['session']->set('Connect.facebook.accessToken', $access_token);
		} catch (FacebookApiException $e) {
			error_log(__ClASS__.'::error getting accessToken:'.$e->getMessage());
		    return 500;
		}

		return 200;
		
	}
	// returns true | false
	// @TODO need to wrap facebook calls with try catch blocks
	public function validate(){
		
		// retrieve the access_token from storage
		$this->accessToken = $this->app['session']->get('Connect.facebook.accessToken');
		// get user from social network
		$soc_user = $this->getUser();
					
		$doc = array('connections'=>array('facebook'=>array('accessToken'=>$this->accessToken)));
		// make sure user_id is stored
		$doc['connections']['facebook']['accessToken']['user_id'] = $soc_user['id'];
		$doc['connections']['facebook']['accessToken']['added_on'] = time();
		$doc['connections']['facebook']['accessToken']['profileImageUrl'] = $soc_user['profileImageUrl'];
		$doc['connections']['facebook']['accessToken']['screen_name'] = $soc_user['name'];
		$doc['connections']['facebook']['accessToken']['expires'] = '';
		$doc['connections']['facebook']['active'] = true;
		
		$user_doc = \Saw\Model\Consumer::getUserBySession($this->app);
        
		if(!empty($user_doc)): // if user already exists exists
			// bind to user's document
			$doc['_id'] = $user_doc['_id'];
			$user = new \Saw\Model\Consumer($doc, $this->app);
			if(!empty($user_doc['connections'])){
				$user->updateAccessToken('facebook');
			}else{
				$user->updateAccessToken('facebook',$overwrite=true);
			}
		else: // else create new user
			/***** since we don't create users from facebook connect anymore; this section has been deprecated.
			// bind to user's document
			$soc_user['connections'] = $doc['connections'];
			$user = new \Saw\Model\Consumer($soc_user, $this->app);
			// find the user
			$result = $user->findBySocialNetworkId('facebook', $soc_user['id']);
			if($result):
				// if exists update access token with new one
				$user->updateAccessToken('facebook');
			else:
				// create new user
				$insert_id = $user->insert();
			endif;
			//*/
		endif;
		
        $returnVal = $user->authenticate();
        
		return $returnVal;
	}
	
	public function getUser($access_token=array()){
		
		$access_token = ($access_token)?:$this->accessToken;
		
		// set token in case you want a different user
		$this->app['facebook']->setAccessToken($access_token['access_token']);
		
		// retrieve Facebook user details
     
		$user_details = $this->app['facebook']->api('/me');

		return $this->getUserResponse($user_details)->__toArray();
		
	}
	
	public function getUserResponse($response){
		
		// init variables
		$formatted_response = array();
		$response = (array) $response;
		
        if(!empty($response['id'])) {
            $formatted_response['id']	 				= $response['id'];
            $formatted_response['name'] 				= $response['name'];
            $formatted_response['firstName']			= $response['first_name'];
            $formatted_response['lastName'] 			= $response['last_name'];
            $formatted_response['profileImageUrl'] 		= 'http://graph.facebook.com/'.$response['id'].'/picture?type=large';
            $formatted_response['gender'] 				= $response['gender'];
            $formatted_response['locale'] 				= $response['locale'];
            $formatted_response['profileImageUrlHttps'] = 'https://graph.facebook.com/'.$response['id'].'/picture?type=large';
            if(!empty($response['location']))
                $formatted_response['location']			= array('name'=>$response['location']['name'],'lat'=>'','lon'=>'');
            else
                $formatted_response['location']			= array('name'=>'','lat'=>'','lon'=>'');
        }
		
		try {
			$responsObj = new GetUserResponse($formatted_response);
			$responsObj->validate();
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			error_log('FacebookConnect::getUserResponse::ResponseDomainException::'.print_r(array('message'=>$e->getMessage(),'arr'=>$e->getErrorArr()),true));
			$this->app->abort(400, json_encode(array('error'=>array('message'=>$e->getMessage(),'arr'=>$e->getErrorArr()))));
		} catch (\Exception $e){
			error_log('FacebookConnect::getUserResponse::Exception::'.print_r(array('message'=>$e->getMessage(),'arr'=>$e->getErrorArr()),true));
			$this->app->abort(400, json_encode(array('error'=>$e->getMessage())));
		}
		
		return $responsObj;
		
	}
	
	/**
	 * @message         the grape message
	 * @link 			the full http link to the offer
	 * @picture 		full http path to the picture
	 * @return 			returns the id of the post
	 */
	public function grape($message, $link, $picture='', $options=array()){
		
		try {
			// set token in case you want a different user
			$this->app['facebook']->setAccessToken($this->accessToken['access_token']);
			$post_arr = array(	'message'=>'ò '.$message,
					'link'=>$link,
					'picture'=>$picture,
					'description'=>$options['description'],
					'caption'=>$options['caption'],
					'name'=>$options['name']
					);
			// publish to facebook
			$result = $this->app['facebook']->api('/'.$this->accessToken['user_id'].'/feed',
										'POST', 
										$post_arr
										);
			/*
				valid $result looks like this:
				Array
				(
				    [id] => 100002503423556_256381411121971    //id of the post
				) 
			*/
			return $result;
			
		} catch (\FacebookApiException $e) {
			$result_arr = $e->getResult();
			if(!empty($result_arr['error'])):
				switch ((int)$result_arr['error']['code']) {
					case 100: // invalid post not handled properly on our part
						$http_status_code = 409; //ref: 10.4.10 409 Conflict 
						$response_message = "Facebook says:".$result_arr['error']['message'];
						$resolve_link = "";
						$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
						break;
					case 506: // duplicate post
						$http_status_code = 403; //ref: 10.4.4 403 Forbidden
						$response_message = "Facebook tells us we have already made this post for you. Please try again using the link below.";
						$resolve_link = "";
						$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
						break;
					case 341: // Feed action request limit reached
						$http_status_code = 401; //ref: 10.4.2 401 Unauthorized
						$response_message = "Facebook tells us you've reached your automatic posting limit. Try posting with Twitter or manually with the link below instead.";
						$resolve_link = "/connect/facebook";
						$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
						break;                    
					case 200:
					case 190: // access token problem; need to read message for clarity. possible causes: user changed password, revoked access, token expired
						$http_status_code = 401; //ref: 10.4.2 401 Unauthorized
						$response_message = "Facebook tells us you must re-authenticate. Please re-connect to Facebook from the Account Settings screen.";
						$resolve_link = "/connect/facebook";
						$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
						break;
					default:
						$http_status_code = 401; //ref: 10.4.2 401 Unauthorized
						$response_message = "Facebook tells us you must re-authenticate. Please re-connect to Facebook from the Account Settings screen.";
						$resolve_link = "/connect/facebook";
						$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
						break;
				}
				
			endif;
			
			error_log(__METHOD__.':: '.__LINE__.'::FacebookApiException::getResult::'.print_r($e->getResult(),true));
			return $result;
		} catch (\Exception $e) {
			error_log(__METHOD__.'::error on line '.__LINE__.':'.print_r($e->getMessage(), true));
			return false;
		}
		
	}
	
	// for the app to manually set an access token
	public static function setToken($app, $user_id, $fb_user_id, $access_token, $expires, $active, $screen_name = ''){
		try{
            $doc['connections'] = array('facebook'=>array('accessToken'=>array(), 'active'=>''));
			$doc['connections']['facebook']['accessToken']['access_token'] = $access_token;
			$doc['connections']['facebook']['accessToken']['user_id'] = $fb_user_id;
			$doc['connections']['facebook']['accessToken']['expires'] = $expires;
            $doc['connections']['facebook']['accessToken']['screen_name'] = $screen_name;
			$doc['connections']['facebook']['active'] = $active;
			$doc['_id'] = $user_id;
			$user = new \Saw\Model\Consumer($doc, $app);
			$user->updateAccessToken('facebook');
			//$user->setNetworkActive('facebook',$active);
			return true;
		} catch (\Exception $e) {
			error_log(__METHOD__.':: '.__LINE__.'::Exception::getMessage::'.print_r($e->getMessage(),true));
			return false;
		}
	}
}

/*  ------------- KNOWN FACEBOOK API RESPONSE ERRORS --------------------
facebook
---------
:getResult::Array
(
    [error] => Array
        (
            [message] => (#100) link URL is not properly formatted
            [type] => OAuthException
            [code] => 100
        )

)
(
    [error] => Array
        (
            [message] => (#100) Missing message or attachment
            [type] => OAuthException
            [code] => 100
        )

)
(
    [error] => Array
        (
            [message] => (#506) Duplicate status message
            [type] => OAuthException
            [code] => 506
        )

)
(
    [error] => Array
        (
            [message] => Error validating access token: The session has been invalidated because the user has changed the password.
            [type] => OAuthException
            [code] => 190
        )

)
(
    [error] => Array
        (
            [message] => Error validating access token: User 100002503423556 has not authorized application 132463736827100.
            [type] => OAuthException
            [code] => 190
        )

)
(
    [error] => Array
        (
            [message] => (#200) The user hasn't authorized the application to perform this action
            [type] => OAuthException
            [code] => 200
        )

)
 
// also [code] => 341: post limit reached (per user/per day)

*/