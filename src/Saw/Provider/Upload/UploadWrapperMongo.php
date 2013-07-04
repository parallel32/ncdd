<?php
namespace Saw\Provider\Upload;

use Silex\Application;

class UploadWrapperMongo
{
	private $app = null;
	public $collection = 'image';
	
	function __construct(Application $app) {
		$this->app = $app;
    }
	/**
	 * save image and corresponding document to mongo
	 * @param $image 	image	image object passed in by reference so that the insert Id can be added
	 *							and the urls can be made
	 */
	public function saveImage($uri, $encoding, &$image,$imageParams=array('max_width'=>800,'max_height'=>600)) {
        // if encoding is jpg it must be converted to jpeg to properly set the content type for amazon
        $response = array();
		// resize image
		$img_create = $this->create_scaled_image($uri, array('type'=>$encoding,'max_width'=>$imageParams['max_width'],'max_height'=>$imageParams['max_height']));
        
        if ($img_create['status']) {
            try {
                $image->imageId = $this->app['mongo']->storeFile($uri, $this->collection, $doc=array('image'=>$image->__toArray()));
				$response['success'] = true;
            } catch (Exception $err) {
                $response['success'] = true;
                $response['error'] = $err->getMessage();
            }
        } else {
            $response['success'] = false;
            $response['error'] = $img_create['error'];
        }
        return $response;
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
            $response['message'] = 'Unknown error';
        }
        return $response;
    }
	
	public function create_scaled_image($uri, $options) {
        $file_path = $uri;
        $new_file_path = $uri;
        $result = array();
        list($img_width, $img_height) = @getimagesize($file_path);
        
        if (!$img_width || !$img_height) {
            $result['status'] = false;
            $result['error'] = 'Error loading the image.\nPlease try again';
        }
        if ($img_height < 250 || $img_width < 250) {
            $result['status'] = false;
            $result['error'] = 'Please choose an image with better resolution (minimum 250 pixels width or 250 pixels height).';
        }
        
        if (array_key_exists('status',$result) && $result['status'] === false) return $result;
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                if(copy($file_path, $new_file_path)) {
                    $result['status'] = true;
                    return $result;
                }
            }
            $result['status'] = true;
            return $result;
        }
        
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
		switch (strtolower($options['type'])) {
            case IMAGETYPE_JPEG:
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case IMAGETYPE_GIF:
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case IMAGETYPE_PNG:
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }
        $result['status'] = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path, $image_quality);
        if($result['status'] == false) $result['error'] = 'Image failed to resample.';
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $result;
    }
    
    public function orient_image($file_path) {
      	$exif = exif_read_data($file_path);
      	$orientation = intval(@$exif['Orientation']);
      	if (!in_array($orientation, array(3, 6, 8))) { 
      	    return false;
      	}
      	$image = @imagecreatefromjpeg($file_path);
      	switch ($orientation) {
        	  case 3:
          	    $image = @imagerotate($image, 180, 0);
          	    break;
        	  case 6:
          	    $image = @imagerotate($image, 270, 0);
          	    break;
        	  case 8:
          	    $image = @imagerotate($image, 90, 0);
          	    break;
          	default:
          	    return false;
      	}
      	$success = imagejpeg($image, $file_path);
      	// Free up memory (imagedestroy does not delete files):
      	@imagedestroy($image);
      	return $success;
    }
	
	
	
	
	
	
	
	/**
	cannot be used because getimagesizefromstring is for php 5.4.0 or higher .... table it for now
	*/
	public function create_scaled_image_from_bytes($bytes, $options) {
        $result = array();
        list($img_width, $img_height, $img_type) = getimagesizefromstring($bytes);
		
		
        if (!$img_width || !$img_height) {
            $result['status'] = false;
            $result['error'] = 'Error loading the image.\nPlease try again';
			return $result;
        }
        if ($img_height < 250 || $img_width < 250) {
            $result['status'] = false;
            $result['error'] = 'Please choose an image with better resolution (minimum 500 pixels width or 500 pixels height).';
			return $result;
        }
        
        if (array_key_exists('status',$result) && $result['status'] === false) return $result;
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $src_img = @imagecreatefromstring($bytes);
                $image_quality = 75;
                break;
            case IMAGETYPE_GIF:
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromstring($bytes);
                $image_quality = null;
                break;
            case IMAGETYPE_PNG:
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefromstring($bytes);
                $image_quality = 9;
                break;
            default:
                $src_img = null;
        }
        $result['status'] = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        );
        if($result['status'] == false){
			return $result['error'] = 'Image failed to resample.';
		} 
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        return $new_img;
    }
	
}

?>
