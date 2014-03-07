<?php
namespace Saw\Model;

class ImageDrive extends Image {
	public function __construct($belongsTo=''){
		parent::__construct();
		$this->parentObject = '\Saw\Model\Drive';
		$this->belongsTo = (!is_object($belongsTo)) ? new \MongoId($belongsTo) : $belongsTo;
		$this->context = 'drive';
        $this->base = SAW_CDN;
        $this->baseSSL = SAW_SSL_CDN;      
        $this->modified = time(); 
		$this->sizes = array('small'=>array('size'=>400,'id'=>'')
							 ,'large'=>array('size'=>800,'id'=>'')
							);
	}
}