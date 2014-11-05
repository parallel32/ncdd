<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Sessions and Seminars Agenda Model.
 * This is a concrete class.
 */
class Agenda extends Model {
	
	public $collection = 'agenda';
	public $seminarId;
	public $name; // pre-defined as Agenda Day {day-number}
	public $date;
	public $timeZone;
	public $timeSlots; // array of AgendaTime objects with their time as the array index so they can be sorted with ksort
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('seminarId', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        if(!empty($doc['seminarId'])) $this->seminarId = (is_object($doc['seminarId'])) ? $doc['seminarId'] : new \MongoId($doc['seminarId']);
		$this->name = $doc['name'];
		$this->timeZone = $doc['timeZone'] ?: 'America/New_York';
		$this->date = (!empty($doc['date'])) ? (is_object($doc['date'])) ? $doc['date']->__toArray() : new Date(self::$app,$doc['date'], $this->timeZone)  : $doc['date'];
		$this->timeSlots = $doc['timeSlots'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->seminarId = $this->seminarId ?: '';
		$this->name = $this->name ?: '';
		$this->timeZone = $this->timeZone ?: 'America/New_York';
		$this->date = (!empty($this->date)) ? (is_object($this->date)) ? $this->date->__toArray() : $this->date  : new Date(self::$app,'now', $this->timeZone);
		$this->timeSlots = $this->timeSlots ?: array();		
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new \Saw\Model\Exceptions\DomainException("Adding failed.  Please try again.");
		}
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
	public function addTimeSlot($agendaTime){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$addToSet'=>array('timeSlots'=>$agendaTime->__toArray(false)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function removeTimeSlot($agendaTime){
		// mongo atomic push onto the array
		$agendaTime = $agendaTime->__toArray(false);

		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$pull'=>array('timeSlots'=>array('date.date'=>$agendaTime['date']['date'])));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	public function findBySeminarId(){
		$results = $this->find($query=array('seminarId'=>$this->seminarId),$fields=array(),$slaveOkay=true,$sort=array('date.date'=>1),$offset=0,$limit=100);
		if(!empty($results)):
			for ($i=0; $i < count($results); $i++) { 
				$t_arr = array();
				foreach ($results[$i]['timeSlots'] as $timeSlot){
					$t_arr[$timeSlot['date']['date']->sec] = $timeSlot;
				}
				ksort($t_arr,SORT_NUMERIC);
				$results[$i]['timeSlots'] = $t_arr;

			}
		endif;
		return $results;
	}
	public function findById($id = '_id', $slaveOkay = true){
		$results = $this->findOne($query=array('_id'=>$this->_id),$fields=array(),$slaveOkay=true,$sort=array('date.date'=>1),$offset=0,$limit=100);
		if(!empty($results)):
			$t_arr = array();
			foreach ($results['timeSlots'] as $timeSlot){
				$t_arr[$timeSlot['date']['date']->sec] = $timeSlot;
			}
			ksort($t_arr,SORT_NUMERIC);
			$results['timeSlots'] = $t_arr;
		endif;

		return $results;
	}
	public function removeBySeminarId(){
		return $this->removeByCriteria(array('seminarId'=>$this->seminarId));
	}
}