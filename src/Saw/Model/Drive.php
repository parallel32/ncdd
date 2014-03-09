<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;
use Cocur\Slugify\Slugify;


/**
 * Drive Model.
 * This class serves the Drive collection and serves as a repository 
 * for all file and image uploads to be embedded into content via the rich editor.
 */
class Drive extends Model {
	
	public $collection = 'drive';
	public $belongsTo;
	public $add;
	public $image;
	public $file;


	static public function loadValidatorMetadata(ClassMetadata $metadata){

	}
	public function __construct($doc, Application $app, $owner=array()){
		parent::__construct($app);
		$this->init($doc);

		if(!empty($doc['_id'])) $this->_id = (is_object($doc['_id'])) ? $doc['_id'] : new \MongoId($doc['_id']);
		$this->belongsTo = (!empty($doc['belongsTo'])) ? (is_object($doc['belongsTo'])) ? $doc['belongsTo'] : new \MongoId($doc['belongsTo']) : '';
		$this->image = (empty($doc['image'])) ? new \stdClass() : $doc['image']; // be sure to maintain an empty object in mongo
		$this->file = (empty($doc['file'])) ? new \stdClass() : $doc['file']; // be sure to maintain an empty object in mongo
		$this->add = $doc['add'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		$this->belongsTo = $this->belongsTo ?: new \stdClass();
		$this->image = $this->image ?: new \stdClass();
		$this->file = $this->file ?: new \stdClass();
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

	public function fetchOrderBy($query=array(), $fields=array(), $column='_id', $direction=-1, $offset=0,$limit=1000){
		$result = $this->find($query,$fields,$slaveOkay=true,$sort=array($column=>$direction),(int)$offset,(int)$limit);
		if(!empty($result)):
			for ($i=0; $i < count($result); $i++) { 
				$result[$i]['image'] = (!empty($result[$i]['image'])) ? $result[$i]['image']['urls']['small']['SSLCDN'] : '';
				$result[$i]['originalFileName'] = (!empty($result[$i]['file'])) ? $result[$i]['file']['originalFileName'] : '';
				$result[$i]['file'] = (!empty($result[$i]['file'])) ? $result[$i]['file']['urls']['small']['SSLCDN'] : '';
			}
		endif;
		return $result;
	}
	
	public function delete(){
		// delete
    	$this->remove();
    	// delete binary files
		self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$this->_id));

	}
	
	public function deleteAll(){
		
		// find all first
		$results = $this->find(array('belongsTo'=>$this->belongsTo),array('_id'=>true));
		// delete
    	$this->removeByCriteria(array('belongsTo'=>$this->belongsTo));
    	
    	// delete binary files
    	foreach ($results as $file):
			self::$app['upload-mongo']->deleteByCriteria(array('belongsTo'=>$file['_id']));
		endforeach;

	}
}