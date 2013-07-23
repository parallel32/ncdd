<?php
namespace Saw\Model;

class ImageMember extends Image {
	public function __construct($belongsTo=''){
		parent::__construct();
		$this->parentObject = '\Saw\Model\Member';
		$this->belongsTo = (!is_object($belongsTo)) ? new \MongoId($belongsTo) : $belongsTo;
		$this->context = 'member';
        $this->base = SAW_CDN;
        $this->baseSSL = SAW_SSL_CDN;      
        $this->modified = time(); 
		$this->sizes = array('small'=>array('size'=>400,'id'=>'')
							);
	}
}