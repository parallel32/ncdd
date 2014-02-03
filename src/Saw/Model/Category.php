<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;

/**
 * Comment model.  Used by blog and forum.
 */
class Category extends Model {
	
    public $collection = 'category';
    public $name;
    public $image;
	static public $type = array('BLOG'=>10,'STORE'=>20);
	static public $typeReversed = array(10=>'BLOG',20=>'STORE');
	public $currentType;
	public $add;
	public $slug;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('slug', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidSlug'),
        )));
	}
	public function isValidSlug(ExecutionContext $context){
	
		$result = $this->findOne($query=array('slug'=>$this->slug),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['_id'] != $this->_id){
			$propertyPath = $context->getPropertyPath().'slug';
        	$context->addViolationAtPath($propertyPath,'This URL already exists in the system.  Please change your Category Name slightly to produce a more unique URL.', array(), null);
        }
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->name = $doc['name'];
        $this->image = $doc['image'];
        $this->currentType = $doc['currentType'];
        $this->add = $doc['add'];
		$this->slug = (empty($doc['slug']) && !empty($doc['name'])) ? self::slugify($doc['name']): $doc['slug'];
	}
	protected function prepareInsert(){
		$this->name = $this->name ?: '';
		$this->image = $this->image ?: new \stdClass();
		$this->currentType = $this->currentType ?: self::$type['BLOG'];
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
	public function fetchByType($offset=0,$limit=1000){
        $fields = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('name'=>1),$offset,$limit);
		return $categories;
	}
	public function fetchByTypeFormatted($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('name'=>1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $category):
				$cat[$category['_id']->__toString()] = $category['name'];
			endforeach;
			return $cat;
		}else{
			return array();
		}
	}
	public function fetchByTypeFormattedSlug($offset=0,$limit=1000){
        $fields = array();
        $cat = array();
		$categories = $this->find($query=array('currentType'=>$this->currentType),$fields,$slaveOkay=true,$sort=array('name'=>1),$offset,$limit);
		if(!empty($categories)){
			foreach($categories as $category):
				$cat[$category['_id']->__toString()] = array('name'=>$category['name'],'slug'=>$category['slug']);
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
