<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * TimeZone model.  Belongs to Offer and can belong to User but also has it's own collection
 * provides the time zone name and lat+lon for the city.  Used to pull
 * abbreviation (EST, DST, etc.) and UTC offset using PHP.
 */
class TimeZone extends Model {
	
	public $collection = 'timezone';
	public $name;
	public $point;
	public $offset;
	public $abbrev;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
	}
	
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->name = $doc['name'];
		$this->point = $doc['point'];
		$this->offset = $doc['offset'];
		$this->abbrev = $doc['abbrev'];
	}
	
	public function getNear($lon, $lat, $maxDistance=1000){
        $query = array();        
        $fields = array('name','abbrev');
        $results = self::$app['mongo']->findNear($this->collection, 'point', $lon, $lat, $maxDistance, $unit='miles', $query, $fields, $slaveOkay=true, $offset=0, $limit=0, $sort=array('name'=>1));
        if(!empty($results)) {
			return $results;
        }else{
			return false;
		}
		
	}
	public function getByOffset(){
		
		$query=array('offset'=>(int)$this->offset);
		$fields=array('name','abbrev');
		$slaveOkay=true;
		$sort=array();
		$result = self::$app['mongo']->find($this->collection, $query,$fields,$slaveOkay,$offset=0,$limit=1000,$sort);
		
		if(!empty($result)):
			return $result;
		else:
			return false;
		endif;
		
	}
	public function getAll(){
		
		$query=array();
		$fields=array('name','point','abbrev','offset');
		$slaveOkay=true;
		$sort=array();
		
		$result = self::$app['mongo']->find($this->collection, $query,$fields,$slaveOkay,$offset=0,$limit=1000,$sort);
		
		if(!empty($result)):
			return $result;
		else:
			return false;
		endif;
		
	}
	
	/** 
	 * This is really only to refresh if the list changes based on a new version of php
	**/
	public function rebuild(){
		// remove all the current time zone records first
		self::$app['mongo']->remove($criteria=array(), $this->collection, $justOne=false, $options=array('safe'=>true,'fsync'=>true));
		//*
		// prepare to add refreshed ones
		$identifiers = \DateTimeZone::listIdentifiers();
		$loc_info = array();
		foreach ($identifiers as $name):
			try {
				$tz = new \DateTimeZone($name);
				$loc_info = $tz->getLocation();
				
				$date = new \DateTime("now", $tz);
				$offset = $tz->getOffset($date);
				$abbrev = $date->format('T');
				
			} catch (Exception $e) {
				//continue
			}
			if(!empty($loc_info['latitude'])):
				$timezones[] = $timezone = array(
					'name'=>$name,
					'offset'=>$offset,
					'abbrev'=>$abbrev,
					'point'=>array(
					'lon'=>$loc_info['longitude'],
					'lat'=>$loc_info['latitude'])
				);
			endif;

		endforeach;

		foreach($timezones as $timezone):
			$response = self::$app['mongo']->update($timezone, 
													$this->collection, 
													$criteria=array('name'=>$timezone['name']), 
													$multiple=false, 
													$upsert=true, 
													$options=array('fsync'=>true));
		endforeach;
		//*/
	}
	public function getAttributes(){
		$result = $this->find($query=array('name'=>$this->name),$fields=array('name','abbrev','offset','point'));
		if(!empty($result)):
			$timezone['name'] 	= $result[0]['name'];
			$timezone['abbrev'] = $result[0]['abbrev'];
			$timezone['offset'] = $result[0]['offset'];
			$timezone['point'] 	= $result[0]['point'];
			return $timezone;
		else:
			return false;
		endif;
		
	}
	public function getAbbreviation($name){
		$dateTimeZone = new \DateTimeZone($name);
		$dateTime = new \DateTime("now", $dateTimeZone);
		return $dateTime->format('T');
	}
	
	public function getOffset($name){
		$dateTimeZone = new \DateTimeZone($name);
		$date = new \DateTime("now", $dateTimeZone);
		return $dateTimeZone->getOffset($date);
	}
	
}