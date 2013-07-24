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
	public $currentStatus = 0;
	static public $type = array('MANAGED'=>0,'DYNAMIC'=>10);
	static public $typeReversed = array(0=>'MANAGED',10=>'DYNAMIC');
	public $currentType;
	public $slug;
	public $headline;
	public $body;
	public $section;
	public $publishedDate;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('headline', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('body', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->currentStatus = (int)$doc['currentStatus'];
		$this->headline = $doc['headline'];
		$this->slug = (empty($doc['slug']) && !empty($doc['headline'])) ? self::slugify($doc['headline']): $doc['slug'];
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->body = (!empty($doc['body'])) ? wptexturize(wpautop($doc['body'])) : '';
		$this->publishedDate = $doc['publishedDate'];
		$this->section = $doc['section'];
		$this->currentType = (int)$doc['currentType'];
		
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
		$criteria = array('slug'=>$this->slug);
		return $this->trueUpsert($criteria);
	}
	public function publish(){
		$this->publishedDate = new Date(self::$app,'now');
	}
	public function fetchDynamic($offset=0,$limit=100){
		$query = array('currentType'=>self::$type['DYNAMIC']);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		for ($i=0; $i < count($result); $i++) { 
			$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
		}
		return $result;

	}
	public function fetchByStatus($status, $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status[$status]);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function fetchBySection($section, $offset=0,$limit=100){
		$query = array('section'=>$section);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	public function delete(){

		return $this->removeByCriteria(array('slug'=>$this->slug));
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