<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Temporary member model for imports.
 * This is a concrete class.
 */
class MemberTemp extends Model {
	
	public $collection = 'membertemp';
	public $firstName;
	public $lastName;
	public $state;
	public $joinDate;
	public $memberId;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
    	$this->firstName = $doc['firstName'];
		$this->lastName = $doc['lastName'];
		$this->state = $doc['state'];
		$this->joinDate = $doc['joinDate'];
		$this->memberId = $doc['memberId'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->firstName = $this->firstName ?: '';
		$this->lastName = $this->lastName ?: '';
		$this->state = $this->state ?: '';
		$this->joinDate = $this->joinDate ?: '';
		$this->memberId = $this->memberId ?: '';
	}
	public function insert(){
		$this->prepareInsert();
			if(parent::insert()){
	        	return $this->_id;
	        }else{
				throw new \Saw\Model\Exceptions\DomainException("Adding failed.  Please try again.");
			}
		//}
	}
	static public function purge($app){
		return $app['mongo']->remove(array(), 'membertemp', $justOne=false, $options=array('fsync'=>true));
	}
	
}