<?php
namespace Saw\Provider\Utility;

use Silex\Application;

class Utility
{
	
	private $app = null;
	
	public function __construct(Application $app=null){
		$this->app = $app;
		
	}
	
	/**
	* @param fulltimeago true will output something like this: 1 minute ago
	* @param fulltimeago false will output something like this: 1 year, 1 month, 1 day, 2 minutes, and 46 seconds ago
	* @param from can be unix time stamp or human readable; can also be a time in the future and out will be "from now" instead of "ago".
	* @param to can be left null
	*/
	public function timeAgo($from, $to = null, $fulltimeago = false){
		$output = null;
		$to = (($to === null) ? (time()) : ($to));
		$to = ((is_int($to)) ? ($to) : (strtotime($to)));
		$from = ((is_int($from)) ? ($from) : (strtotime($from)));

		$units = array
		(
		"year"   => 29030400, // seconds in a year   (12 months)
		"month"  => 2419200,  // seconds in a month  (4 weeks)
		"week"   => 604800,   // seconds in a week   (7 days)
		"day"    => 86400,    // seconds in a day    (24 hours)
		"hour"   => 3600,     // seconds in an hour  (60 minutes)
		"minute" => 60,       // seconds in a minute (60 seconds)
		"second" => 1         // 1 second
		);

		$diff = abs($from - $to);
		$suffix = (($from > $to) ? ("from now") : ("ago"));
		foreach($units as $unit => $mult){
			if($diff >= $mult){
				$and = (($mult != 1) ? ("") : ("and "));
					if($fulltimeago)
					$output .= ", ".$and.intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
					else{
					$output = ", ".$and.intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
					break;
					}
				$diff -= intval($diff / $mult) * $mult;
			}
		}
		$output .= " ".$suffix;
		if($fulltimeago)
			$output = substr($output, strlen(", "));
		else
			$output = substr($output, strlen(", ".$and));
		
		return $output;
	 }
	
	/**
	 * obfuscate query string parameters
	 */
	public static function compressCrypt($string) {
	        return base64_encode(gzcompress($string));
	}
	/**
	 * un-obfuscate query string parameters
	 */
	public static function decompressCrypt($string) {
	        return gzuncompress(base64_decode($string));
	}
	
	
	
	// pass in any number and it will generate
	// a Luhn number.  This is used for invoice numbers
	// iterations makes the number longer because it
	// passes the number through that many interations
	// and compounds the checksum.
	public function generateLuhn ($number, $iterations=5){
		while ($iterations-- >= 1)
	    {
	        $stack = 0;
	        $number = str_split(strrev($number), 1);

	        foreach ($number as $key => $value)
	        {
		        if ($key % 2 == 0)
		        {
		        	$value = array_sum(str_split($value * 2, 1));
		        }

		        $stack += $value;
	        }

	        $stack %= 10;

	        if ($stack != 0)
	        {
	        	$stack -= 10;
	        }

	        $number = implode('', array_reverse($number)) . abs($stack);
	    }

	    return $number;
	}
	// validates that a number created by generateLuhn is 
	// indeed a Luhn checksum
	public function verifyLuhn ($number, $iterations=5){

		$result = substr($number, 0, - $iterations);

	    if ($this->generateLuhn($result, $iterations) == $number)
	    {
	        return $result;
	    }

	    return false;
	}
}