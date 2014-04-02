<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * Page Model.
 * This class is the base class for all application-type forms to be submitted.
 */
class Page extends Model {
	
	public $collection = 'page';
	static public $status = array('DRAFT'=>0,'PRIVATE'=>10, 'PUBLISHED'=>20);
	static public $statusReversed = array(0=>'DRAFT',10=>'PRIVATE', 20=>'PUBLISHED');
	public $currentStatus;
	static public $type = array('MANAGED'=>5,'DYNAMIC'=>10);
	static public $typeReversed = array(5=>'MANAGED',10=>'DYNAMIC');
	public $currentType;
	static public $sections = array('DISCOVER','LEARN','DUI-LAWS-USA','NO-SECTION');
	public $slug;
	public $headline;
	public $body;
	public $section;
	public $publishedDate;
	public $add;
	public $orderNum;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('headline', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('body', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidSlug'),
        )));
	}
	/**
	 * validator helper function
	*/
	public function isValidSlug(ExecutionContext $context){
		if($this->add == 'yes'){
			$result = $this->findById('slug');
			//error_log('valid slug result:'.print_r($result,true));
			if(!empty($result)){
				$propertyPath = $context->getPropertyPath().'slug';
	        	$context->addViolationAtPath($propertyPath,'This url already exists in the system.  Please define another variation and save again.', array(), null);
	        }
	    }
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        
		$this->headline = $doc['headline'];
		$this->slug = (empty($doc['slug']) && !empty($doc['headline'])) ? self::slugify($doc['headline']): $doc['slug'];
		
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->body = (!empty($doc['body'])) ? wptexturize(wpautop($doc['body'])) : '';
		$this->body = $doc['body'];
		$this->publishedDate = $doc['publishedDate'];
		$this->section = $doc['section'];
		
		$this->currentStatus = (empty($doc['currentStatus']) && strlen($doc['currentStatus']) == 0) ? $doc['currentStatus'] : (int)$doc['currentStatus'] ;
		$this->currentType = (empty($doc['currentType']) && strlen($doc['currentType']) == 0) ? $doc['currentType'] : (int)$doc['currentType'] ;
		
		$this->add = $doc['add'];
		// * means no order number present. use this because can't use zero, they'll shoot strait to the top
		$this->orderNum = (!empty($doc['orderNum'])) ? ( $doc['orderNum'] == '*') ? $doc['orderNum']: (int)$doc['orderNum'] : ''; 
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->publishedDate = $this->publishedDate ?: new \stdClass();
		$this->currentStatus = $this->currentStatus ?: self::$status['DRAFT'];
		$this->slug = $this->slug ?: '';
		$this->headline = $this->headline ?: '';
		$this->body = $this->body ?: '';
		$this->section = $this->section ?: '';
		$this->currentType = $this->currentType ?: self::$type['DYNAMIC'];
		$this->orderNum = $this->orderNum ?: '*';
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function saveEdit(){
		$result = $this->find(array('_id'=>$this->_id),array(),false);
		//error_log('result:'.print_r($result,true));
		if(empty($result)){
			return $this->insert();
		}else{
			return $this->saveSafe();
		}
	}
	public function updateOrderNum(){
		//error_log('update order num:'.print_r($this->__toArray(),true));
    	if(!empty($this->_id) && !empty($this->orderNum)){
    		$this->saveSafe();
    	}
    	return true;
    }
	public function publish(){
		$this->publishedDate = new Date(self::$app,'now');
	}
	public function fetchDynamic($offset=0,$limit=100){
		$query = array('currentType'=>self::$type['DYNAMIC']);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('section'=>1,'orderNum'=>1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchManaged($offset=0,$limit=100){
		$query = array('currentType'=>self::$type['MANAGED']);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('section'=>1,'orderNum'=>1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchByStatus($status, $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status[$status]);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('orderNum'=>1,'_id'=>-1),(int)$offset,(int)$limit);
		//error_log('query:'.print_r($query,true));
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchBySection($section, $offset=0,$limit=100){
		$query = array('section'=>$section);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('orderNum'=>1,'headline'=>1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchBySectionSlug($offset=0,$limit=500){
		$query = array('section'=>$this->section,'slug'=>$this->slug);
		$fields = array();
		$result = $this->findOne($query,$fields,$slaveOkay=true,$sort=array('headline'=>1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchBySectionPublishedOnly($section, $offset=0,$limit=100){
		$query = array('section'=>$section, 'currentStatus'=>self::$status['PUBLISHED']);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('orderNum'=>1,'headline'=>1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchBySectionSlugPublishedOnly($offset=0,$limit=500){
		$query = array('section'=>$this->section,'slug'=>$this->slug, 'currentStatus'=>self::$status['PUBLISHED']);
		$fields = array();
		$result = $this->findOne($query,$fields,$slaveOkay=true,$sort=array('orderNum'=>1,'headline'=>1,),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

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
			$result = $this->find($query=array('body'=>$regex,'currentStatus'=>self::$status['PUBLISHED']),$fields,true,$sort=array('orderNum'=>1,'headline'=>1),$offset=0,$limit=3000);		
			
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
			$result = $this->find($query=array('headline'=>$regex,'currentStatus'=>self::$status['PUBLISHED']),$fields,true,$sort=array('orderNum'=>1,'headline'=>1),$offset=0,$limit=3000);		
			
		}
		return $result;
	}
	
	public function delete(){

		return $this->removeByCriteria(array('slug'=>$this->slug));

		// delete drive files
		$drive = new Drive(array('belongsTo'=>$this->_id),self::$app);
		$drive->deleteAll();
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