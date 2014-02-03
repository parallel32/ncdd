<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * Blog Model.
 * This class is the base class for the blog system.
 */
class Blog extends Model {
	
	public $collection = 'blog';
	static public $status = array('DRAFT'=>10,'REVIEW'=>20,'UNPUBLISH'=>30,'SCHEDULE'=>40, 'PUBLISH'=>50);
	static public $statusReversed = array(10=>'DRAFT',20=>'REVIEW', 30=>'UNPUBLISH', 40=>'SCHEDULE', 50=>'PUBLISH');
	public $currentStatus;
	static public $type = array('EDITORIAL'=>10,'PICTURE'=>20,'LINK'=>30,'VIDEO'=>40);
	static public $typeReversed = array(10=>'EDITORIAL',20=>'PICTURE',30=>'LINK',40=>'VIDEO');
	public $currentType;
	public $slug;
	public $headline;
	public $body;
	public $tags;
	public $image;
	public $video;
	public $link;
	public $commentCount;
	public $author;
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
		$metadata->addPropertyConstraint('slug', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('tags', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidSlug'),
        )));
        $metadata->addConstraint(new Callback(array('methods' => array('checkDate'))));
	}
	public function checkDate(ExecutionContext $context){
		if(!empty($this->currentStatus)){
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
		}
		
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
      
        $this->currentType = (!empty($doc['currentType'])) ? self::$typeReversed[$doc['currentType']] : $doc['currentType'];
		$this->headline = $doc['headline'];
		$this->slug = (empty($doc['slug']) && !empty($doc['headline'])) ? self::slugify($doc['headline']): $doc['slug'];
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->body = (!empty($doc['body'])) ? wptexturize(wpautop($doc['body'])) : '';
		
		if(is_string($doc['tags']) && strpos($doc['tags'],',') !== false){
			$doc['tags'] = explode(',', $doc['tags']);
			
		}
		if(!is_array($doc['tags'])){
			$doc['tags'] = array($doc['tags']);
		}
		if(!empty($doc['tags']) && is_array($doc['tags'])){
			for ($i=0; $i < count($doc['tags']); $i++) { 

				if (is_object($doc['tags'][$i])){
					$doc['tags'][$i] = $doc['tags'][$i]->__toArray();
				}
				if (is_array($doc['tags'][$i])){
					$doc['tags'][$i] = $doc['tags'][$i];
				}
				if (is_string($doc['tags'][$i]) && preg_match('/^[0-9a-z]{24}$/',$doc['tags'][$i])){
					$category = new Category(array('_id'=>$doc['tags'][$i]),$app);
					$category->findById();
					$doc['tags'][$i] = $category;	
				}
			}
			
			
		}
		$this->tags = $doc['tags'];
		



		$this->image = $doc['image'];
		$this->video = $doc['video'];
		$this->link = $doc['link'];
		$this->commentCount = $doc['commentCount'];
		$this->author = (is_object($author)) ? $author->__toArray(false) : $doc['author'];
		$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];
		$this->scheduleDate = $doc['scheduleDate'];
		$this->publishDate = $doc['publishDate'];
		$this->reviewDate = $doc['reviewDate'];
		$this->draftDate = $doc['draftDate'];
		$this->unpublishDate = $doc['unpublishDate'];

		$this->setCurrentStatus();
		$this->setCurrentType();

		$this->add = $doc['add'];
		
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['DRAFT'];
		$this->currentType = $this->currentType ?: self::$type['EDITORIAL'];
		
		$this->headline = $this->headline ?: '';
		$this->slug = $this->slug ?: '';
		$this->body = $this->body ?: '';
		$this->tags = $this->tags ?: array();
		
		$this->image = $this->image ?: new \stdClass();
		$this->video = $this->video ?: '';
		$this->link = $this->link ?: '';
		$this->commentCount = $this->commentCount ?: 0;
		$this->author = $this->author ?: new \stdClass();
		
		$this->published = $this->published ?: 'no';
		$this->publishDate = ($this->currentStatus == self::$status['PUBLISH']) ? new Date(self::$app,'now') : new \stdClass();
		$this->reviewDate = $this->reviewDate ?: new \stdClass();
		$this->draftDate = $this->draftDate ?: new Date(self::$app,'now');
		$this->unpublishDate = $this->unpublishDate ?: new \stdClass();
		$this->scheduleDate = $this->scheduleDate ?: new \stdClass();

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
	public function setCurrentType($typeString=''){
		if(empty($typeString)){
			if(!empty($this->image)){
				$this->currentType = self::$type['PICTURE'];
			}
			elseif(!empty($this->link)){
				$this->currentType = self::$type['LINK'];
			}
			elseif(!empty($this->video)){
				$this->currentType = self::$type['VIDEO'];
			}
			else{
				$this->currentType = self::$type['EDITORIAL'];	
			}
		}else{
			$this->currentType = self::$type[$typeString];	
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
	public function fetchByStatus($status, $published='yes', $offset=0,$limit=100){
		$query = array('currentStatus'=>self::$status[$status]);
		if(!empty($published)){
			$query['published'] = $published;
		}
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('draftDate.date'=>-1,'reviewDate.date'=>-1,'scheduleDate.date'=>-1,'publishDate.date'=>-1,'unpublishDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				$result[$i]['currentType'] = self::$typeReversed[$result[$i]['currentType']];
			}
		endif;
		return $result;

	}
	public function fetchArchives($month,$year, $offset=0,$limit=100){
		
		$query = array('currentStatus'=>self::$status['PUBLISH'],'published'=>'yes','publishDate.month'=>$month, 'publishDate.year'=>$year);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('publishDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				$result[$i]['currentType'] = self::$typeReversed[$result[$i]['currentType']];
			}
		endif;
		return $result;

	}
	public function fetchTag($tag, $offset=0,$limit=100){
		$tag = (strpos($tag,'(') !== false) ? str_replace('(','\(',str_replace(')','\)',$tag)) : $tag;
		$search = new \MongoRegex("/".$tag."/i");
		$query = array('tags'=>$search,'currentStatus'=>self::$status['PUBLISH'],'published'=>'yes');
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('publishDate.date'=>-1),(int)$offset,(int)$limit);

		//error_log('query'.print_r($query,true));
		//error_log('result'.print_r($result,true));

		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				$result[$i]['currentType'] = self::$typeReversed[$result[$i]['currentType']];
			}
		endif;
		return $result;

	}
	public function fetchByAuthorByDraft($memberId, $offset=0,$limit=100){
		$memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
		$query = array('currentStatus'=>self::$status['DRAFT'],'author._id'=>$memberId);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('draftDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				$result[$i]['currentType'] = self::$typeReversed[$result[$i]['currentType']];
			}
		endif;
		return $result;

	}
	public function fetchByAuthorByReview($memberId, $offset=0,$limit=100){
		$memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
		$query = array('currentStatus'=>self::$status['REVIEW'],'author._id'=>$memberId);
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('reviewDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				$result[$i]['currentType'] = self::$typeReversed[$result[$i]['currentType']];
			}
		endif;
		return $result;

	}
	public function fetchByAuthorByApproved($memberId, $offset=0,$limit=100){
		$memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
		$query = array('author._id'=>$memberId, 'currentStatus'=>array('$gte'=>self::$status['SCHEDULE']));
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('scheduleDate.date'=>-1,'publishDate.date'=>-1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
				$result[$i]['currentType'] = self::$typeReversed[$result[$i]['currentType']];
			}
		endif;
		return $result;

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

    	// purge comments
    	self::$app['mongo']->remove(array('belongsTo'=>$this->_id), 'comment', $justOne=false, $options=array('fsync'=>true));

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
	public static function getAvailableTags(Application $app){
		$category = new Category(array('currentType'=>Category::$type['BLOG']),$app);
		$tags = $category->fetchByTypeFormatted();
		return $tags;
		
		//return array('Breath Testing', 'Blood Testing', 'Boating Under the Influence','FAA Issues','Public Policy','Interstate Compact', 'Field Sobriety Tests', 'Drug Dui (DRE)', 'Constitutional Issues', 'Forensic Science', 'Evidence', 'Ethics', 'Recent Case Law');
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