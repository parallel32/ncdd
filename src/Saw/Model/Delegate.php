<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
sessions@test.com / test
sills@test.com / test
 * State Delegate Model.
 * This class is the base class for the blog system.
 */
class Delegate extends Model {
	
	public $collection = 'delegate';
	static public $status = array('DRAFT'=>10,'PUBLISH'=>50);
	static public $statusReversed = array(10=>'DRAFT',50=>'PUBLISH');
	public $currentStatus;
	public $country;
	public $state;
	public $abbr;
	public $slug;
	public $body;
	public $image;
	public $image2;
	public $image3;
	public $members;// array of members who are the state delegates. Most of the time it's just one person.
	public $events;// array of events from StateSeminar collection
	public $lastEditDate; // last time the body was edited or an image was uploaded.
	public $add; // for designating which upsert is happening the insert or the update
	public $timeZone = 'America/New_York';
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('body', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('slug', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidSlug'),
        )));
	}
	/**
	 * validator helper function
	*/
	public function isValidSlug(ExecutionContext $context){
	
		$result = $this->findOne($query=array('slug'=>$this->slug),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['_id'] != $this->_id){
			$propertyPath = $context->getPropertyPath().'slug';
        	$context->addViolationAtPath($propertyPath,'This URL already exists in the system.  Please change your Headline slightly to produce a more unique URL.', array(), null);
        }
	}
	public function __construct($doc, Application $app, $author=array()){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
      	$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];
		$this->country = $doc['country'];
		$this->state = $doc['state'];
		$this->abbr = $doc['abbr'];
		$this->slug = (empty($doc['slug']) && !empty($doc['state'])) ? self::slugify($doc['state']): $doc['slug'];
		$this->slug = (!empty($this->slug) && $this->slug[0] != '/') ? '/'.$this->slug: $this->slug;
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->body = (!empty($doc['body'])) ? wptexturize(wpautop($doc['body'])) : '';
		$this->image = $doc['image'];
		$this->image2 = $doc['image2'];
		$this->image3 = $doc['image3'];
		$this->members = $doc['members'];
		$this->events = $doc['events'];
		$this->lastEditDate = new Date(self::$app,'now');
		$this->add = $doc['add'];		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['DRAFT'];
		$this->country = $this->country ?: '';
		$this->state = $this->state ?: '';
		$this->abbr = $this->abbr ?: '';
		$this->slug = $this->slug ?: '';
		$this->body = $this->body ?: '';
		$this->image = $this->image ?: new \stdClass();
		$this->image2 = $this->image2 ?: new \stdClass();
		$this->image3 = $this->image3 ?: new \stdClass();
		$this->members = $this->members ?: array();
		$this->events = $this->events ?: array();
		$this->lastEditDate = new Date(self::$app,'now');
		$this->add = $this->add ?: 'yes';
	}
	public function saveEdit(){
		if($this->add == 'yes'){
			$this->prepareInsert();
			if(parent::insert()){
	        	return $this->_id;
	        }else{
				throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
			}
		}else{
			$this->saveSafe();
			return $this->_id;
		}
	}
	
	public function fetchByDelegate($memberId, $offset=0,$limit=10000){
		$memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
		$query = array('members'=>array('$elemMatch'=>array('_id'=>$memberId)));
		$fields = array();
		$result = $this->findOne($query,$fields,$slaveOkay=true,$sort=array(),(int)$offset,(int)$limit);
		return $result;
	}
	public function fetchByState($state,$country,$allfields=false,$allrecords=true){
		if($allrecords)
			$query = array('abbr'=>$state,'country'=>$country);
		else
			$query = array('abbr'=>$state,'country'=>$country,'currentStatus'=>self::$status['PUBLISH']);
		if($allfields){
			$fields = array();
		}else{
			$fields = array('_id'=>1,'members'=>1,'lastEditDate'=>1,'currentStatus'=>1);	
		}
		
		$result = $this->findOne($query,$fields);
		return $result;
	}
	public function fetchAll($published=true,$fields=array(),$formatted=false){
		
		$query=array();
		
		if($published)
			$query = array('currentStatus'=>self::$status['PUBLISH']);

		if($formatted){
			$countries = $this->distinct('country',$query);
			krsort($countries);
			foreach($countries as $country){
				$q=array_merge(array('country'=>$country),$query);
				$_countries[$country] = $this->find($q,array('state'=>1,'abbr'=>1,'slug'=>1),true,$sort=array('state'=>1));
			}
			$result = $_countries;
		}else{
			$result = $this->find($query,$fields);
		}
		return $result;
	}
	
	public function delete(){

		// delete
    	$this->remove();

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

		// delete drive files
		$drive = new Drive(array('belongsTo'=>$this->_id),self::$app);
		$drive->deleteAll();
	}
	public static function getStates(){

	    $stateMap['usa']['Alabama']='AL';
	    $stateMap['usa']['Oklahoma']='OK';
	    $stateMap['usa']['Arizona']='AZ';
	    $stateMap['usa']['Washington']='WA';
	    $stateMap['usa']['Texas']='TX';
	    $stateMap['usa']['Maryland']='MD';
	    $stateMap['usa']['Georgia']='GA';
	    $stateMap['usa']['North Carolina']='NC';
	    $stateMap['usa']['West Virginia']='WV';
	    $stateMap['usa']['Utah']='UT';
	    $stateMap['usa']['Colorado']='CO';
	    $stateMap['usa']['Virginia']='VA';
	    $stateMap['usa']['Ohio']='OH';
	    $stateMap['usa']['Florida']='FL';
	    $stateMap['usa']['California']='CA';
	    $stateMap['usa']['Nevada']='NV';
	    $stateMap['usa']['Pennsylvania']='PA';
	    $stateMap['usa']['Indiana']='IN';
	    $stateMap['usa']['Tennessee']='TN';
	    $stateMap['usa']['Massachusetts']='MA';
	    $stateMap['usa']['Arkansas']='AR';
	    $stateMap['usa']['New York']='NY';
	    $stateMap['usa']['Illinois']='IL';
	    $stateMap['usa']['New Hampshire']='NH';
	    $stateMap['usa']['Mississippi']='MS';
	    $stateMap['usa']['Missouri']='MO';
	    $stateMap['usa']['South Carolina']='SC';
	    $stateMap['usa']['Minnesota']='MN';
	    $stateMap['usa']['Michigan']='MI';
	    $stateMap['usa']['Maine']='ME';
	    $stateMap['usa']['Idaho']='ID';
	    $stateMap['usa']['Kansas']='KS';
	    $stateMap['usa']['South Dakota']='SD';
	    $stateMap['usa']['Nebraska']='NE';
	    $stateMap['usa']['Iowa']='IO';
	    $stateMap['usa']['Montana']='MT';
	    $stateMap['usa']['New Jersey']='NJ';
	    $stateMap['usa']['Oregon']='OR';
	    $stateMap['usa']['Connecticut']='CT';
	    $stateMap['usa']['Wisconsin']='WI';
	    $stateMap['usa']['New Mexico']='NM';
	    $stateMap['usa']['Louisiana']='LA';
	    $stateMap['usa']['Delaware']='DE';
	    $stateMap['usa']['Alaska']='AK';
	    $stateMap['usa']['Wyoming']='WY';
	    $stateMap['usa']['Washington, DC']='DC';
	    $stateMap['usa']['Rhode Island']='RI';
	    $stateMap['usa']['Kentucky']='KY';
	    $stateMap['usa']['Vermont']='VT';
	    $stateMap['usa']['Hawaii']='HI';
	    $stateMap['usa']['North Dakota']='ND';
	    ksort($stateMap['usa']);
	    $stateMap['canada']['Alberta']='AB';
	    $stateMap['canada']['British Columbia']='BC';
	    $stateMap['canada']['Manitoba']='MB';
	    $stateMap['canada']['New Brunswick']='NB';
	    $stateMap['canada']['Newfoundland and Labrador']='NL';
	    $stateMap['canada']['Nova Scotia']='NS';
	    $stateMap['canada']['Northwest Territories']='NT';
	    $stateMap['canada']['Nunavut']='NU';
	    $stateMap['canada']['Ontario']='ON';
	    $stateMap['canada']['Prince Edward Island']='PE';
	    $stateMap['canada']['Quebec']='QC';
	    $stateMap['canada']['Saskatchewan']='SK';
	    $stateMap['canada']['Yukon']='YT';
	    ksort($stateMap['canada']);
	    return $stateMap;    
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

	public function addMember($member){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$addToSet'=>array('members'=>$member));
		self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
		return true;
	}
	public function removeMember($memberId){
		$memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$pull'=>array('members'=>array('_id'=>$memberId)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	
	public function addEvent($event){
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$addToSet'=>array('events'=>$event));
		self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
		return true;
	}
	public function removeEvent($eventId){
		$eventId = (is_object($eventId)) ? $eventId : new \MongoId($eventId);
		// mongo atomic push onto the array
		$criteria = array('_id'=>$this->_id);
		$update_spec = array('$pull'=>array('events'=>array('_id'=>$eventId)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	
	
}