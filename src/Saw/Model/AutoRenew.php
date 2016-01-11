<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;

/**
 * AutoRenew model.  holds member records in order to pay them.
 */
class AutoRenew extends Model {
	
    public $collection = 'autorenew';
    public $record;   // the full member record
    public $promotion; // the promotion that was used to be included in auto-renew
    public $expired; // is card expired
    public $valid;   // is card currently valid
    public $declined; // yes no
    public $declinedMessage; // 
    public $paid; // yes no
    public $paymentId; // paymentId to facilitate accessing the payment record.
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
    	$this->record = $doc['record'];
	    $this->promotion = $doc['promotion'];
	    $this->expired = $doc['expired'];
	    $this->valid = $doc['valid'];
	    $this->declined = $doc['declined'];
	    $this->declinedMessage = $doc['declinedMessage'];
	    $this->paid = $doc['paid'];
	    $this->paymentId = $doc['paymentId'];
        
	}
	protected function prepareInsert(){
		$this->record = $this->record ?: '';
	    $this->promotion = $this->promotion ?: '';
	    $this->expired = $this->expired ?: '';
	    $this->valid = $this->valid ?: '';
	    $this->declined = $this->declined ?: '';
	    $this->declinedMessage = $this->declinedMessage ?: '';
	    $this->paid = $this->paid ?: '';
	    $this->paymentId = $this->paymentId ?: '';
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}

	public function delete(){

		// delete one by id
    	$this->remove();

	}
	public function deleteAll(){

		// delete all records in collection
    	$this->removeByCriteria(array());

    	
	}

		    
}
