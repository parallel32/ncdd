<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Comment model.  Used by blog and forum.
 */
class Comment extends Model {
	
    public $collection = 'comment';
    public $comment;
	public $belongsTo; // the _id of either blog or forum
	public $author;  // document with member._id, member.displayName, member.image
	static public $type = array('PUBLIC'=>10,'PRIVATE'=>20);
	static public $typeReversed = array(10=>'PUBLIC',20=>'PRIVATE');
	public $currentType;
	public $replies; // array of comment documents
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('comment', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('belongsTo', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->comment = $doc['comment'];
        $this->currentType = $doc['currentType'];
		$this->replies = $doc['replies'];
		$this->belongsTo = (!empty($doc['belongsTo'])) ? (is_object($doc['belongsTo'])) ? $doc['belongsTo'] : new \MongoId($doc['belongsTo']) : $doc['belongsTo'];
		$this->author = (is_object($doc['author'])) ? $doc['author']->__toArray(false) : $doc['author'];

	}
	protected function prepareInsert(){
		$this->comment = $this->comment ?: '';
		$this->currentType = $this->currentType ?: self::$type['PRIVATE'];
		$this->replies = $this->replies ?: array();
		$this->belongsTo = (!empty($this->belongsTo)) ? (is_object($this->belongsTo)) ? $this->belongsTo : new \MongoId($this->belongsTo) : new \stdClass();
		
		$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},self::$app);
		if($user['accessLevel'] >= EDITOR){
			$this->author = new \stdClass();
		}else{
			$author = new Member(array('_id'=>$user['user_id']),self::$app);
			$author = $author->findById();
			$memberLite = new MemberLite($author,self::$app);
			$this->author = $memberLite;
		}
		
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function reply($replyTo, $doc){
		
		$doc['_id'] = new \MongodId();
		$comment = new Comment($doc,self::$app);

		$criteria = array('_id'=>$replyTo);
		$update_spec = array('$addToSet'=>array('replies'=>$comment));
		self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
		return $comment->__toArray(false);

	}
	public function fetchByBelongsTo($offset=0,$limit=1000){
        $fields = array();
		$comments = $this->find($query=array('belongsTo'=>$this->belongsTo),$fields,$slaveOkay=true,$sort=array('_id'=>-1),$offset,$limit);
		if(!empty($comments)){
			$i=0;
			foreach ($comments as $comment) {
				// if older than 28 days show date instead of timeAgo
				$comments[$i]['timeAgo'] = ($comment['_id']->getTimestamp() > 2419200) ? date('j M, Y',$comment['_id']->getTimestamp()) : self::$app['utility']->timeAgo($comment['_id']->getTimestamp());
				if(is_array($comment['replies']) && !empty($comment['replies'])){
					//re-organize replies as _id indexed array to use ksort
					$replies = array();
					foreach($comment['replies'] as $reply){
						$replies[$reply['_id']] = $reply;
						$replies['timeAgo'] = ($reply['_id']->getTimestamp() > 2419200) ? date('j M, Y',$reply['_id']->getTimestamp()) : self::$app['utility']->timeAgo($reply['_id']->getTimestamp());
					}
					ksort($replies);//should sort ascending
					$comments[$i]['replies'] = $replies;
				}
				$i++;
			}
		}

		return $comments;
	}
	public function updateAuthor($member){
		$doc = array('$set'=>array('author'=>$member));
		$criteria = array('author._id'=>$member['_id']);
		return $this->updateByCriteria($doc, $criteria);
	}
	    
}
