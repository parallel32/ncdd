<?php
namespace Saw\Model;

/*
general usage for user uploaded images:
	$offerImg = new OfferImage($imageId);
	$offer_doc['image'] = $offerImg->__toArray();

*/

/**
 * Image model. Not a data object. Designed to prepare a 
 * consistent base image object to be extended for specific
 * image sizes and image contexts.
 */
class Image {

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
	
	public static $uploadedFileName;
	public static $uploadBaseDir = SAW_FILE_UPLOAD_DIR;
	public static $uploadedServer = SAW_SERVER_PUBLIC_NAME;
	public static $uploadPath;
	public static $request;
	public static $file; // symfony File object: http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/File/File.html
	

	public function __construct($cdn=true){
		$this->context = '';
        $this->base = '';
        $this->baseSSL = '';
        $this->modified = '';
		$this->sizes = array('small'=>150,'medium'=>300,'large'=>500);
		$this->urls = array();
		$this->urlTemplate = 'image/{context}/{size}/{imageId}';
		$this->setCDN($cdn);
		$this->urlRelative = $this->urlTemplate;
	}
	public function setCDN($cdn=true){
		if($cdn){
			$cdn = SAW_CDN;
			$ssl_cdn = SAW_SSL_CDN;
			$this->cdn = true;
		}else{
			$cdn = SAW_BASE_URL;
			$ssl_cdn = SAW_BASE_URL;
			$this->cdn = false;
		}
		$this->urlCDN = $cdn.'/'.$this->urlTemplate;
		$this->urlSSLCDN = $ssl_cdn.'/'.$this->urlTemplate;
	}
	public function makeUrls(){
		$tmp = array();
        foreach($this->sizes as $size):
			$find = array('{context}','{size}','{imageId}');
			$replace = array($this->context, $size['size'], $size['id']);
			$tmp[$size['name']]['CDN'] = str_replace($find, $replace, $this->urlCDN);
			$tmp[$size['name']]['SSLCDN'] = str_replace($find, $replace, $this->urlSSLCDN);
			$tmp[$size['name']]['RELATIVE'] = str_replace($find, $replace, $this->urlRelative);
		endforeach;
		$this->urls = $tmp;
	}
	public function __toArray(){
		$doc = get_object_vars($this);
		unset($doc['urlTemplate']);
		unset($doc['urlCDN']);
		unset($doc['urlSSLCDN']);
		unset($doc['urlRelative']);
		unset($doc['cdn']);
		unset($doc['base']);
		unset($doc['baseSSL']);
		return $doc;
	}
	public function instantiateParent($app){
		$reflectionClass = new \ReflectionClass($this->parentObject);
        return $reflectionClass->newInstance(array('_id'=>$this->belongsTo,'image'=>$this->__toArray()), $app);
	}

	public function setRequest(\Symfony\Component\HttpFoundation\Request $request){
		self::$request = $request;
		self::$file = $request->files->get('file');// 'file' is the html input element's name on the file upload form
	}
	public function moveUploadedFile(){
		if(!is_dir(self::$uploadPath)){
			mkdir(self::$uploadPath);
		}
		self::$file->move(self::$uploadPath,self::$uploadedFileName);
	}
	public function getUploadedFileName(){
		return self::$uploadedFileName;		
	}
	public function getFile(){
		self::$file = new \SplFileInfo($this->getFilePath());
		return self::$file;		
	}
	public function getUploadedFileSize(){
		filesize($this->getFilePath());
	}
	public function getFilePath(){
		return self::$uploadPath.'/'.self::$uploadedFileName;
	}
	public function prepareFile(){
		self::$uploadedFileName = $this->context.'-'.$this->belongsTo.'-'.self::$file->getClientOriginalName();
		self::$uploadPath = self::$uploadBaseDir;
		$this->moveUploadedFile();
	}
	public function getImageType(){
		$image_type = exif_imagetype($this->getFilePath());
        // add new
		switch ($image_type) {
			case IMAGETYPE_GIF:
				return 'jpg';
			case IMAGETYPE_JPEG:
				return 'jpg';
			case IMAGETYPE_PNG:
				return 'png';
				break;
			default:
				return 'jpg';
				break;
		}
	}
}