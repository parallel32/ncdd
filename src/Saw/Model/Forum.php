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
	static public $status = array('DRAFT'=>10,'REVIEW'=>20,'UNPUBLISH'=>30,'PUBLISH'=>50);
	static public $statusReversed = array(10=>'DRAFT',20=>'REVIEW', 30=>'UNPUBLISH', 50=>'PUBLISH');
	public $currentStatus;
	public $name;
	public $owner;
	public $commentCount;
	public $topicCount;
	public $add; // for designating which upsert is happening; the insert or the update
	public $image;


	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		
	}
	public function __construct($doc, Application $app, $owner=array()){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
      	$this->name = $doc['name'];
		$this->owner = (is_object($owner)) ? $owner->__toArray(false) : $doc['owner'];
		$this->commentCount = $doc['commentCount'];
		$this->topicCount = $doc['topicCount'];
		$this->add = $doc['add'];
		$this->image = $doc['image'];
		$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['DRAFT'];
		$this->name = $this->name ?: '';
		$this->owner = $this->owner ?: new \stdClass();
		$this->commentCount = $this->commentCount ?: 0;
		$this->topicCount = $this->topicCount ?: 0;
		$this->add = $this->add ?: 'yes';
		$this->image = $this->image ?: new \stdClass();

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

	public function fetchOrderBy($query=array(), $fields=array(), $column='_id', $direction=-1, $offset=0,$limit=1000){
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array($column=>$direction),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				if(array_key_exists('currentStatus',$result[$i])){
					$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				}
				$result[$i]['image'] = (!empty($result[$i]['image'])) ? $result[$i]['image']['urls']['small']['CDN'] : '';
			}
		endif;
		return $result;
	}

	public function incTopicCount(){

		// find topics that are published and update the topic count
		$topic = new Topic(array('forum'=>array('_id'=>(string)$this->_id)),self::$app);
		$topics = $topic->fetchByForumByStatus((string)$this->_id,Topic::$status['PUBLISH']);
		$this->topicCount = count($topics);
		$this->saveSafe();

		return true;	
	}
	
	public function delete(){

		// delete forum
    	$this->remove();

    	// purge topics
    	self::$app['mongo']->remove(array('forumId'=>$this->_id), 'topic', $justOne=false, $options=array('fsync'=>true));
    	// TODO: purge topic photos
    	// TODO: purge topic comments
    	// TODO: purge anything else for topics

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
	
}