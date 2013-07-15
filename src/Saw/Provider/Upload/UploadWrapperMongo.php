<?php
namespace Saw\Provider\Upload;

use Silex\Application;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Imagine\Gd\Imagine;


class UploadWrapperMongo
{
	private $app = null;
    private $imagine = null;
	public $collection = 'image';
	
	function __construct(Application $app) {
		$this->app = $app;
        $this->imagine = new Imagine();
    }
	/**
	 * save image and corresponding document to mongo
	 * @param $image 	image	image object passed in by reference so that the insert Id can be added
	 *							and the urls can be made
	 */
	public function saveImage(&$image,$replace=false) {
        // create image sizes from the original image and save to mongo
        for ($i=0; $i < count($image->sizes); $i++) { 
            
            $img = $this->imagine->open($image->getFilePath());
            
            // get original size and set width (widen) or height (heighten).
            // width or height will be set maintaining aspect ratio.
            $img->resize($img->getSize()->widen($image->sizes[$i]['size']));
                $path = $image->getFile()->getPath();
                $ext = $image->getFile()->getExtension();
                $base_name = $image->getFile()->getBasename('.'.$ext);
                $new_name = $path.'/'.$base_name.'-'.$image->sizes[$i]['size'].'.'.$ext;
            $img->save($new_name);
            $image->sizes[$i]['id'] = (string)$this->app['mongo']->storeFile($new_name
                                                        ,$this->collection
                                                        ,$doc=array('belongsTo'=>$image->belongsTo));
                                                        //*/
            $image->makeUrls();
            
        }
        
        error_log(print_r($image->sizes,true));
        error_log(print_r($image->urls,true));

        $modelObj = $image->instantiateParent($this->app);
        $modelObj->saveSafe();

        return true;
    }
    
	/**
	 * pulls an image out of mongo and returns the stream
	 */
	public function getImage($imageId) {
        
		$bytes = $this->app['mongo']->getFile($imageId,$this->collection,$slaveOkay=true);
		return $bytes;
	}
	/**
	 * pulls an image out of mongo and returns the gridFS object
	 */
	public function getImageObject($imageId) {
        
		$bytes = $this->app['mongo']->getFileObject($imageId,$this->collection,$slaveOkay=true);
		return $bytes;
	}
	    
	public function deleteImage($imageId) {
        $response = array();
        try {
            $fileStatus = $this->app['mongo']->removeFile($imageId,$this->collection);
            $response['success'] = true;
            $response['message'] = 'File removed';
        } catch (Exception $err) {
            $response['success'] = false;
            $response['message'] = 'Error:'.$err->getMessage();
        }
        return $response;
    }
}