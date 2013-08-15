<?php
/* clear the database: 
db.image.files.remove();db.image.chunks.remove();db.consumer.remove();db.contact.remove();db.device.remove();db.flagoffer.remove();db.grape.remove();db.invoice.remove();db.merchant.remove();db.mydeal.remove();db.notification.remove();db.offer.remove();db.profile.remove();db.redemption.remove();db.review.remove();db.session.remove();db.shortcode.remove();
*/
namespace Saw\Model;

use Silex\Application;

/**
 * Base model which all models extend.
 * Primarily handles the sleep and wake-up magic for storing
 * and retrieving objects from the mongo store
 */
class Model {
	
	public $_id;
	public static $invalidFieldsMessage = "Some fields were invalid. Please correct and re-try.";
	static $app;
	
	public function __construct(Application $app=null){
		// intention to de-couple silex from the model class.
		if(!empty($app)){
			self::$app = $app;
		}else{
			self::$app['mongo'] = new \Saw\Provider\Store\Mongo\MongoWrapper();
		}
		
	}
	
	public function init(&$doc){
		$properties = get_object_vars($this);
		$doc = array_merge($properties,$doc);
	}
	public function __toArray($noid=true){
		$doc = get_object_vars($this);
		
		// remove the _id value otherwise save will fail because you can't update an _id
		// some models want the _id removed because there's no need for it when they don't
		// get saved to their own collection..meaning they are nested documents.
		if($noid)
			$doc = array_diff_key($doc, array('_id'=>'someid'));
		return $doc;
	}
	
    public function upsert(){
        if(!empty($this->_id)) {
            $id = false;
            if($this->saveSafe()) {
                $id = $this->_id;
            }
        }
        else {
            $id = $this->insert();
        }
        return $id;
    }
    public function trueUpsert($criteria){
		// remove empty values so as to not overwrite anything
		$obj_arr = $this->__toArray();
		foreach ($obj_arr as $key => $value) {
			if(!empty($value)){
				$doc[$key]=$value;
			}
			if($value === 0){
				$doc[$key]=$value;
			}
			if(is_array($value) && empty($value)){
				$doc[$key]=array();	
			}
		}
		$response = self::$app['mongo']->update($doc, $this->collection, $criteria, $multiple=false, $upsert=true, $options=array('safe'=>true,'fsync'=>true));
		//error_log('response:'.print_r($response,true));
		if(is_array($response)){
			if(!$response['ok']){
				error_log('true upsert failed:'.print_r($response));
				return false;
			}
			if(array_key_exists('upserted',$response) && !empty($response['upserted'])){
				$this->_id = $response['upserted'];
				return true;
			}
			if(array_key_exists('updatedExisting',$response) && $response['updatedExisting']){
				// good chance we don't know or need the _id of the record updated.
				return $response['n']; // number of objects affected.
			}
		}
		return true;
	}
	public function insert(){
		$doc = $this->__toArray();
		
		$insert_id = self::$app['mongo']->insert($doc,
												 $this->collection, 
												 array('fsync'=>true) // fsync true writes to disk.
												);
		if($insert_id):
			$this->_id = $insert_id;
			return $insert_id;
		else:
			return false;
		endif;
		
	}
	
	/**
	 * Model::_id must be set in order for this 
	 * to attempt an atomic save on all non empty 
	 * properties
	 */
	public function saveSafe(){
        $options = array(
                'safe' => true,
                'fsync' => true
            );
        if(!$this->save($options)){
        	throw new \Saw\Model\Exceptions\DomainException("Saving failed.  Please try again.");
        }
        return true;
	}       
    
	/**
	 * Model::_id must be set in order for this 
	 * to attempt an atomic save on all non empty 
	 * properties
	 */
	public function save($options=array()){
		if(!empty($this->_id)):
			// remove empty values so as to not overwrite anything
			$obj_arr = $this->__toArray();
			foreach ($obj_arr as $key => $value) {
				if(!empty($value)){
					$doc[$key]=$value;
				}
				if($value === 0){
					$doc[$key]=$value;
				}
				if(is_array($value) && empty($value)){
					$doc[$key]=array();	
				}
			}
			$document = array('$set' => $doc);
			$criteria = array('_id'=>$this->_id);
			//error_log('document:'.print_r($document,true));
			//error_log('criteria:'.print_r($criteria,true));
			$result = self::$app['mongo']->update($document, $this->collection, $criteria, $multiple=false, $upsert=false, $options);
		    return $result;
		else:
			return false;
		endif;
	} 
    
	public function remove(){
		return self::$app['mongo']->deleteById(array('_id'=>$this->_id), $this->collection);
	}
	public function removeByCriteria($criteria){
		return self::$app['mongo']->remove($criteria, $this->collection, $justOne=false, $options=array('fsync'=>true));
		return false;
	}
	public function updateByCriteria($document, $criteria){
		return self::$app['mongo']->update($document, $this->collection, $criteria, $multiple=true, $upsert=false, $options=array('fsync'=>true));
		return false;
	}
	public function findById($id='_id', $slaveOkay=true){
		$query = array($id=>$this->$id);
		$result = self::$app['mongo']->findOne($this->collection, $query, $fields=array(),$slaveOkay);
		if(!empty($result)):
			// late static binding
			static::__construct($result,Model::$app);//calling __construct of the class that was instantiated not __construct of this class Model
			return $result;
		else:
			return false;
		endif;
	}
	
	// a convenience query to find records in the model 
	public function find($query=array(),$fields=array(),$slaveOkay=true,$sort=array(),$offset=0,$limit=100){
		
		$result = self::$app['mongo']->find($this->collection, $query,$fields,$slaveOkay,$offset,$limit,$sort);
		
		if(!empty($result)):
			return $result;
		else:
			return false;
		endif;
	}
	// a convenience query to find one record in the model 
	public function findOne($query=array(),$fields=array(),$slaveOkay=true){
		
		$result = self::$app['mongo']->findOne($this->collection, $query,$fields,$slaveOkay);
		
		if(!empty($result)):
			return $result;
		else:
			return false;
		endif;
	}
	
	public function count($query=array(),$slaveOkay=true){

		return self::$app['mongo']->count($query,$this->collection,$slaveOkay);
		
	}
	public function distinct($key, $query=array()){

		return self::$app['mongo']->distinct($this->collection, $key, $query);
		
	}
	public function createSlug($string){
		
		return $this->toAscii($string);
		
	}
	
	public function toAscii($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
		
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}
	
	public static function getQR($app,$query,$collection) {
		$fields = array('QR');
        return $app['mongo']->findOne($collection,$query,$fields,$slaveOkay=true);
    }
}