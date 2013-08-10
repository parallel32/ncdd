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
	public $monthDay;
	public $iso;
	public $fullDateTime;
	public $fullMonth;
	public $shortMonth;
	public $dayOfWeek;
	public $shortDayOfWeek;
	public $year;
	public $european;
	public $europeanFullMonth;
	public $europeanShortMonth;
	public $shortTimeSlim;
	public $shortTime;
	public $longTime;
	public $militaryTime;
	public $timezone;
	
	
	public function __construct(Application $app, $date, $timezone='America/New_York'){
		$this->date = (!empty($date) && !is_object($date) && !is_array($date)) ? new \MongoDate(strtotime($date)) : $date; // the else here assumes it's already a MongoDate
		$this->timezone = $timezone; // this was an array representation of the TimeZone object via its getAttributes() method.
		$tz = new \DateTimeZone($this->timezone);
		try {
			$date = new \DateTime($date, $tz);
		} catch (\Exception $e) {
			$date = new \DateTime('1969-12-31');//known to produce a date like this: 1969-12-31 (this date is set for Model validator helper functions to check for it so they can invoke bad data)
		}
		$this->checkError = $date->format('Y-m-d');
		$this->feed = $date->format('n/j/Y');
		$this->detail = $date->format('n/j/Y');
		$this->monthDay = $date->format('F j');
		$this->iso = $date->format('c');
		$this->fullDateTime = $date->format('F j, Y h:i A');
		$this->fullMonth = $date->format('F j, Y');
		$this->shortMonth = $date->format('M j, Y');
		$this->dayOfWeek = $date->format('l');
		$this->shortDayOfWeek = $date->format('D');
		$this->year = $date->format('Y');
		$this->european = $date->format('j/n/Y');
		$this->europeanFullMonth = $date->format('j F, Y');
		$this->europeanShortMonth = $date->format('j M, Y');
		$this->shortTimeSlim = $date->format('g:ia');
		$this->shortTime = $date->format('g:i a');
		$this->longTime = $date->format('h:i A');
		$this->militaryTime = $date->format('H:i');
	}
	public function __toArray(){
		$doc = get_object_vars($this);
		return $doc;
	}
}