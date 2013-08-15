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
    public $replyTo; // the _id of the parent comment.
	public $belongsTo; // the _id of either blog or forum
	public $author;  // the member who posted it's not just an _id it's a nested member document
	public $postedDate;
	public $private; // yes / no
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('comment', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('belongsTo', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('author', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('postedDate', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		
	}

	public function __construct($doc, Application $app, $author=array()){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->comment = $doc['comment'];
        $this->private = $doc['private'];
		$this->replyTo = (!empty($doc['replyTo'])) ? (is_object($doc['replyTo'])) ? $doc['replyTo'] : new \MongoId($doc['replyTo']) : $doc['replyTo'];
		$this->belongsTo = (!empty($doc['belongsTo'])) ? (is_object($doc['belongsTo'])) ? $doc['belongsTo'] : new \MongoId($doc['belongsTo']) : $doc['belongsTo'];
		$this->author = (is_object($author)) ? $author->__toArray(false) : $doc['author'];

	}
	protected function prepareInsert(){
		$this->comment = $this->comment ?: '';
		$this->private = $this->private ?: 'yes';
		$this->postedDate = $this->postedDate ?: new Date(self::$app,'now');
		$this->replyTo = (!empty($this->replyTo)) ? (is_object($this->replyTo)) ? $this->replyTo : new \MongoId($this->replyTo) : new \stdClass();
		$this->ownerId = (!empty($this->ownerId)) ? (is_object($this->ownerId)) ? $this->ownerId : new \MongoId($this->ownerId) : new \stdClass();
		$this->author = $this->author ?: new \StdClass();
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function getByBelongsTo($offset=0,$limit=100){
        $fields = array();
		return $this->find($query=array('belongsTo'=>$this->belongsTo,'private'=>'yes'),$fields,$slaveOkay=true,$sort=array('_id'=>-1),$offset,$limit);
	}
	public function updateAuthor($member){
		$doc = array('$set'=>array('author'=>$member));
		$criteria = array('author._id'=>$member['_id']);
		return $this->updateByCriteria($doc, $criteria);
	}
	    
}
