<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;

/**
 * StateSeminar model.  Used by blog and store.  Also has tags
 */
class StateSeminar extends Model {
	
    public $collection = 'stateseminar';
    public $name;
    public $sponsor;
    public $cosponsor;
    public $date;
    public $state;
    public $image;
	static public $type = array('STATE'=>10,'COSPONSORED'=>20,'SPONSORED'=>30);
	static public $typeReversed = array(10=>'STATE',20=>'COSPONSORED',30=>'SPONSORED');
	public $currentType;
	public $add;
	public $slug;
	public $timeZone='America/New_York';
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('date', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('sponsor', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('slug', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidSlug'),
        )));
	}
	public function isValidSlug(ExecutionContext $context){
	
		$result = $this->findOne($query=array('slug'=>$this->slug),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['_id'] != $this->_id){
			$propertyPath = $context->getPropertyPath().'slug';
        	$context->addViolationAtPath($propertyPath,'This URL already exists in the system.  Please change your StateSeminar Name slightly to produce a more unique URL.', array(), null);
        }
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->name = $doc['name'];
        $this->sponsor = $doc['sponsor'];
        $this->cosponsor = $doc['cosponsor'];
        $this->date = (!empty($doc['date'])) ? (is_object($doc['date'])) ? $doc['date']->__toArray() : new Date(self::$app,$doc['date'], $this->timeZone)  : $doc['date'];
        $this->image = $doc['image'];
        $this->state = $doc['state'];
        $this->currentType = $doc['currentType'];
        $this->add = $doc['add'];
		$this->slug = (empty($doc['slug']) && !empty($doc['name'])) ? self::slugify($doc['name']): $doc['slug'];
		$this->slug = ($this->slug[0] != '/') ? '/'.$this->slug: $this->slug;
	}
	protected function prepareInsert(){
		$this->name = $this->name ?: '';
		$this->sponsor = $this->sponsor ?: '';
		$this->cosponsor = $this->cosponsor ?: '';
		$this->date = (!empty($this->date)) ? (is_object($this->date)) ? $this->date->__toArray() : $this->date  : new Date(self::$app,'now', $this->timeZone);
		$this->image = $this->image ?: new \stdClass();
		$this->state = $this->state ?: '';
		$this->currentType = $this->currentType ?: self::$type['STATE'];
		$this->add = $this->add ?: 'yes';
		$this->slug = $this->slug ?: '';
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
	public function fetchAll($offset=0,$limit=1000){
        $fields = array();
		$categories = $this->find($query=array(),$fields,$slaveOkay=true,$sort=array('currentType'=>-1,'date.date'=>-1),$offset,$limit);
		return $categories;
	}
	public function fetchSponsored($offset=0,$limit=1000){
        $fields = array();
		$categories = $this->find($query=array('currentType'=>array('$gt'=>self::$type['STATE'])),$fields,$slaveOkay=true,$sort=array('date.date'=>-1),$offset,$limit);
		return $categories;
	}
	public function fetchByType($offset=0,$limit=1000){
        $fields = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('date.date'=>-1),$offset,$limit);
		return $categories;
	}
	public function fetchByTypeFormatted($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('date.date'=>-1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $stateseminar):
				$cat[$stateseminar['_id']->__toString()] = $stateseminar['name'];
			endforeach;
			return $cat;
		}else{
			return array();
		}
	}
	public function fetchByTypeFormattedSlug($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('date.date'=>-1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $stateseminar):
				$cat[$stateseminar['_id']->__toString()] = array('name'=>$stateseminar['name'],'slug'=>$stateseminar['slug']);
			endforeach;
			return $cat;
		}else{
			return array();
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
	public function delete(){

		// delete topic
    	$this->remove();

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
		    
}
