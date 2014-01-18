<?php
namespace Saw\Model;

class ImageForum extends Image {
	public function __construct($belongsTo=''){
		parent::__construct();
		$this->parentObject = '\Saw\Model\Forum';
		$this->belongsTo = (!is_object($belongsTo)) ? new \MongoId($belongsTo) : $belongsTo;
		$this->context = 'forum';
        $this->base = SAW_CDN;
        $this->baseSSL = SAW_SSL_CDN;      
        $this->modified = time(); 
		$this->sizes = array('small'=>array('size'=>400,'id'=>'')
							 ,'large'=>array('size'=>800,'id'=>'')
							);
	}
}