<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * Topic Model.
 * This class serves the Topic collection, which belongs to Forum.
 */
class Topic extends Model {
	
	public $collection = 'topic';
	static public $status = array('DRAFT'=>10,'REVIEW'=>20,'UNPUBLISH'=>30,'SCHEDULE'=>40, 'PUBLISH'=>50, 'REQUEST_DELETE'=>60);
	static public $statusReversed = array(10=>'DRAFT',20=>'REVIEW', 30=>'UNPUBLISH', 40=>'SCHEDULE', 50=>'PUBLISH', 60=>'REQUEST_DELETE');
	public $currentStatus;
	public $forum; // the forum to which this topic belongs
	public $headline;
	public $body;
	public $image;
	public $commentCount;
	public $author;
	public $files;
	// dates
	public $published; // yes or no
	public $publishDate;
	public $reviewDate;
	public $draftDate;
	public $unpublishDate;
	public $scheduleDate;
	// dates
	public $add; // for designating which upsert is happening the insert or the update
	public $timeZone = 'America/New_York';
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('headline', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('body', new Constraints\NotBlank(array('message'=>'cannot be blank')));
        $metadata->addConstraint(new Callback(array('methods' => array('checkDate'))));
	}
	public function checkDate(ExecutionContext $context){
		//if(!empty($this->currentStatus)){
			if($this->currentStatus == self::$status['SCHEDULE']){
				$date = '';
				if(is_object($this->scheduleDate)){
					$date = $this->scheduleDate->checkError;
				}
				if(is_array($this->scheduleDate)){
					$date = $this->scheduleDate['checkError'];
				}
				if(strpos($date,'1969-12-31') !== false){
		            $propertyPath = $context->getPropertyPath().'scheduleDate';
		        	$context->addViolationAtPath($propertyPath,'Could not compute a valid Schedule Date. Please try another value.', array(), null);
				}
				if(empty($this->scheduleDate)){
		            $propertyPath = $context->getPropertyPath().'scheduleDate';
		        	$context->addViolationAtPath($propertyPath,'cannot be blank', array(), null);
				}
			}
		//}
		
	}
	public function __construct($doc, Application $app, $author=array()){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
      
		$this->headline = $doc['headline'];
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->body = (!empty($doc['body'])) ? wptexturize(wpautop($doc['body'])) : '';
		
		$this->image = $doc['image'];
		$this->commentCount = $doc['commentCount'];
		$this->author = (is_object($author)) ? $author->__toArray(false) : $doc['author'];
		$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];
		$this->scheduleDate = $doc['scheduleDate'];
		$this->publishDate = $doc['publishDate'];
		$this->reviewDate = $doc['reviewDate'];
		$this->draftDate = $doc['draftDate'];
		$this->unpublishDate = $doc['unpublishDate'];
		$this->files = (!empty($doc['files']) && is_string($doc['files'])) ? json_decode($doc['files']): $doc['files'];

		$this->setCurrentStatus();

		$this->add = $doc['add'];
		$this->forum = $doc['forum'];
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['DRAFT'];
		
		$this->headline = $this->headline ?: '';
		$this->body = $this->body ?: '';
		
		$this->image = $this->image ?: new \stdClass();
		$this->commentCount = $this->commentCount ?: 0;
		$this->author = $this->author ?: new \stdClass();
		$this->files = $this->files ?: array();
		
		$this->published = $this->published ?: 'no';
		$this->publishDate = ($this->currentStatus == self::$status['PUBLISH']) ? new Date(self::$app,'now') : new \stdClass();
		$this->reviewDate = $this->reviewDate ?: new \stdClass();
		$this->draftDate = $this->draftDate ?: new Date(self::$app,'now');
		$this->unpublishDate = $this->unpublishDate ?: new \stdClass();
		$this->scheduleDate = $this->scheduleDate ?: new \stdClass();

		$this->add = $this->add ?: 'yes';
		$this->forum = $this->forum ?: new \stdClass();

	}
	public function saveEdit(){
		if(!empty($this->forum)){
			$forum = new Forum(array('_id'=>$this->forum),self::$app);
			$this->forum = $forum->findById();
		}
		if($this->add == 'yes'){
			$this->prepareInsert();
			if(parent::insert()){
				if(!empty($this->forum) || $this->currentStatus == sef::$status['PUBLISH']){
					$forum->incTopicCount(); 
				}
	        	return $this->_id;
	        }else{
				throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
			}
		}else{
			$this->saveSafe();
			if(!empty($this->forum) || $this->currentStatus == self::$status['PUBLISH']){
				$forum->incTopicCount(); 
			}
			return $this->_id;
		}
	}
	private function setCurrentStatus(){
		if(!empty($this->currentStatus)){
			switch (self::$statusReversed[$this->currentStatus]) {
				case 'DRAFT':
					$this->draftDate = new Date(self::$app,'now');
					break;
				case 'REVIEW':
					$this->reviewDate = new Date(self::$app,'now');
					$this->scheduleDate = new \stdClass();// here because the editor/admin can un-schedule a post from the publishing queue
					break;
				case 'SCHEDULE':
					if(!empty($this->scheduleDate)){
						$this->scheduleDate = new Date(self::$app,$this->scheduleDate);
					}
					break;
				case 'UNPUBLISH':
					$this->unpublishDate = new Date(self::$app,'now');
					$this->scheduleDate = new \stdClass();
					$this->publishDate = new \stdClass();
					$this->published = 'no';
					break;
				case 'PUBLISH':
					$this->publishDate = new Date(self::$app,'now');
					$this->published = 'yes';
					break;
			}
		}
	}
	public function fetchByStatus($status, $published='', $offset=0,$limit=10000){
		$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},self::$app);
		
		if($user['accessLevel'] >= EDITOR){
			$query = array('currentStatus'=>self::$status[$status],'forum.owner'=>array());
		}else{
			$memberId = new \MongoId((string)$user['user_id']);
			$query = array('currentStatus'=>self::$status[$status],'forum.owner._id'=>$memberId);
		}
		
		if(!empty($published)){
			$query['published'] = $published;
		}
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('draftDate.date'=>-1,'reviewDate.date'=>-1,'scheduleDate.date'=>-1,'publishDate.date'=>-1,'unpublishDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchRecentPublished($offset=0,$limit=10){
		
		$query = array('currentStatus'=>self::$status['PUBLISH']);
		$fields = array('headline'=>1,'forum.name'=>1,'forum.owner.displayName'=>1,'author.displayName'=>1,'publishDate'=>1,'body'=>1);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('publishDate.date'=>-1),(int)$offset,(int)$limit);
		return $result;

	}
	public function fetchArchives($month,$year, $offset=0,$limit=100){
		
		$query = array('currentStatus'=>self::$status['PUBLISH'],'published'=>'yes','publishDate.month'=>$month, 'publishDate.year'=>$year);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('publishDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchByAuthorByDraft($offset=0,$limit=100){

		$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},self::$app);
		$memberId = new \MongoId((string)$user['user_id']);
		$query = array('currentStatus'=>array('$lt'=>self::$status['PUBLISH']),'author._id'=>$memberId);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('draftDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchByAuthorByReview($offset=0,$limit=100){
		$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},self::$app);
		
		if($user['accessLevel'] >= EDITOR){
			$query = array('currentStatus'=>self::$status['REVIEW'],'forum.owner'=>array());
		}else{
			$memberId = new \MongoId((string)$user['user_id']);
			$query = array('currentStatus'=>self::$status['REVIEW'],'forum.owner._id'=>$memberId);	
		}

		
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('reviewDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchByAuthorByApproved($offset=0,$limit=100){
		$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},self::$app);
		
		if($user['accessLevel'] >= EDITOR){
			$query = array('forum.owner'=>array(), 'currentStatus'=>array('$gte'=>self::$status['SCHEDULE']));
		}else{
			$memberId = new \MongoId((string)$user['user_id']);
			$query = array('forum.owner._id'=>$memberId, 'currentStatus'=>array('$gte'=>self::$status['SCHEDULE']));
		}
		
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('scheduleDate.date'=>-1,'publishDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchToPublish($offset=0,$limit=10000){
		$query = array('currentStatus'=>self::$status['SCHEDULE']
						,'scheduleDate.date'=>array('$lte'=>new \MongoDate(strtotime('now')))
		);
		$fields = array('currentStatus'=>true);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);

		//error_log('fetch:'.print_r($query,true));
		//error_log('result:'.print_r($result,true));

		return $result;

	}
	public function fetchByForumByStatus($forumId, $status, $fields=array(), $offset=0,$limit=500){

		$fields = $fields ?: array('currentStatus'=>1,'headline'=>1);
		if(!empty($forumId)){

			$forumId = (is_object($forumId)) ? $forumId : new \MongoId($forumId);
			$query = array('forum._id'=>$forumId, 'currentStatus'=>(int)$status);
			$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
			if(!empty($result) && array_key_exists('currentStatus',$fields)):
				for ($i=0; $i < count($result); $i++) { 
					$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				}
			endif;
		}else{
			$result = array();
		}
		return $result;

	}
	public function fetchByForum($forumId, $fields=array(), $offset=0,$limit=500000){

		$fields = $fields ?: array('headline'=>1,'_id'=>1);
		if(!empty($forumId)){

			$forumId = (is_object($forumId)) ? $forumId : new \MongoId($forumId);
			$query = array('forum._id'=>$forumId);
			$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('_id'=>-1),(int)$offset,(int)$limit);
		}else{
			$result = array();
		}
		return $result;

	}
	public function delete(){

		// delete topic
    	$this->remove();

    	// purge comments
    	self::$app['mongo']->remove(array('belongsTo'=>$this->_id), 'comment', $justOne=false, $options=array('fsync'=>true));

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
	
}