<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Change model. Can be used by every model.
 */
class Change extends Model {
	
    public $collection = 'change';
    public $label; 		// the label to display to identify the change record
    public $belongsTo; 	// the _id of owner of the record.  could be anyone
	public $context;  	// the name of the model setting a record
	public $date;		// date when the update occured
	public $values; 	// array of key value pairs: the key being the model attribute and the value being the new value changed
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->belongsTo = (!empty($doc['belongsTo'])) ? (is_object($doc['belongsTo'])) ? $doc['belongsTo'] : new \MongoId($doc['belongsTo']) : $doc['belongsTo'];
        $this->context = $doc['context'];
        $this->label = $doc['label'];
		$this->date = (!empty($doc['date'])) ? (is_object($doc['date'])) ? $doc['date']->__toArray() : new Date(self::$app,$doc['date'], $this->timeZone)  : $doc['date'];
		$this->values = $doc['values'];
	}
	protected function prepareInsert(){
		$this->belongsTo = (!empty($this->belongsTo)) ? (is_object($this->belongsTo)) ? $this->belongsTo : new \MongoId($this->belongsTo) : new \stdClass();
		$this->label = $this->label ?: '';
		$this->context = $this->context ?: '';
		$this->date = (!empty($this->date)) ? (is_object($this->date)) ? $this->date->__toArray() : $this->date  : new Date(self::$app,'now', 'America/New_York');
		$this->values = $this->values ?: array();		
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}

	public function fetch($offset=0,$limit=10000){
        
		$changes = $this->find($query=array(),$fields=array(),$slaveOkay=true,$sort=array('_id'=>-1),$offset,$limit);
		if(!empty($changes)){
			$i=0;
			foreach ($changes as $change) {
				$human = \Carbon\Carbon::createFromTimeStamp(strtotime($change['date']['fullDateTime']), $change['date']['timezone']);
				$changes[$i]['timeAgo'] = $human->diffForHumans();
				$i++;
			}
		}

		return $changes;
	}

	// performs the check and inserts the changed values.  This is the only method that needs to be called.
	public static function check($model,$label,$app){
		$reflectionClass = new \ReflectionClass($model);
		$context = $reflectionClass->getShortName();
		$belongsTo = $model->_id;

		$new_values = $model->__toArray();
		$new_values = array_filter($new_values);
		$original_values = $model->findOne(array('_id'=>$model->_id));
		//*
		$change_values = array();

		foreach ($new_values as $key => $value) {
			if(!empty($value)){
				if(!is_array($value) && !is_object($value) && array_key_exists($key, $original_values) && $value !== $original_values[$key]){
					$change_values[$key] = $value;
				}
			}
		}
		
		
		if(!empty($change_values)){
			$change = new Change(array('label'=>$label,'context'=>$context,'belongsTo'=>$belongsTo,'values'=>$change_values),$app);
			$change_id = $change->insert();	
		}		

		return true;
		//*/
	}
	    
}
