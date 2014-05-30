<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Email Queue Model.
 * This is a concrete class.
 */
class EmailQ extends Model {
	
	public $collection = 'emailq';
	public $to;
	public $from;
	public $fromName;
	public $replyTo;
	public $subject;
	public $body;
	public $sentDate;
	public $timeZone='America/New_York';

	static public function loadValidatorMetadata(ClassMetadata $metadata){
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
    	$this->to = $doc['to'];
		$this->from = $doc['from'];
		$this->fromName = $doc['fromName'];
		$this->replyTo = $doc['replyTo'];
		$this->subject = $doc['subject'];
		$this->body = $doc['body'];
		$this->sentDate = $doc['sentDate'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->to = $this->to ?: '';
		$this->from = $this->from ?: '';
		$this->fromName = $this->fromName ?: '';
		$this->replyTo = $this->replyTo ?: '';
		$this->subject = $this->subject ?: '';
		$this->body = $this->body ?: '';
		$this->sentDate = $this->sentDate ?: new Date(self::$app,'now');
	}
	public function insert(){
		$this->prepareInsert();
		// THIS CONTROL BELOW was causing misleading errors because there are multiple unique emails that go out to the same email address having the same subject
		//$result = $this->find($query=array('to'=>$this->to,'subject'=>$this->subject),$fields=array('_id'),true);
		//if(empty($result)){
			if(parent::insert()){
	        	return $this->_id;
	        }else{
				throw new \Saw\Model\Exceptions\DomainException("Adding failed.  Please try again.");
			}
		//}
	}
	public function edit(){
		if($this->saveSafe()){
			return $this->_id;
        }else{
			throw new \Saw\Model\Exceptions\DomainException("Editing failed.  Please try again.");
		}
	}
	public function delete(){
		try {
			$this->remove();
		} catch (Exception $e) {
			throw new \Saw\Exceptions\InternalServerErrorException("Deleting <strong>".$this->name."</strong> failed due to a database error.");
		}

	}
	public function fetchAll(){
		$result = $this->find($query=array(),$fields=array(),true,$sort=array('_id'=>-1));
		return $result;
	}
	
}