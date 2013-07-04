<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Preference model.  Belongs to User.
 * used to default the user's preference structure
 */
class Preference extends Model {
	
	public $feed;
    public $profile;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
	}

	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		if(empty($doc['feed'])):
			// locations are stored as loction objects with the location object's name property as the key of the array
			// the key 'current' is special in that it's always the current location selected by the user.
			// in the case of a previously (manually) specified location there would be the one with it's name as the key
			// and then the same one as the value for the 'current' key
			$feed = array('settings'=>array('locations'=>array('current'=>array()),
							  				'range'=>50),
						  'type'=>'offer',
						  'filter'=>'nearby');
		else:
			$feed = $doc['feed'];
		endif;
		$this->feed = $feed;
        $this->profile = (empty($doc['profile'])) ? array() : $doc['profile'];
	}
	
}