<?php
namespace Saw\Model;

class ImageSeminar extends Image {
	public function __construct($belongsTo=''){
		parent::__construct();
		$this->parentObject = '\Saw\Model\Seminar';
		$this->belongsTo = (!is_object($belongsTo)) ? new \MongoId($belongsTo) : $belongsTo;
		$this->context = 'seminar';
        $this->base = SAW_CDN_IMAGE;
        $this->baseSSL = SAW_SSL_CDN_IMAGE;      
        $this->modified = time(); 
		$this->sizes = array(	array('name'=>'small', 'size'=>400,'id'=>'')
							 	,array('name'=>'medium', 'size'=>600,'id'=>'')
								,array('name'=>'large', 'size'=>800,'id'=>'')
							);
	}
}