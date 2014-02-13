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
class Order extends Model {
	
	public $collection = 'order';
	static public $status = array('NEW'=>10,'SHIPPED'=>20,'REFUNDED'=>30);
	static public $statusReversed = array(10=>'NEW',20=>'SHIPPED',30=>'REFUNDED');
	public $currentStatus;
	public $payment; // the payment collection
	public $shoppingCart; // the shopping cart array from the session detailing the products and totals
	public $shippingCompany;
	public $trackingNumber;
	public $orderTotal;
	public $shippingTotal;
	public $discountTotal;
	// dates
	public $orderDate;
	public $shipDate;
	public $refundDate;
	public $add; // for designating which upsert is happening the insert or the update
	public $timeZone = 'America/New_York';
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('shippingCompany', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('trackingNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
      
		$this->payment = (is_object($doc['payment'])) ? $doc['payment']->__toArray(false) : $doc['payment'];
		$this->currentStatus = (!empty($doc['currentStatus'])) ? (int)$doc['currentStatus']: $doc['currentStatus'];
		$this->orderDate = $doc['orderDate'];
		$this->shipDate = $doc['shipDate'];
		$this->refundDate = $doc['refundDate'];
		$this->shoppingCart = $doc['shoppingCart'];
		$this->shippingCompany = $doc['shippingCompany'];
		$this->trackingNumber = $doc['trackingNumber'];
		$this->orderTotal = $doc['orderTotal'];
		$this->shippingTotal = $doc['shippingTotal'];
		$this->discountTotal = $doc['discountTotal'];
		
		$this->setCurrentStatus();

		$this->add = $doc['add'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['NEW'];
		$this->payment = $this->payment ?: new \stdClass();
		$this->shoppingCart = $this->shoppingCart ?: array();
		$this->orderDate = $this->orderDate ?: new Date(self::$app,'now');
		$this->shipDate = $this->shipDate ?: new \stdClass();
		$this->refundDate = $this->refundDate ?: new \stdClass();
		$this->add = $this->add ?: 'yes';
		$this->orderTotal = $this->orderTotal ?: 0;
		$this->shippingTotal = $this->shippingTotal ?: 0;
		$this->discountTotal = $this->discountTotal ?: 0;
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
	private function setCurrentStatus(){
		if(!empty($this->currentStatus)){
			switch (self::$statusReversed[$this->currentStatus]) {
				case 'NEW':
					$this->orderDate = new Date(self::$app,'now');
					break;
				case 'SHIPPED':
					$this->shipDate = new Date(self::$app,'now');
					break;
				case 'REFUNDED':
					$this->refundDate = new Date(self::$app,'now');
					break;
			}
		}
	}
	public function fetchByStatus($status, $offset=0,$limit=10000){
		
		$query = array('currentStatus'=>self::$status[$status]);
		$fields = array();
		switch ($status) {
			case 'NEW':
				$sort=array('orderDate.date'=>-1);
				break;
			case 'SHIPPED':
				$sort=array('shipDate.date'=>-1);
				break;
			case 'REFUNDED':
				$sort=array('refundDate.date'=>-1);
				break;
			
			default:
				$sort=array('_id'=>-1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
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

    	// purge comments
    	//self::$app['mongo']->remove(array('belongsTo'=>$this->_id), 'comment', $justOne=false, $options=array('fsync'=>true));

    }
	
}