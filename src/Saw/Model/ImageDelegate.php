<?php
namespace Saw\Model;

class ImageDelegate extends Image {
	public function __construct($belongsTo='',$parentAttr=''){
		parent::__construct();
		$this->parentObject = '\Saw\Model\Delegate';
		$this->belongsTo = (!is_object($belongsTo)) ? new \MongoId($belongsTo) : $belongsTo;
		$this->context = 'delegate';
        $this->base = SAW_CDN;
        $this->baseSSL = SAW_SSL_CDN;      
        $this->modified = time(); 
		$this->sizes = array('small'=>array('size'=>400,'id'=>'')
							 ,'large'=>array('size'=>800,'id'=>'')
							);
		if(!empty($parentAttr)){
			$this->parentAttr = $parentAttr;
		}
	}
}