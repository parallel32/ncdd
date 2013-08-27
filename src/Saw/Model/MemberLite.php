<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * MemberLite model.  
 * lightweight version of Member model
 */
class MemberLite extends Model {

	public $_id;
	public $displayName;
	public $email;
	public $image;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->_id = (!is_object($doc['_id'])) ? new \MongoId($doc['_id']) : $doc['_id'];
		$this->displayName = $doc['displayName'];
		$this->email = $doc['email'];
		$this->image = $doc['image'];
	}
	
}