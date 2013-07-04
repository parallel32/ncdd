<?php
namespace Saw\Model;

use Silex\Application;

/**
 * Date model. Not a data object. Designed to prepare a 
 * consistent date object for a data model that stores a 
 * MongoDate
 */
class Date {

	public $date;
	public $checkError;
	public $feed;
	public $detail;
	public $fullMonth;
	public $shortMonth;
	public $dayOfWeek;
	public $shortDayOfWeek;
	public $european;
	public $europeanFullMonth;
	public $europeanShortMonth;
	public $shortTime;
	public $longTime;
	public $militaryTime;
	public $timezone;
	
	
	public function __construct(Application $app, $date, $timezone=array()){
		$this->date = (!empty($date) && !is_object($date) && !is_array($date)) ? new \MongoDate(strtotime($date)) : $date; // the else here assumes it's already a MongoDate
		if(!empty($timezone)){
			$this->timezone = $timezone; // this is an array of TimeZone object via its getAttributes() method.
			$tz = new \DateTimeZone($this->timezone['name']);
			try {
				$date = new \DateTime($date, $tz);
			} catch (\Exception $e) {
				$date = new \DateTime('1969-12-31');//known to produce a date like this: 1969-12-31 (this will invoke the validator and send back an error)
			}
			
		}else{
			try {
				$date = new \DateTime($date);
			} catch (\Exception $e) {
				$date = new \DateTime('1969-12-31');//known to produce a date like this: 1969-12-31 (this will invoke the validator and send back an error)
			}
		}
		$this->checkError = $date->format('Y-m-d');
		$this->feed = $date->format('n/j/Y');
		$this->detail = $date->format('n/j/Y');
		$this->fullMonth = $date->format('F j, Y');
		$this->shortMonth = $date->format('M j, Y');
		$this->dayOfWeek = $date->format('l');
		$this->shortDayOfWeek = $date->format('D');
		$this->european = $date->format('j/n/Y');
		$this->europeanFullMonth = $date->format('j F, Y');
		$this->europeanShortMonth = $date->format('j M, Y');
		$this->shortTime = $date->format('g:i a');
		$this->longTime = $date->format('h:i A');
		$this->militaryTime = $date->format('H:i');
	}
	public function __toArray(){
		$doc = get_object_vars($this);
		return $doc;
	}
}