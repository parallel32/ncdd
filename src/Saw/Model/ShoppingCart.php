<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * ShoppingCart Model.
 * This class serves the ShoppingCart collection.  It works in conjunction with the Order collection
 * during the check out process the shopping cart is embedded into the Order as the order details
 * the Order model handles the purging of the cart and email notifications (one to admin for order fulfillment and one to the customer as the receipt)
 */
class ShoppingCart extends Model {
	
	public $collection = 'shoppingcart';
	static public $status = array('ACTIVE'=>10,'PURGEREADY'=>20);
	static public $statusReversed = array(10=>'ACTIVE',20=>'PURGEREADY');
	public $currentStatus;
	public $sessionId; 
	public $member;  // the memberLite object (if it's a signed in member purchasing otherwise this will always be blank)
	public $products; // an array of ProductOrder collections
	public $add;
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
      
		$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];
		$this->member = (is_object($doc['member'])) ? $$doc['member']->__toArray(false) : $doc['member'];
		$this->sessionId = $doc['sessionId'];
		$this->products = $doc['products'];
		$this->add = $doc['add'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['ACTIVE'];
		$this->member = $this->member ?: new \stdClass();
		$this->sessionId = $this->sessionId ?: array();
		$this->products = $this->products ?: array();
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
	public function updateProductQuantity($productId, $quantity){
		if(!empty($productId)) $productId = (is_object($productId)) ? $productId : new \MongoId($productId);

		$criteria = array('products._id'=>$productId);
		$update_spec = array('$set'=>array('products'=>array('products.$.quantity'=>$quantity)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));

	}	
	public function removeProduct($productId){
		if(!empty($productId)) $productId = (is_object($productId)) ? $productId : new \MongoId($productId);
		// mongo atomic pull from the array
		$criteria = array('products._id'=>$productId);
		$update_spec = array('$pull'=>array('products'=>array('_id'=>$productId)));
		return self::$app['mongo']->update($update_spec, $this->collection, $criteria, $multiple=false, $upsert=false,$options=array('safe'=>true,'fsync'=>true));
	}
	
	public function fetchByStatus($status='ACTIVE',$offset=0,$limit=10000){
		
		$query = array('_id'=>$this->_id,'currentStatus'=>self::$status[$status]);		
		$fields = array();
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array('products.name'=>1),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['currentStatus'] = self::$statusReversed[$result[$i]['currentStatus']];
			}
		endif;
		return $result;

	}
	public function delete(){

		// delete topic
    	$this->remove();

    
	}
	
}