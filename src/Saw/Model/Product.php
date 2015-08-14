<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * Product Model.
 * This class serves the Product collection for the ncdd store.
 */
class Product extends Model {
	
	public $collection = 'product';
	static public $status = array('UNPUBLISH'=>30,'MEMBERSONLY'=>40,'PUBLISH'=>50);
	static public $statusReversed = array(30=>'UNPUBLISH', 40=>'MEMBERSONLY', 50=>'PUBLISH');
	public $currentStatus;
	public $name;
	public $description;
	public $price;
	public $memberPrice;
	public $shippingPrice;
	public $purchaseInstructions;
	public $image;
	public $category;
	public $slug;
	// 
	public $add; // for designating which upsert is happening the insert or the update
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('name', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('price', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('memberPrice', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('shippingPrice', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('description', new Constraints\NotBlank(array('message'=>'cannot be blank')));
    	$metadata->addPropertyConstraint('slug', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('isValidSlug'),
        )));
        $metadata->addConstraint(new Callback(array(
            'methods' => array('isValidPrice'),
        )));
        
	}
	public function isValidSlug(ExecutionContext $context){
	
		$result = $this->findOne($query=array('slug'=>$this->slug),$fields=array(),$slaveOkay=true);
		if(!empty($result) && $result['_id'] != $this->_id){
			$propertyPath = $context->getPropertyPath().'slug';
        	$context->addViolationAtPath($propertyPath,'This URL already exists in the system.  Please change your Headline slightly to produce a more unique URL.', array(), null);
        }
	}
	public function isValidPrice(ExecutionContext $context){
		
		if(strpos($this->price, '$') !== false){
			$this->price = str_replace('$','',$this->price);
		}
		if(!is_numeric($this->price)){
			$propertyPath = $context->getPropertyPath().'price';
        	$context->addViolationAtPath($propertyPath,'This field only accepts numbers.', array(), null);
        }
        if((float)$this->price <= 0){
			$propertyPath = $context->getPropertyPath().'price';
        	$context->addViolationAtPath($propertyPath,'Must be greater than zero.', array(), null);
        }

        if(strpos($this->memberPrice, '$') !== false){
			$this->memberPrice = str_replace('$','',$this->memberPrice);
		}
		if(!is_numeric($this->memberPrice)){
			$propertyPath = $context->getPropertyPath().'memberPrice';
        	$context->addViolationAtPath($propertyPath,'This field only accepts numbers.', array(), null);
        }
        if((float)$this->memberPrice <= 0){
			$propertyPath = $context->getPropertyPath().'memberPrice';
        	$context->addViolationAtPath($propertyPath,'Must be greater than zero.', array(), null);
        }

        if(strpos($this->shippingPrice, '$') !== false){
			$this->shippingPrice = str_replace('$','',$this->shippingPrice);
		}
		if(!is_numeric($this->shippingPrice)){
			$propertyPath = $context->getPropertyPath().'shippingPrice';
        	$context->addViolationAtPath($propertyPath,'This field only accepts numbers.', array(), null);
        }
        if((float)$this->shippingPrice <= 0){
			$propertyPath = $context->getPropertyPath().'shippingPrice';
        	$context->addViolationAtPath($propertyPath,'Must be greater than zero.', array(), null);
        }
	}
	public function __construct($doc, Application $app, $author=array()){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
      
		$this->name = $doc['name'];
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->description = (!empty($doc['description'])) ? wptexturize(wpautop($doc['description'])) : '';
		$this->price = $doc['price'];
		$this->shippingPrice = $doc['shippingPrice'];
		$this->memberPrice = $doc['memberPrice'];
		$this->purchaseInstructions = $doc['purchaseInstructions'];
		$this->image = $doc['image'];
		$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];
		
		if(!empty($doc['category'])){
			if (is_object($doc['category'])){
				$this->category = $doc['category']->__toArray();
			}
			if (is_array($doc['category'])){
				$this->category = $doc['category'];
			}
			if (is_string($doc['category']) && preg_match('/^[0-9a-z]{24}$/',$doc['category'])){
				$category = new Category(array('_id'=>$doc['category']),$app);
				$category->findById();
				$this->category = $category;	
			}
			
		}else{
			$this->category = $doc['category'];
		}
		$this->add = $doc['add'];
		$this->slug = (empty($doc['slug']) && !empty($doc['name'])) ? self::slugify($doc['name']): $doc['slug'];
		$this->slug = ($this->slug[0] != '/') ? '/'.$this->slug: $this->slug;
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['UNPUBLISH'];
		$this->name = $this->name ?: '';
		$this->slug = $this->slug ?: '';
		$this->description = $this->description ?: '';
		$this->image = $this->image ?: new \stdClass();
		$this->price = $this->price ?: 0;
		$this->memberPrice= $this->memberPrice ?: 0;
		$this->shippingPrice = $this->shippingPrice ?: 0;
		$this->purchaseInstructions = $this->purchaseInstructions ?: '';
		$this->add = $this->add ?: 'yes';
		$this->category = $this->category ?: new \stdClass();

	}
	public function saveEdit(){
		$this->price = (float)$this->price;
		$this->shippingPrice = (float)$this->shippingPrice;
		$this->memberPrice = (float)$this->memberPrice;
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
	public function fetchByStatus($status='', $offset=0,$limit=100){
		$query = (!empty($status)) ? array('currentStatus'=>self::$status[$status]): array();
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('name'=>1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function fetchByCategory($category='', $offset=0,$limit=100){
		if(!empty($category)) $category = (is_object($category)) ? $category : new \MongoId($category);
		$query = (!empty($category)) ? array('category._id'=>$category,'currentStatus'=>array('$gte'=>self::$status['MEMBERSONLY'])): array();
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('name'=>-1),(int)$offset,(int)$limit);
		return $result;

	}
	public static function getAvailableCategories(Application $app){
		$category = new Category(array('currentType'=>Category::$type['STORE']),$app);
		$categories = $category->fetchByTypeFormatted();
		return $categories;
		//return array('NCDD Bookstore', 'Trial Graphics', 'NCDD Logo Merchandise');
	}

	public function search($string){

		$fields = array();// get all fields
		$result = array();
		$search_arr = explode(' ', $string);
		if(is_array($search_arr)){
			$regex = '/^';
			foreach ($search_arr as $key) {
				$regex .= '.*?\b'.addslashes($key).'\b';
			}
			$regex.= '.*?$/im';

			$regex = new \MongoRegex($regex);
			$result = $this->find($query=array('description'=>$regex),$fields,true,$sort=array('name'=>1),$offset=0,$limit=3000);		
			
		}
		return $result;
	}
	public function searchName($string){

		$fields = array();// get all fields
		$result = array();
		$search_arr = explode(' ', $string);
		if(is_array($search_arr)){
			$regex = '/^';
			foreach ($search_arr as $key) {
				$regex .= '.*?\b'.addslashes($key).'\b';
			}
			$regex.= '.*?$/im';

			$regex = new \MongoRegex($regex);
			$result = $this->find($query=array('name'=>$regex),$fields,true,$sort=array('name'=>1),$offset=0,$limit=3000);		
			
		}
		return $result;
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

		// delete record
    	$this->remove();

    	// delete images
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

		// delete drive files
		$drive = new Drive(array('belongsTo'=>$this->_id),self::$app);
		$drive->deleteAll();
	}
	
}