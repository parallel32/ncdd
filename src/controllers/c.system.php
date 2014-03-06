<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Saw\Model;
use dflydev\markdown\MarkdownParser;

// Logic for validating model fields
$app['validateModel'] = $app->protect(function ($app,$model,$groups=array()) {
	if(!empty($groups))
		$violations = $app['validator']->validate($model,$groups);
	else
		$violations = $app['validator']->validate($model);
	if(is_object($violations) && count($violations)>0):
		foreach ($violations as $violation):
			$fields[] = array('name'=>$violation->getPropertyPath(),
							  'message'=>$violation->getMessage(),
							  'invalid_value'=>$violation->getInvalidValue());
		endforeach;
		throw new Saw\Model\Exceptions\DomainException($model::$invalidFieldsMessage, $fields);
	endif;	
});
$app['sendMail'] = $app->protect(function ($subject, $body, $to, $from=array(SAW_MAILER_FROM=>SAW_MAILER_FROM_NAME)) use ($app) {
	
	$sendgrid = new SendGrid(SAW_MAILER_USERNAME, SAW_MAILER_PASSWORD);
	$email = new SendGrid\Email();
	$email->addTo($to)->
	       setFrom(SAW_MAILER_FROM)->
	       setFromName(SAW_MAILER_FROM_NAME)->
	       setReplyTo(SAW_MAILER_FROM)->
	       setSubject($subject)->
	       setHtml($body);

	$sendgrid->send($email);

	/*// replaced by SendGrid
	$message = \Swift_Message::newInstance()
		        ->setSubject($subject)
		        ->setFrom($from)
		        ->setTo($to)
		        ->setBody($body,'text/html');
	$app['mailer']->send($message);
	//*/
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

return $app;