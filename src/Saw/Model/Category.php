<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

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
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->name = $doc['name'];
        $this->image = $doc['image'];
        $this->currentType = $doc['currentType'];
        $this->add = $doc['add'];
	
	}
	protected function prepareInsert(){
		$this->name = $this->name ?: '';
		$this->image = $this->image ?: new \stdClass();
		$this->currentType = $this->currentType ?: self::$type['BLOG'];
		$this->add = $this->add ?: 'yes';
		
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
	
	public function delete(){

		// delete topic
    	$this->remove();

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
		    
}
