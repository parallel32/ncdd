<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Sessions and Seminars Agenda Time Model.
 * Belongs to Agenda and defines the time slots for each agenda day.
 */
class AgendaTime extends Model {
	
	public $timeZone;
	public $date; // a date object that also holds the time.
	public $title; // pre-defined as Agenda Day {day-number}
	public $description;
	public $color; // yellow, green, blue , purple, red, grey
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('date', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('title', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('description', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('color', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->timeZone = $doc['timeZone'];
		$this->date = (!empty($doc['date'])) ? (is_object($doc['date'])) ? $doc['date']->__toArray() : new Date(self::$app,$doc['date'],$this->timeZone)  : $doc['date'];
		$this->title = $doc['title'];
		include_once __DIR__.'/../Provider/WordPress/ncdd-wp-includes.php';
		$this->description = (!empty($doc['description'])) ? wptexturize(wpautop($doc['description'])) : '';
		$this->color = $doc['color'];

	}
	public static function getColors(){
		return array('yellow'=>'yellow'
					,'green'=>'green'
					,'blue'=>'blue'
					,'purple'=>'purple'
					,'red'=>'red'
					,'grey'=>'grey');
	}
	
}