<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;
use Carbon\Carbon;

/**
 * Sessions and Seminars Model.
 * This is a concrete class.
 */
class Seminar extends Model {
	
	public $collection = 'seminar';
	public $headline;
	public $timeZone;
	public $startDate;
	public $endDate;
	public $location;
	public $slug;
	public $description;
	public $attendanceCertStatement;
	public $files; // array containing any files to be attached via upload.
	public $image; // image object
	public $register; // register object
	public $registerNotice; // registration notice
	public $registerUrl; // registration notice
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('location', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('headline', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('description', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('timeZone', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('startDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('endDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidStartDate'),
        )));   
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidExpirationDate'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('registerUrlCheck'),
        )));
	}
	/**
	 * validator helper function
	*/
	public function registerUrlCheck(ExecutionContext $context){
		if(!empty($this->registerUrl) && !empty($this->register) && $this->register['currentStatus'] == SeminarRegister::$status['OFF']){
			if(strpos($this->registerUrl, 'http') === false && strpos($this->registerUrl, 'https') === false ){
				$propertyPath = $context->getPropertyPath().'registerUrl';
	        	$context->addViolationAtPath($propertyPath,'This must have an http:// or an https:// in the beginning for it to be a valid URL', array(), null);
			}
		}
	}
	/**
	 * validator helper function
	*/
	public function isValidStartDate(ExecutionContext $context){
		$date = '';
		if(is_object($this->startDate)){
			$date = $this->startDate->checkError;
		}
		if(is_array($this->startDate)){
			$date = $this->startDate['checkError'];
		}
		if(strpos($date,'1969-12-31') !== false){
            $propertyPath = $context->getPropertyPath().'startDate';
        	$context->addViolationAtPath($propertyPath,'Could not compute a valid start date. Please try again.', array(), null);
		}
		// start date sanity check .. can't be after expiration date
		if(!empty($date) && !empty($this->endDate)){
			$s_epoch = strtotime($date);
			$e_epoch = null;
			if(is_object($this->endDate)){
				$e_epoch = strtotime($this->endDate->checkError);
			}else if(is_array($this->endDate)){
				$e_epoch = strtotime($this->endDate['checkError']);
			}
			if(!empty($e_epoch)){
				$result = $e_epoch - $s_epoch;
				if($result < 0){
					$propertyPath = $context->getPropertyPath().'startDate';
		        	$context->addViolationAtPath($propertyPath,'Start Date cannot be after End Date.', array(), null);
				}
			}
		}
	}
	/**
	 * validator helper function
	*/
	public function isValidExpirationDate(ExecutionContext $context){
		$date = '';
		if(is_object($this->endDate)){
			$date = $this->endDate->checkError;
		}
		if(is_array($this->endDate)){
			$date = $this->endDate['checkError'];
		}
		if(strpos($date,'1969-12-31') !== false){
            $propertyPath = $context->getPropertyPath().'endDate';
        	$context->addViolationAtPath($propertyPath,'Could not compute a valid expiration date. Please try again.', array(), null);
		}
		
		// expiration date sanity check .. can't be before start date
		if(!empty($date) && !empty($this->startDate)){
			$e_epoch = strtotime($date);
			$s_epoch = null;
			if(is_object($this->startDate)){
				$s_epoch = strtotime($this->startDate->checkError);
			}else if(is_array($this->startDate)){
				$s_epoch = strtotime($this->startDate['checkError']);
			}
			if(!empty($s_epoch)){
				$result = $e_epoch - $s_epoch;
				if($result < 0){
					$propertyPath = $context->getPropertyPath().'endDate';
		        	$context->addViolationAtPath($propertyPath,'End Date cannot be before Start Date.', array(), null);
				}
			}
		}
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
		$this->location = $doc['location'];
		$this->headline = $doc['headline'];
        $this->slug = (empty($doc['slug'])) ? self::slugify($this->headline): $doc['slug'];
		$this->timeZone = $doc['timeZone'];
        $this->startDate = (!empty($doc['startDate'])) ? (is_object($doc['startDate'])) ? $doc['startDate']->__toArray() : new Date(self::$app,$doc['startDate'], $this->timeZone)  : $doc['startDate'];
		$this->endDate = (!empty($doc['endDate'])) ? (is_object($doc['endDate'])) ? $doc['endDate']->__toArray() : new Date(self::$app,$doc['endDate'], $this->timeZone)  : $doc['endDate'];
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->description = (!empty($doc['description'])) ? wptexturize(wpautop($doc['description'])) : '';
		$this->attendanceCertStatement = (!empty($doc['attendanceCertStatement'])) ? wptexturize(wpautop($doc['attendanceCertStatement'])) : '';
		$this->files = $doc['files'];
        $this->image = (is_object($doc['image'])) ? $doc['image']->__toArray() : $doc['image'];
        $this->register = (is_object($doc['register'])) ? $doc['register']->__toArray() : $doc['register'];
        $this->registerNotice = $doc['registerNotice'];
        $this->registerUrl = $doc['registerUrl'];
        
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->location = $this->location ?: '';
		$this->headline = $this->headline ?: '';
		$this->slug = self::slugify($this->headline);
		$this->timeZone = $this->timeZone ?: 'America/New_York';
		$this->startDate = (!empty($this->startDate)) ? (is_object($this->startDate)) ? $this->startDate->__toArray() : $this->startDate  : new Date(self::$app,'now', $this->timeZone);
		$this->endDate = (!empty($this->endDate)) ? (is_object($this->endDate)) ? $this->endDate->__toArray() : $this->endDate  : new Date(self::$app,'now', $this->timeZone);
		$this->description = $this->description ?: '';
		$this->attendanceCertStatement = $this->attendanceCertStatement ?: '';
		$this->files = $this->files ?: array();
		$this->image = (!empty($this->image)) ? (is_object($this->image)) ? $this->image->__toArray() : $this->image  : new \stdClass();
		$this->register = (!empty($this->register)) ? (is_object($this->register)) ? $this->register->__toArray() : $this->register  : new \stdClass();
		$this->registerNotice = $this->registerNotice ?: array();
		$this->registerUrl = $this->registerUrl ?: '';
		
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			
			// prepare the Agenda Objects
			$tz = new \DateTimeZone('America/New_York');
			$startDate = (is_object($this->startDate)) ? $this->startDate->__toArray() : $this->startDate;
			$endDate = (is_object($this->endDate)) ? $this->endDate->__toArray() : $this->endDate;
			$start = Carbon::createFromTimeStamp(strtotime($startDate['fullMonth']), $tz);
			$end = Carbon::createFromTimeStamp(strtotime($endDate['fullMonth']), $tz);
			$days = $start->diffInDays($end)+1;
			for ($i=0; $i < $days; $i++) { 
				$start = Carbon::createFromTimeStamp(strtotime($startDate['fullMonth']), $tz);
				$add_days = $start->addDays($i)->toATOMString();
				$date = new Date(self::$app,$add_days, $this->timeZone);
	     		$agenda = new Agenda(array(
	     			'seminarId'=>$this->_id,
	     			'name'=>'Agenda Day '.($i+1),
	     			'timeZone'=>$this->timeZone,
	     			'date'=> $date
	     		),self::$app);
	     		$agenda->insert();
	     	}     

        	return $this->_id;
        }else{
			throw new \Saw\Model\Exceptions\DomainException("Adding failed.  Please try again.");
		}
	}
	public function saveEdit(){
		return $this->saveSafe();
	}
	public function edit(){
		if($this->saveSafe()){
			// update the agendas
			// prepare the Agenda Objects
			$tz = new \DateTimeZone('America/New_York');
			$startDate = (is_object($this->startDate)) ? $this->startDate->__toArray() : $this->startDate;
			$endDate = (is_object($this->endDate)) ? $this->endDate->__toArray() : $this->endDate;
			$start = Carbon::createFromTimeStamp(strtotime($startDate['fullMonth']), $tz);
			$end = Carbon::createFromTimeStamp(strtotime($endDate['fullMonth']), $tz);
			$days = $start->diffInDays($end)+1;
			for ($i=0; $i < $days; $i++) { 
				$start = Carbon::createFromTimeStamp(strtotime($startDate['fullMonth']), $tz);
				$add_days = $start->addDays($i)->toATOMString();
				$date = new Date(self::$app,$add_days, $this->timeZone);
				$agenda_name = 'Agenda Day '.($i+1);
	     		$agenda = new Agenda(array(
	     			'seminarId'=>$this->_id,
	     			'name'=>$agenda_name,
	     			'timeZone'=>$this->timeZone,
	     			'date'=> $date
	     		),self::$app);
	     		$find_res = $agenda->findOne(array('seminarId'=>$this->_id,'name'=>$agenda_name));
	     		if(!empty($find_res)  && !empty($find_res['_id'])){
	     			// update
	     			foreach($find_res['timeSlots'] as $timeSlot):
	     				$date = new Date(self::$app,$find_res['date']['fullMonth'].' '.$timeSlot['date']['longTime'], $this->timeZone);
	     				$agendaTime = new AgendaTime(array('date'=>$date
	     													,'title'=>$timeSlot['title']
	     													,'description'=>$timeSlot['description']
	     													,'color'=>$timeSlot['color']
	     													,'timeZone'=>$this->timeZone
	     													), self::$app);
	     				$agenda->timeSlots[] = $agendaTime->__toArray();
	     			endforeach;
	     		}
	     		$agendas[] = $agenda;
	     	}// end for  
	     	// remove the old agenda records by seminarId
	     	$agenda->removeBySeminarId();

	     	// add the new ones
	     	foreach ($agendas as $agenda_obj){
	     		$agenda_obj->insert();
	     	}
			return $this->_id;
        }else{
			throw new \Saw\Model\Exceptions\DomainException("Editing failed.  Please try again.");
		}
	}

	public function search($string){

		$fields = array();// get all fields
		$result = array();
		$search_arr = explode(' ', $string);
		if(is_array($search_arr)){
			$regex = '/^';
			foreach ($search_arr as $key) {
				$regex .= '.*?\b'.addslashes($key).'\b';
			}
			$regex.= '.*?$/im';

			$regex = new \MongoRegex($regex);
			$result = $this->find($query=array('description'=>$regex),$fields,true,$sort=array('startDate.date'=>-1),$offset=0,$limit=3000);		
			
		}
		return $result;
	}
	public function searchHeadline($string){

		$fields = array();// get all fields
		$result = array();
		$search_arr = explode(' ', $string);
		if(is_array($search_arr)){
			$regex = '/^';
			foreach ($search_arr as $key) {
				$regex .= '.*?\b'.addslashes($key).'\b';
			}
			$regex.= '.*?$/im';

			$regex = new \MongoRegex($regex);
			$result = $this->find($query=array('headline'=>$regex),$fields,true,$sort=array('startDate.date'=>-1),$offset=0,$limit=3000);		
			
		}
		return $result;
	}
	
	public function delete(){
		try {
			$this->remove();
			$agenda = new Agenda(array('seminarId'=>$this->_id),self::$app);
			$agenda->removeBySeminarId();
			
	    	// delete images
			self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

			// delete drive files
			$drive = new Drive(array('belongsTo'=>$this->_id),self::$app);
			$drive->deleteAll();

		} catch (Exception $e) {
			throw new \Saw\Exceptions\InternalServerErrorException("Deleting <strong>".$this->headline."</strong> failed due to a database error.");
		}

	}
	public static function slugify($str){

		$slugify = new \Cocur\Slugify\Slugify();//for iconv translit
		
		$arr = explode('/',$str);
		for ($i=0; $i < count($arr); $i++) { 
			$slug = $slugify->slugify($arr[$i]);
			$arr[$i] = ($slug == 'n-a') ? '':$slug;
		}
		$slug = implode('/',$arr);
		
		return $slug;
	}
}