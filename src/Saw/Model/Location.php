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
	public $primary; // 11 = primary address, 22 = not primary address
	
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
            array('message'=>'A state or province is required.','groups'=>array('ps'))
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
		$this->point = (is_array($doc['point']) && !empty($doc['point'][0])) ? array((float)$doc['point'][0], (float)$doc['point'][1]) : '';
		$this->addressLine1 = $doc['addressLine1'];
        $this->addressLine2 = $doc['addressLine2'];
		$this->city = $doc['city'];
		$this->state = $doc['state'];
        $this->zip = (string)$doc['zip'];
        $this->country = $doc['country'];
		$this->phone = $doc['phone'];
		$this->fax = $doc['fax'];
		$this->tollFree = $doc['tollFree'];
		$this->hours = $doc['hours'];
		$this->ownerId = (!empty($doc['ownerId'])) ? (is_object($doc['ownerId'])) ? $doc['ownerId'] : new \MongoId($doc['ownerId']) : $doc['ownerId'];
		$this->member = (is_object($member)) ? $member->__toArray(false) : $doc['member'];
		$this->primary = $doc['primary'];

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
		$this->primary = $this->primary ?: 22;
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
		$locs = $this->find($query=array('ownerId'=>$this->ownerId),$fields,$slaveOkay=false,$sort=array('_id'=>-1),$offset,$limit);
		$new_locs = array();
		for ($i=0; $i < count($locs); $i++) { 
			if(!empty($locs[$i]['addressLine1']) && !empty($locs[$i]['city'])):
				$new_locs[] = $locs[$i];
			endif;
		}
		return $new_locs;
	}
	public function getByMemberId($offset=0,$limit=100){
		if(!empty($this->member['_id'])) $this->member['_id'] = (is_object($this->member['_id'])) ? $this->member['_id'] : new \MongoId($this->member['_id']);
        $fields = array(); /* Need all fields for locations list table */
		return $this->findOne($query=array('member._id'=>$this->member['_id']),$fields,$slaveOkay=true,$sort=array('_id'=>-1),$offset,$limit);
	}
	public function getPrimary($memberId){
		if(!empty($memberId)) $memberId = (is_object($memberId)) ? $memberId : new \MongoId($memberId);
        $fields = array(); /* Need all fields for locations list table */
		return $this->findOne($query=array('member._id'=>$memberId,'primary'=>11),$fields,$slaveOkay=true,$sort=array('_id'=>-1),$offset=0,$limit=1000);
	}
	public function updateMember($member){
		$doc = array('$set'=>array('member'=>$member));
		$criteria = array('ownerId'=>$this->ownerId);
		return $this->updateByCriteria($doc, $criteria);
	}
	public function setFirstAsPrimary(){
		$locs = $this->getByOwner();
		$doc = array('$set'=>array('primary'=>11));
		$criteria = array('_id'=>$locs[0]['_id']);
		return $this->updateByCriteria($doc, $criteria);

	}
	public function setPrimary(){
		$this->primary = 11;
		$this->saveSafe();
		$this->findById();
		
		$doc = array('$set'=>array('primary'=>22));
		$criteria = array('ownerId'=>$this->member['_id'],'_id'=>array('$nin'=>array($this->_id)));
		return $this->updateByCriteria($doc, $criteria);

	}
	    
}
