<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * Forum Model.
 * This class serves the Forum collection.
 */
class Forum extends Model {
	
	public $collection = 'forum';
	public $name;
	public $slug;
	public $author;
	public $commentCount;
	public $topicCount;
	public $add; // for designating which upsert is happening the insert or the update
	public $timeZone = 'America/New_York';
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
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
      	$this->name = $doc['name'];
		$this->slug = (empty($doc['slug']) && !empty($doc['name'])) ? self::slugify($doc['name']): $doc['slug'];
		$this->author = (is_object($author)) ? $author->__toArray(false) : $doc['author'];
		$this->commentCount = $doc['commentCount'];
		$this->topicCount = $doc['topicCount'];
		$this->add = $doc['add'];
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->name = $this->name ?: '';
		$this->slug = $this->slug ?: '';
		$this->author = $this->author ?: new \stdClass();
		$this->commentCount = $this->commentCount ?: 0;
		$this->topicCount = $this->topicCount ?: 0;
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
	public function fetchToPublish($offset=0,$limit=10000){
		$query = array('currentStatus'=>self::$status['SCHEDULE']
						,'scheduleDate.date'=>array('$lte'=>new \MongoDate(strtotime('now')))
		);
		$fields = array('slug'=>true,'currentStatus'=>true);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);

		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));

		return $result;

	}
	public function delete(){

		// delete blog
    	$this->remove();

    	// purge topics
    	self::$app['mongo']->remove(array('forumId'=>$this->_id), 'topic', $justOne=false, $options=array('fsync'=>true));

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

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