<?php
namespace Grapeword\Model;

/*
general usage for user uploaded images:
	$offerImg = new OfferImage($imageId);
	$offer_doc['image'] = $offerImg->__toArray();

general usage for QR code images:
	$image = new ImageQRSetup($this->_id,$cdn=false);
	$this->QR = $image->generateQRNoImage($this->shortCode);
AND
	$image = new ImageQRProfile($this->_id);
	$this->QR = $image->generateQR($this->shortCode);
*/

/**
 * Image model. Not a data object. Designed to prepare a 
 * consistent base image object to be extended for specific
 * image sizes and image contexts.
 */
class Image {

	public $imageId;
	public $context;
    public $base;
    public $baseSSL;
    public $modified;
	public $sizes;
	public $urls;
	public $urlTemplate;
	public $urlCDN;
	public $urlSSLCDN;
	public $urlRelative;
	public $cdn;
	// cross reference to document where this object will nest
	// this is needed because in mongo or S3 we may need it to 
	// restore the image or fix orphans
	public $belongsTo; 
	// via composition store a reference to the object to which this 
	// image will be nested so that it can be saved more efficiently
	public $parentObject;
	
	/**
	 * if $cdn gets passed in as false then generateQRNoImage() must be called 
	 * because not using a cdn and calling generateQR() makes no sense since
	 * generateQR()'s purpose is to send the images it creates up to S3
	 */
	public function __construct($imageId,$cdn=true){
		if(empty($imageId)){
			$this->imageId = '';
		}else{
			$this->imageId = (is_object($imageId)) ? $imageId : new \MongoId($imageId);
		}
		$this->context = '';
        $this->base = '';
        $this->baseSSL = '';
        $this->modified = '';
		$this->sizes = array('small'=>150,'medium'=>300,'large'=>500);
		$this->urls = array();
		$this->urlTemplate = 'images/{context}/{size}/{imageId}';
		$this->setCDN($cdn);
		$this->urlRelative = $this->urlTemplate;
	}
    //TODO get rid of these
	public function setCdn($cdn=true){
		if($cdn){
			$cdn = GW_CDN;
			$ssl_cdn = GW_SSL_CDN;
			$this->cdn = true;
		}else{
			$cdn = GW_BASE_URL;
			$ssl_cdn = GW_BASE_URL;
			$this->cdn = false;
		}
		$this->urlCDN = $cdn.'/'.$this->urlTemplate;
		$this->urlSSLCDN = $ssl_cdn.'/'.$this->urlTemplate;
	}
	public function makeUrls(){
		$tmp = array();
        foreach($this->sizes as $name => $size):
			$find = array('{context}','{size}','{imageId}');
			$replace = array($this->context, $size, $this->imageId->__toString());
			$tmp[$name]['CDN'] = str_replace($find, $replace, $this->urlCDN);
			$tmp[$name]['SSLCDN'] = str_replace($find, $replace, $this->urlSSLCDN);
			$tmp[$name]['RELATIVE'] = str_replace($find, $replace, $this->urlRelative);
		endforeach;
		$this->urls = $tmp;
	}
	public function __toArray(){
		$doc = get_object_vars($this);
		unset($doc['urlTemplate']);
		unset($doc['urlCDN']);
		unset($doc['urlSSLCDN']);
		unset($doc['urlRelative']);
        unset($doc['urls']);
		unset($doc['cdn']);
        unset($doc['sizes']);
		return $doc;
	}
	
	/**
	 * @ecc (one form: L,M,Q,H)
	 * @size qr code size: 6 = 6x6 dimensions
	 * @squareBoundaries code will have 1 code square white boundary around
	 * @image this is an image object
	 */
	public function generateQR($shortCode, $accentColor=array()){		
		if(!$this->cdn){
			throw new \Grapeword\Exceptions\GrapewordException(new \LogicException(),"Trying to create QR Images without first specifying that you want to use a CDN.  You must pass cdn true to the Image constructor in order to use this method.");
		}
		$qrBase = 'http://'.GW_QR_HOST.'/';
		$code = $qrBase.$shortCode;

		$ecc='M';
		$qsize=16;
		$squareBoundaries=0;
		
		include __DIR__.'/../../phpqrcode/qrlib.php';
		// seed and save QR Code to /tmp
		$uri = '/tmp/'.$this->imageId.'.png';            
		if(!empty($shortCode)) {
			\QRcode::png($code, $uri, $ecc, $qsize, $squareBoundaries);

			$imagefrompng = imagecreatefrompng($uri);
			$original_width = imagesx($imagefrompng);
			$original_height = imagesy($imagefrompng);                 
            if(empty($accentColor)) {
                $accentColor = array('R'=>151, 'G'=>104, 'B'=>121); //purple
            }
            $accent = imagecolorallocate($imagefrompng, $accentColor['R'], $accentColor['G'], $accentColor['B']); 
            imagefilledrectangle($imagefrompng, $qsize*2, $qsize*2, $qsize*5, $qsize*5, $accent);                

			// s3 start //
			$s3 = new \AmazonS3();
			$s3->path_style = true;
			$bucket = str_replace('http://','',GW_CDN);
			// s3 end //

			foreach($this->sizes as $key=>$thumbSize) {
				// size and store thumb
				$final_image = imagecreatetruecolor($thumbSize, $thumbSize);
				imagecopyresampled($final_image, $imagefrompng, 0, 0, 0, 0, $thumbSize, $thumbSize, $original_width, $original_height);  
				ob_start();
				imagejpeg($final_image, NULL, 100);
				$base = ob_get_contents();
				ob_end_clean();
                
                $filename = 'images/'.$this->context.'/'.$key.'/'.$this->imageId->__toString(); // TODO: Verify $this->urls[$key]['RELATIVE']
                //echo $filename; exit;
				$response = $s3->create_object($bucket, $filename, array(
                    'body' => $base,
                    'contentType' => 'image/jpeg',
                    'acl' => \AmazonS3::ACL_PUBLIC
				));
				if(!$response->isOK()):
					throw new \Grapeword\Exceptions\GrapewordException(new \Exception(),"The following error occurred on S3: ".print_r($response,true));
				endif;

			}

			return array('code'=>$code,'image'=>$this->__toArray());
		}
		return false;
	}    
    public function generateQRNoImage($shortCode){
		if($this->cdn){
			throw new \Grapeword\Exceptions\GrapewordException(new \LogicException(),"Trying to use QR Image by on the fly rendering but using a CDN. You must pass cdn false in order to use this method.");
		}
		$qrBase = 'http://'.GW_QR_HOST.'/';
		$code = $qrBase.$shortCode;
		return array('code'=>$code,'image'=>$this->__toArray());
	}
	
	public function instantiateParent($app,$context=''){
		$reflectionClass = new \ReflectionClass($this->parentObject);
        if ($context == 'barcode') {
            return $reflectionClass->newInstance(array('_id'=>$this->belongsTo), $app);
        } else {
            return $reflectionClass->newInstance(array('_id'=>$this->belongsTo,'image'=>$this->__toArray()), $app);
        }		
	}
}