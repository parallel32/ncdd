<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Location model.  Belongs to Member.
 */
class Location extends Model {
	
    public $collection = 'location';
    public $raw;
    public $name;
	public $neighborhood;
	public $point = array();//format must always be array(lon,lat);
	public $addressLine1;
	public $addressLine2;
	public $city;
	public $state;
	public $zip;
	public $country;
	public $phone;
	public $fax;
	public $tollFree;
	public $hours;
	public $ownerId;
	public $member;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		/*$metadata->addPropertyConstraint('point', new Constraints\NotBlank(
            array('message'=>'Enter your full address and press enter.')
        ));*/
        $metadata->addPropertyConstraint('addressLine1', new Constraints\NotBlank(
            array('message'=>'An address is required.')
        ));
        $metadata->addPropertyConstraint('city', new Constraints\NotBlank(
            array('message'=>'A city is required.')
        ));
        $metadata->addPropertyConstraint('state', new Constraints\NotBlank(
            array('message'=>'A state or province is required.')
        ));
	}

	public function __construct($doc, Application $app, $member=array()){
		parent::__construct($app);
		$this->init($doc);
		
		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
        $this->raw = $doc['raw'];
		$this->name = $doc['name'];
		$this->neighborhood = $doc['neighborhood'];
		// logic here is that if the point array was passed in then force the numbers to float (required for mongo's 2D index) otherwise set to an array
		// to maintain a consistent data type
		$this->point = (is_array($doc['point']) && !empty($doc['point'][0])) ? array((float)$doc['point'][0], (float)$doc['point'][1]) : array();
		$this->addressLine1 = $doc['addressLine1'];
        $this->addressLine2 = $doc['addressLine2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
        $this->zip = $doc['zip'];
        $this->country = $doc['country'];
		$this->phone = $doc['phone'];
		$this->fax = $doc['fax'];
		$this->tollFree = $doc['tollFree'];
		$this->hours = $doc['hours'];
		$this->ownerId = (!empty($doc['ownerId'])) ? (is_object($doc['ownerId'])) ? $doc['ownerId'] : new \MongoId($doc['ownerId']) : $doc['ownerId'];
		$this->member = (is_object($member)) ? $member->__toArray(false) : $doc['member'];

	}
	protected function prepareInsert(){
		$this->raw = $this->raw ?: '';
		$this->name = $this->name?: '';
		$this->neighborhood = $this->neighborhood?: '';
		$this->point = (!empty($this->point)) ? $this->point : array() ;
		$this->addressLine1 = $this->addressLine1 ?: '';
        $this->addressLine2 = $this->addressLine2 ?: '';
		$this->city = $this->city ?: '';
		$this->state = $this->state ?: '';
        $this->zip = $this->zip ?: '';
        $this->country = $this->country ?: 'US';
		$this->phone = $this->phone ?: '';
		$this->fax = $this->fax ?: '';
		$this->tollFree = $this->tollFree ?: '';
		$this->hours = $this->hours ?: '';
		$this->ownerId = (!empty($this->ownerId)) ? (is_object($this->ownerId)) ? $this->ownerId : new \MongoId($this->ownerId) : new \stdClass();
		$this->member = $this->member ?: new \StdClass();
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
			return $this->_id;
		}else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function getByOwner($offset=0,$limit=100){
        $fields = array(); /* Need all fields for locations list table */
		return $this->find($query=array('ownerId'=>$this->ownerId),$fields,$slaveOkay=true,$sort=array('_id'=>-1),$offset,$limit);
	}
	public function updateMember($member){
		$doc = array('$set'=>array('member'=>$member));
		$criteria = array('ownerId'=>$this->ownerId);
		return $this->updateByCriteria($doc, $criteria);
	}
	    
}
