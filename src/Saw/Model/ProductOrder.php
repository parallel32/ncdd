<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * ProductOrder model.  
 * lightweight version and order specific version of the Product model
 */
class ProductOrder extends Model {

	public $_id;
	public $name;
	public $description;
	public $price;
	public $memberPrice;
	public $shippingPrice;
	public $purchaseInstructions;
	public $image;
	public $category;
	public $slug;
	public $quantity;
	public $preference;

	static public function loadValidatorMetadata(ClassMetadata $metadata){
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->_id = (!is_object($doc['_id'])) ? new \MongoId($doc['_id']) : $doc['_id'];
		$this->name = $doc['name'];
		$this->description = $doc['description'];
		$this->price = $doc['price'];
		$this->shippingPrice = $doc['shippingPrice'];
		$this->memberPrice = $doc['memberPrice'];
		$this->purchaseInstructions = $doc['purchaseInstructions'];
		$this->image = $doc['image'];
		$this->category = $doc['category'];
		$this->slug = $doc['slug'];
		$this->slug = ($this->slug[0] != '/') ? '/'.$this->slug: $this->slug;
		$this->quantity = $doc['quantity'];
		$this->preference = $doc['preference'];	
	}
	
}