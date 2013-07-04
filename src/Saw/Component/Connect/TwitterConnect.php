<?php
namespace Saw\Component\Connect;

class TwitterConnect extends Connect {
	
	private $consumerKey 			= SAW_TWITTER_CONSUMER_KEY;
	private $consumerSecret 		= SAW_TWITTER_CONSUMER_SECRET;
	public $requestTokenEndPoint 	= 'https://api.twitter.com/oauth/request_token';
	public $authorizeEndPoint		= 'https://api.twitter.com/oauth/authenticate';
	public $accessTokenEndPoint		= 'https://api.twitter.com/oauth/access_token';
	
	public function __construct(\Silex\Application $app, $accessToken=array()){
		$this->oauth = new \OAuth($this->consumerKey, $this->consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
		$this->accessToken = $accessToken;
		parent::__construct($app);
	}
	
	public function requestToken(){
		
		try{
			
			// using consumer_key and consumer_secret: get a request_token
			$request_token = $this->oauth->getRequestToken($this->requestTokenEndPoint);
			
			// got request_token, now save the secret for later
			$this->app['session']->set('Connect.twitter.requestToken.oauth_token_secret', $request_token['oauth_token_secret']);
			$this->app['session']->set('Connect.twitter.requestToken.oauth_token', $request_token['oauth_token']);
			
			return $request_token['oauth_token'];
			
		}catch(\Exception $e){
			throw new \Saw\Exceptions\SawException(new \Exception($e->getMessage()), "Most likely the server time is behind regular time");
		}
		
	}
	
	public function accessToken($oauth_token){
		
		//oauth_token we sent in the authorize url comes back now (which prevents a CSRF from happening)
		$saved_oauth_token = $this->app['session']->get('Connect.twitter.requestToken.oauth_token');
		if ($oauth_token != $saved_oauth_token) {
		    return 401;
		}

		// we pull our secret from storage
		$oauth_token_secret = $this->app['session']->get('Connect.twitter.requestToken.oauth_token_secret');

		// we set our request_token to prepare to exchange for the access_token
		$this->oauth->setToken($oauth_token, $oauth_token_secret);

		try {
			// exchnage request_token for an access_token
		    $access_token = $this->oauth->getAccessToken($this->accessTokenEndPoint);
			// store the access_token
			$this->app['session']->set('Connect.twitter.accessToken', $access_token);
		} catch (OAuthException $e) {
			error_log(__ClASS__.'::error getting accessToken:'.$e->getMessage());
		    return 500;
		}

		return 200;
		
	}
	// returns true | false
	public function validate(){
		
		// retrieve the access_token from storage
		$this->accessToken = $this->app['session']->get('Connect.twitter.accessToken');
		// get user from social network
		$soc_user = $this->getUser();
		
		$doc = array('connections'=>array('twitter'=>array('accessToken'=>$this->accessToken)));
		// make sure user_id is stored
		$doc['connections']['twitter']['accessToken']['user_id'] = $soc_user['id'];
		$doc['connections']['twitter']['accessToken']['profileImageUrl'] = $soc_user['profileImageUrl'];
		$doc['connections']['twitter']['accessToken']['expires'] = '';
		$doc['connections']['twitter']['active'] = true;
		
		// find if a user session already exists
		$user_doc = \Saw\Model\Consumer::getUserBySession($this->app);
		if(!empty($user_doc)):
			// bind to user's document
			$doc['_id'] = $user_doc['_id'];
			$user = new \Saw\Model\Consumer($doc, $this->app);
			if(!empty($user_doc['connections'])){
				$user->updateAccessToken('twitter');
			}else{
				$user->updateAccessToken('twitter',$overwrite=true);
			}
		else:
			/***** since we don't create users from facebook connect anymore; this section has been deprecated.
			// bind to user's document
			$soc_user['connections'] = $doc['connections'];
			$user = new \Saw\Model\Consumer($soc_user, $this->app);
			// find the user
			$result = $user->findBySocialNetworkId('twitter', $soc_user['id']);

			if($result):
				// if exists update access token with new one
				$user->updateAccessToken('twitter');
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
		
		// retrieve Twitter user details
		$this->oauth->setToken($access_token['oauth_token'], $access_token['oauth_token_secret']);
		$this->oauth->fetch('https://api.twitter.com/1/account/verify_credentials.json');
		$user_details = json_decode($this->oauth->getLastResponse());

		return $this->getUserResponse($user_details)->__toArray();
		
	}
	
	public function getUserResponse($response){
		
		// init variables
		$formatted_response = array();
		$response = (array) $response;
		
		$formatted_response['id']	 							= $response['id'];
		$formatted_response['name'] 							= $response['name'];
		$formatted_response['profileImageUrl'] 					= str_replace('normal.png','bigger.png',$response['profile_image_url']);
		$formatted_response['about'] 							= $response['description'];
		/* 10/22/2012 MH - this has been depricated at the moment so as to not confuse with the notion of the new Profile model.
		We don't use these fields anyway
		
		$formatted_response['profileImageUrlHttps'] 			= str_replace('normal.png','bigger.png',$response['profile_image_url_https']);
		$formatted_response['profileSidebarBorderColor'] 		= $response['profile_sidebar_border_color'];
		$formatted_response['profileSidebarFillColor']		 	= $response['profile_sidebar_fill_color'];
		$formatted_response['profileBackgroundImageUrl'] 		= $response['profile_background_image_url'];
		$formatted_response['profileBackgroundImageUrlHttps'] 	= $response['profile_background_image_url_https'];
		$formatted_response['profileBackgroundTile'] 			= $response['profile_background_tile'];
		$formatted_response['profileBackgroundColor']		 	= $response['profile_background_color'];
		$formatted_response['profileUseBackgroundImage'] 		= $response['profile_use_background_image'];
		$formatted_response['profileTextColor'] 				= $response['profile_text_color'];
		$formatted_response['profileLinkColor'] 				= $response['profile_link_color'];
		//*/
		if(!empty($response['lat']) && !empty($response['lon']))
			$formatted_response['location']						= array('name'=>$response['location'],'lat'=>$response['lat'],'lon'=>$response['lon']);
		else
			$formatted_response['location']						= array('name'=>'','lat'=>'','lon'=>'');
		
		try {
			$responsObj = new GetUserResponse($formatted_response);
			$responsObj->validate();
		} catch (\Saw\Component\Communication\Exceptions\ResponseDomainException $e){
			error_log('TwitterConnect::getUserResponse::ResponseDomainException::'.print_r(array('message'=>$e->getMessage(),'arr'=>$e->getErrorArr()),true));
			$this->app->abort(400, json_encode(array('error'=>array('message'=>$e->getMessage(),'arr'=>$e->getErrorArr()))));
		} catch (\Exception $e){
			error_log('TwitterConnect::getUserResponse::Exception::'.print_r(array('message'=>$e->getMessage(),'arr'=>$e->getErrorArr()),true));
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
		$tweet = 'ò '.$message.' '.$link;
		try {
			// prepare to tweet
			$this->oauth->setToken($this->accessToken['oauth_token'], $this->accessToken['oauth_token_secret']);
			$this->oauth->fetch('http://api.twitter.com/1/statuses/update.json', 
						   array('status'=>$tweet,'trim_user'=>true,'include_entities'=>true),'POST');
			$response = json_decode($this->oauth->getLastResponse());
			$result = array('id'=>$response->id_str);
			return $result;
		} catch (\OAuthException $e) {
			
			switch ((int)$e->getCode()) {
				case 403: // possible problem: went over character limit for tweet
					$http_status_code = 403; //ref: 10.4.4 403 Forbidden
					$response_message = "Twitter tells us we can't post this for you and they're not being clear as to why. Please try again with Facebook or manually with the link below.";
					$resolve_link = "";
					$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
					break;
				case 401: // access token no longer valid so re-auth
					$http_status_code = 401; //ref: 10.4.2 401 Unauthorized
					$response_message = "Twitter tells us you must re-authenticate. Please re-connect to Twitter from the Account Settings screen.";
					$resolve_link = "/connect/twitter";
					$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
				default:
					$http_status_code = 401; //ref: 10.4.2 401 Unauthorized
					$response_message = "Twitter tells us you must re-authenticate. Please re-connect to Twitter from the Account Settings screen.";
					$resolve_link = "/connect/twitter";
					$result = array('message'=>$response_message, 'http_status_code'=>$http_status_code, 'resolve_link'=>$resolve_link);
					break;
			}
			
			error_log(__METHOD__.':: '.__LINE__.'::OAuthException::getMessage::'.print_r($e->getMessage(),true).'::getCode::'.print_r($e->getCode(),true));
			return $result;
		} catch (\Exception $e) {
			error_log(__METHOD__.':: '.__LINE__.'::Exception::getMessage::'.print_r($e->getMessage(),true));
			return false;
		}
		
	}
	
	// for the app to manually set an access token
	public static function setToken($app, $user_id, $screen_name, $token, $secret, $expires ,$active){
		try{
            $doc['connections'] = array('twitter'=>array('accessToken'=>array(), 'active'=>''));
			$doc['connections']['twitter']['accessToken']['oauth_token'] = $token;
			$doc['connections']['twitter']['accessToken']['oauth_token_secret'] = $secret;
			$doc['connections']['twitter']['accessToken']['screen_name'] = $screen_name;
			$doc['connections']['twitter']['accessToken']['expires'] = $expires;
			$doc['connections']['twitter']['active'] = $active;
			$doc['_id'] = $user_id;
			$user = new \Saw\Model\Consumer($doc, $app);
			$user->updateAccessToken('twitter');
			//$user->setNetworkActive('twitter',$active);
			return true;
		} catch (\Exception $e) {
			error_log(__METHOD__.':: '.__LINE__.'::Exception::getMessage::'.print_r($e->getMessage(),true));
			return false;
		}
	}
}