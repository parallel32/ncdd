<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Saw\Model;
use dflydev\markdown\MarkdownParser;

// Logic for validating model fields
$app['validateModel'] = $app->protect(function ($app,$model=array(),$groups=array()) {
	$all_fields = array();
	if(is_array($model) && !empty($model) && count($model) > 0){// means you're validating several classes and groups
		foreach ($model as $modelo) {
			$res = $app['prepareViolations']($modelo['model'],$modelo['groups'],$namespace=true);
			$all_fields = array_merge($all_fields, $res);
		}
		$invalidfields_message = Saw\Model\Model::$invalidFieldsMessage;
	}else{
		$all_fields = $app['prepareViolations']($model,$groups);
		$invalidfields_message = $model::$invalidFieldsMessage;
	}
	if(is_array($all_fields) && !empty($all_fields) && count($all_fields) > 0){
		throw new Saw\Model\Exceptions\DomainException($invalidfields_message, $all_fields);
	}
});
// prepares the viloations array to be passed into the throw exception
$app['prepareViolations'] = $app->protect(function ($model,$groups,$namespace=false) use ($app) {
	$fields = array();
	$nsprefix = '';

    if(!empty($groups))
		$violations = $app['validator']->validate($model,$groups);
	else
		$violations = $app['validator']->validate($model);
	if($namespace){
		$reflectionClass = new \ReflectionClass($model);
		$nsprefix = strtolower($reflectionClass->getShortName()).'-';
	}
	
	if(is_object($violations) && count($violations)>0):
		foreach ($violations as $violation):
			$fields[] = array('name'=>$nsprefix.$violation->getPropertyPath(),
							  'message'=>$violation->getMessage(),
							  'invalid_value'=>$violation->getInvalidValue());
		endforeach;
	endif;
	return $fields;
});

$app['sendMail'] = $app->protect(function ($subject, $body, $to, $from=array(SAW_MAILER_FROM=>SAW_MAILER_FROM_NAME)) use ($app) {
	
	// save it to the email Q
	$doc['to'] = $to;
	$doc['from'] = SAW_MAILER_FROM;
	$doc['fromName'] = SAW_MAILER_FROM_NAME;
	$doc['replyTo'] = SAW_MAILER_FROM;
	$doc['subject'] = $subject;
	$doc['body'] = $body;
	$eq = new Saw\Model\EmailQ($doc,$app);
	$eq_id = $eq->insert();
	//error_log('eq id:::'.print_r($eq_id,true));
	
if(true):
	$sendgrid = new SendGrid(SAW_MAILER_USERNAME, SAW_MAILER_PASSWORD);
	$email = new SendGrid\Email();
	$email->addTo($to)->
	       setFrom(SAW_MAILER_FROM)->
	       setFromName(SAW_MAILER_FROM_NAME)->
	       setReplyTo(SAW_MAILER_FROM)->
	       setSubject($subject)->
	       setHtml($body);
	
	$sendgrid->send($email);
endif;
	/*// replaced by SendGrid
	$message = \Swift_Message::newInstance()
		        ->setSubject($subject)
		        ->setFrom($from)
		        ->setTo($to)
		        ->setBody($body,'text/html');
	$app['mailer']->send($message);
	//*/

	// clean up mail Q
	$eq = new Saw\Model\EmailQ(array('_id'=>$eq_id),$app);
	$eq->delete();

	// save it to the email Sent Items
	$doc['to'] = $to;
	$doc['from'] = SAW_MAILER_FROM;
	$doc['fromName'] = SAW_MAILER_FROM_NAME;
	$doc['replyTo'] = SAW_MAILER_FROM;
	$doc['subject'] = $subject;
	$doc['body'] = $body;
	$es = new Saw\Model\EmailSent($doc,$app);
	$es_id = $es->insert();
	
});

////////////////////////////////////////////
// PREPARE CONTENT BY REMOVING ALL IMAGES //
////////////////////////////////////////////
$app['prepare_content_remove_media'] = $app->protect(function ($content) use ($app) {
	return preg_replace("/<img[^>]+\>/i", "", $content);
});
//////////////////////////////////////////////////////////////////
// PREPARE CONTENT BY REPLACING IMAGE PLACEHOLDERS WITH EMBEDLY //
//////////////////////////////////////////////////////////////////
$app['prepare_content'] = $app->protect(function ($content) use ($app) {
	return preg_replace_callback("/<img[^>]+\>/i", function($matches){

    	$doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML( $matches[0] );
		$xpath = new \DOMXPath($doc);
		$imgs = $xpath->query("//img");
		for ($i=0; $i < $imgs->length; $i++) {
		    $img = $imgs->item($i);
		    $id = $img->getAttribute("id");
		    if($id == 'imageplaceholder'){
		    	$url = $img->getAttribute('data-media-url');
		    	$url_type = $img->getAttribute('data-media-type');
		    	$style = $img->getAttribute('style');
		    	return <<< EOD
<p class="embedly" style="$style"><a class="embedly-card" data-card-image="0" href="$url">Loading Link..</a>
<script>
  var document = window.document;
  (function(a){
    var b="embedly-platform",c="script";
    /*if(!a.getElementById(b)){*/
      var d=a.createElement(c);
      d.id=b;
      d.async=true;
      d.src=("https:"===document.location.protocol?"https":"http")+"://cdn.embedly.com/widgets/platform.js";
      var e=a.getElementsByTagName(c)[0];
      e.parentNode.insertBefore(d,e)
    /*}*/
  })(document);
</script>
</p>
EOD;
		    }else{
		    	return $matches[0];
		    }
		    
		}

    }, $content); 
});
////////////////////////////////////////////////
// PREPARE ACCESS TOKEN AND DRIVE CREDENTIALS //
////////////////////////////////////////////////
$app['prepare_vfl'] = $app->protect(function (&$view_vars) use ($app) {

    try {
            
    $client = new Google_Client();
    $client->setApplicationName(GOOGLE_DRIVE_APPLICATION_NAME);
    
    $key = file_get_contents(GOOGLE_DRIVE_KEY_FILE_LOCATION);

    $cred = new Google_Auth_AssertionCredentials(
        GOOGLE_DRIVE_SERVICE_ACCOUNT_NAME,
        array(GOOGLE_DRIVE_API_SCOPE),
        $key
    );
    $cred->sub = GOOGLE_DRIVE_PRN;
    $cred->prn = GOOGLE_DRIVE_PRN;
    $client->setAssertionCredentials($cred);

    $session_service_token = $app['session']->get('service_token');
    if (isset($session_service_token)) {
        $client->setAccessToken($session_service_token);
        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
            $app['session']->set('service_token',$client->getAccessToken());
        }
    }else{
        $session_service_token = $client->getAccessToken();
        if(empty($session_service_token)){
            $client->getAuth()->refreshTokenWithAssertion($cred);
            $session_service_token = $client->getAccessToken();
            $app['session']->set('service_token',$session_service_token);
        }
        $app['session']->set('service_token',$session_service_token);
    }
    
    $access_token = json_decode($session_service_token);
    $access_token = $access_token->access_token;

    $picker_view_vars = array(
                         'access_token'=>$access_token
                        ,'client_id'=>GOOGLE_DRIVE_CLIENT_ID
                        );
    $view_vars = array_merge($view_vars,$picker_view_vars);
    } catch (Exception $e) {
      // do nothing so the page can keep loading the fall back is to not allow the 
      // vfl button on the editor to appear  
    	error_log('excption in prepare_vfl:'.$e->getMessage());
    }
});

///////////////////////
// CAPTCHA GENERATOR // 
///////////////////////
$app['hex2rgb'] = $app->protect(function ($hex_str, $return_string = false, $separator = ',') use ($app) {
	$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
	$rgb_array = array();
	if( strlen($hex_str) == 6 ) {
		$color_val = hexdec($hex_str);
		$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
		$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
		$rgb_array['b'] = 0xFF & $color_val;
	} elseif( strlen($hex_str) == 3 ) {
		$rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
		$rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
		$rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
	} else {
		return false;
	}
	return $return_string ? implode($separator, $rgb_array) : $rgb_array;
});

$app->get('/captcha', function (Request $request) use ($app) {
    
	$captcha_config = $app['session']->get('captcha');
	$captcha_config = $captcha_config['config'];
	
	// Use milliseconds instead of seconds
	srand(microtime() * 100);
	
	// Pick random background, get info, and start captcha
	$background = $captcha_config['png_backgrounds'][rand(0, count($captcha_config['png_backgrounds']) -1)];
	list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
	
	// Create captcha object
	$captcha = imagecreatefrompng($background);
    imagealphablending($captcha, true);
    imagesavealpha($captcha , true);
	
	$color = $app['hex2rgb']($captcha_config['color']);
	$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);
        
	// Determine text angle
	$angle = rand( $captcha_config['angle_min'], $captcha_config['angle_max'] ) * (rand(0, 1) == 1 ? -1 : 1);
	
	// Select font randomly
	$font = $captcha_config['fonts'][rand(0, count($captcha_config['fonts']) - 1)];
	
	// Verify font file exists
	if( !file_exists($font) ) throw new Exception('Font file not found: ' . $font);
	
	//Set the font size.
	$font_size = rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
	$text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);
	
	// Determine text position
	$box_width = abs($text_box_size[6] - $text_box_size[2]);
	$box_height = abs($text_box_size[5] - $text_box_size[1]);
	$text_pos_x_min = 0;
	$text_pos_x_max = ($bg_width) - ($box_width);
	$text_pos_x = rand($text_pos_x_min, $text_pos_x_max);			
	$text_pos_y_min = $box_height;
	$text_pos_y_max = ($bg_height) - ($box_height / 2);
	$text_pos_y = rand($text_pos_y_min, $text_pos_y_max);
	
	// Draw shadow
	if( $captcha_config['shadow'] ){
		$shadow_color = $app['hex2rgb']($captcha_config['shadow_color']);
	 	$shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
		imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);	
	}
	
	// Draw text
	imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);	
	
	return new Response(imagepng($captcha), 200, array('Content-Type' => 'image/png'));
});

$app->post('/content-formatter', function (Request $request) use ($app) {
	$content = $request->get('content');
	error_log('content:'.$content);
	include_once __DIR__.'/../Saw/Provider/WordPress/ncdd-wp-includes.php';
	$content = (!empty($content)) ? wptexturize(wpautop($content)) : '';
	return new Response($content, 200,array('Content-Type' => 'text/html'));
});


////////////////////
// RENEWAL CHECKS //
// card exp date, 
// card decline nag-ware, 
// if an active renewal is present and is unpaid and it's past Jan 31st-disable all features.
////////////////////
$app['renewal_payment_failure'] = $app->protect(function () use ($app) {
	$user = Model\User::getUserAccessLevelBySession($app);
	if($user['accessLevel'] != ADMIN){
		$member = new Model\Member(array('_id'=>$user['_id']),$app);
		$member = $member->findById();
		if(is_array($member['renewal']) && array_key_exists('paidDate',$member['renewal']) && empty($member['renewal']['paidDate']) && strtotime('now') > strtotime('January 31, '.(date('Y')+1))){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
});
$app['renewal_card_decline'] = $app->protect(function () use ($app) {
	$user = Model\User::getUserAccessLevelBySession($app);
	if($user['accessLevel'] != ADMIN){
		$member = new Model\Member(array('_id'=>$user['_id']),$app);
		$member = $member->findById();
		if(is_array($member) && array_key_exists('payment',$member) && array_key_exists('number',$member['payment']) && !empty($member['payment']['number']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
});
$app['renewal_card_expiration_date'] = $app->protect(function () use ($app) {
	$user = Model\User::getUserAccessLevelBySession($app);
	if($user['accessLevel'] != ADMIN){
		$member = new Model\Member(array('_id'=>$user['_id']),$app);
		$member = $member->findById();
		if(is_array($member) && array_key_exists('payment',$member) && array_key_exists('number',$member['payment']) && !empty($member['payment']['number']) && array_key_exists('expMonth',$member['payment']) && $member['payment']['expMonth'] && strtotime('now') > strtotime($member['payment']['expMonth'].'/01/'.$member['payment']['expYear'])){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
});

return $app;