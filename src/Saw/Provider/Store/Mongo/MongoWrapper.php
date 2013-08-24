<?php
namespace Saw\Provider\Store\Mongo;

class MongoWrapper
{
	
	private $options = array(
        'replicaSet' => 'default',
		'database' => 'test',
        'servers' => 'localhost:27242',
		'username' => null,
        'password' => null,
		'safe' => false,
		'fsync' => false,
		'timeout' => 5000 //5 seconds
    );
    // stores the connection obj
    private $mongo;
	// stores the mongo database obj
	private $database;
	
	public function __construct()
	{
		$aryServers = explode(",",SAW_DATABASE_MONGO_SERVERS);
        if(count($aryServers) > 1) {
        	$mongo_config['replicaSet'] = SAW_DATABASE_MONGO_REPLICASET;
        }
		
		$mongo_config['database'] = SAW_DATABASE_MONGO_DATABASE;
		$mongo_config['username'] = SAW_DATABASE_MONGO_USERNAME;
		$mongo_config['password'] = SAW_DATABASE_MONGO_PASSWORD;
		$mongo_config['servers'] = SAW_DATABASE_MONGO_SERVERS;
		$mongo_config['safe'] = SAW_DATABASE_MONGO_SAFE;
		$mongo_config['fsync'] = SAW_DATABASE_MONGO_FSYNC;
		$mongo_config['persist'] = 'x';
		$this->options = array_merge($this->options, $mongo_config);
		$this->_init();		
		
	}
	
	protected function _init() {
        
        // ensure they supplied a database
        if (empty($this->options['database'])) {
            throw new \Exception('You must specify a MongoDB database.');
        }
		
        $aryServers = explode(",",$this->options['servers']);
        if(count($aryServers) > 1) {
            $options = array('replicaSet' => $this->options['replicaSet']);
        }
        else {
            $options = array();
        }
		
        // load mongo servers
		$conn_str = 'mongodb://'.$this->options['servers'];
        try {
			$this->mongo = new \MongoClient($conn_str, $options);
		}catch (\Exception $e){
			error_log('new Mongo failed:'.print_r($e->getMessage(),true));
		}
        // load db
        try {
            $this->database = $this->mongo->selectDB($this->options['database']);
            if(count($aryServers) > 1) {
				$this->database->setReadPreference(\MongoClient::RP_PRIMARY_PREFERRED);
			}
        } catch (\Exception $e) {
			new Saw\Exceptions\SawException($e,"Couldn't select the database in MongoWrapper _init(): ".$e->getMessage());
        }
		
    }
	
    /**
 	 * @includeLocs 	set to true if you want the lat/lon to be returned with the distance
	 */
	public function geoNear($collection, $query=array(), $lon, $lat, $range=5, $units='miles',$uniqueDocs=true,$includeLocs=false,$slaveOkay=false){
		//db.runCommand({ geoNear : "offer", near : [-84.36126000000002, 33.7366299], spherical : true, maxDistance : range / earthRadius,uniqueDocs:true,query:{'category.name':'shoes'} })
		$earthRadius = ($units == 'miles') ? 3959 : 6371; // *else km
		try {
			if(!$slaveOkay)
				$this->database->setReadPreference(\MongoClient::RP_PRIMARY);
			else
				$this->database->setReadPreference(\MongoClient::RP_SECONDARY);
				
			$distances = $this->database->command(array('geoNear'=>$collection,
														'near'=>array($lon, $lat),
														'spherical'=>true,
														'maxDistance'=>$range/$earthRadius,
														'uniqueDocs'=>$uniqueDocs,
														'includeLocs'=>$includeLocs,
														'query'=>$query));
			return $distances;
		} catch (Exception $e) {
			error_log(__ClASS__.'::'.__METHOD__.'::error on line '.__LINE__.':'.print_r($e->getMessage(), true));
		}
		
	}
	
	/**
	 * find can be used for near queries also:
	 *
	 * example command line query:
	 * db.offer.find( { 'location.point' : { $nearSphere : [-84.3934115,33.756934] , $maxDistance : 16.3/3959 },'status':{$gte:1} },{status:1,headline:1,shortCode:1,'location.point':1,'location.city':1})
	 *
	 * ref: lat lon calculator http://www.movable-type.co.uk/scripts/latlong.html
	 */
	public function findNear($collection, $geoIndex, $originLon, $originLat, $maxDistance=null, $unit='miles', $query=array(), $fields=array(),$slaveOkay=false,$offset=0,$limit=20,$sort=array()){
		if($unit == 'miles')
			$earthRadius = 3959;
		else
			$earthRadius = 6371; // km
 		
		if(!empty($maxDistance))
			$nearPart = array($geoIndex=>array('$nearSphere'=>array($originLon,$originLat),'$maxDistance'=>$maxDistance/$earthRadius));
		else
			$nearPart = array($geoIndex=>array('$nearSphere'=>array($originLon,$originLat)));
		
		$query = array_merge($query, $nearPart);
		return $this->find($collection, $query, $fields, $slaveOkay, $offset, $limit, $sort,$slaveOkay);
		
	}
    
	/**
	 * find that respects max distance (range) but does not sort by distance
	 */     
	public function findWithin($collection, $geoIndex, $originLon, $originLat, $maxDistance=10000, $unit='miles', $query=array(), $fields=array(),$slaveOkay=false,$offset=0,$limit=20,$sort=array()){
		if($unit == 'miles')
			$earthRadius = 3959;
		else
			$earthRadius = 6371; // km
		
		$nearPart = array($geoIndex=>array('$within'=>array('$centerSphere'=>array(array($originLon,$originLat),$maxDistance/$earthRadius))));
		
		$query = array_merge($query, $nearPart);
		return $this->find($collection, $query, $fields, $slaveOkay, $offset, $limit, $sort,$slaveOkay);		
	}    
    
	public function haversine($originLon, $originLat, $destLon, $destLat, $units='miles'){
		
        $theta = $destLon - $originLon; 
        $dist = sin(deg2rad($destLat)) * sin(deg2rad($originLat)) +  cos(deg2rad($destLat)) * cos(deg2rad($originLat)) * cos(deg2rad($theta)); 
        $dist = acos($dist);
        $dist = rad2deg($dist);
		switch ($units) {
			case 'miles':
				$result = $dist * 60 * 1.1515;
				break;
			case 'km':
				$result = $dist * 60 * 1.8531;
				break;
		}
        
		return $result;	
		
	}
	/**
	 * find can be used for near queries also:
	 *  db.offer.find( { 'location.point' : { $near : [-84,33] , $maxDistance : 50 } } ).skip(4).limit(5)
	 *   .. so the query part is: 'location.point' : { $near : [-84,33] , $maxDistance : 50 }
	 */
	public function find($collection, $query=array(), $fields=array(),$slaveOkay=false,$offset=0,$limit=20,$sort=array('_id'=>-1)){
		$cursor = null;
		$collection = $this->database->selectCollection($collection);
		if($slaveOkay)
			$collection->setReadPreference(\MongoClient::RP_SECONDARY);
		else
			$collection->setReadPreference(\MongoClient::RP_PRIMARY);
		
		error_log('---------------------------------------------------------------------');
		error_log('---------------------------------------------------------------------');
		error_log('---------------------------------------------------------------------');
		$conns = $this->mongo->getConnections();
		error_log('find connection: '.print_r($conns[0]['connection'],true));
		$cursor = $collection->find($query, $fields);

		if(!empty($sort))
			$cursor->sort($sort);
		if(!empty($limit))
			$cursor->limit($limit);
		if(!empty($offset))
			$cursor->skip($offset);
		
		while($cursor->hasNext()):
			$row = $cursor->getNext();
			$row['id'] = $row['_id'];
			$rows[] = $row;
		endwhile;
		if(!empty($rows) && count($rows) > 0):
			return $rows;
		else:
			return false;
		endif;
	}
	public function distinct($collection, $key, $query=array()){
		$c = $this->database->selectCollection($collection);
		$result = $c->distinct($key,$query);

		return $result;
	}
	/**
	 * 
	 */ 
	public function findOne($collection, $query=array(), $fields=array(), $slaveOkay=false){
		
		$cursor 	= null;
		$collection = $this->database->selectCollection($collection);
		if(!$slaveOkay)
			$collection->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection->setReadPreference(\MongoClient::RP_SECONDARY);
		
		$result_arr = $collection->findOne($query, $fields);

		if(!empty($result_arr)):
			return $result_arr;
		else:
			return false;
		endif;
		
	}
	
	public function runCommand($command,$admin=false,$slaveOkay=false){
		
		if($admin){
			$db = $this->mongo->selectDB('admin');
			if(!$slaveOkay)
				$db->setReadPreference(\MongoClient::RP_PRIMARY);
			else
				$db->setReadPreference(\MongoClient::RP_SECONDARY);
			$result_arr = $db->command($command);
		}else{
			if(!$slaveOkay)
				$this->database->setReadPreference(\MongoClient::RP_PRIMARY);
			else
				$this->database->setReadPreference(\MongoClient::RP_SECONDARY);
			$result_arr = $this->database->command($command);
		}
		
		if(!empty($result_arr)):
			return $result_arr;
		else:
			return false;
		endif;
		
	}
	public function listCollections($slaveOkay=false){
		if(!$slaveOkay)
			$this->database->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$this->database->setReadPreference(\MongoClient::RP_SECONDARY);
		
		$collections = $this->database->listCollections();
		
		$coll_arr = array();
		$cnt = 0;
		if(!empty($collections)):
			foreach ($collections as $collection):
				$coll_arr[$cnt]['name'] = $collection->getName();
				$coll_arr[$cnt]['indexInfo'] = $collection->getIndexInfo();
				$coll_arr[$cnt]['count'] = $collection->count();
				$cnt++;
			endforeach;
			return $coll_arr;
		else:
			return false;
		endif;
	}
	public function insert($document, $collection, $options=array()){
		
		$options = array_merge($this->options, $options);
		
		try {
			$collection = $this->database->selectCollection($collection);
			$collection->insert($document, array('safe'=>$options['safe'],
												'fsync'=>$options['fsync'],
												'timeout'=>$options['timeout']
												));
			return $document['_id'];
		} catch(\MongoCursorException $e) {
			error_log('insert exception:'.print_r($e->getMessage(),true));
			return false;
		}
		
	}
	
	public function save($document, $collection, $options=array()){
		
		$options = array_merge($this->options, $options);
		
		$collection_obj = null;
		
		try {
			$collection_obj = $this->database->selectCollection($collection);
			$collection_obj->save($document, array('safe'=>$options['safe'],
												'fsync'=>$options['fsync'],
												'timeout'=>$options['timeout']
												));
			return $document['_id'];
		} catch(\MongoCursorException $e) {
			error_log('MongoWrapper::save::MongoCursorException:'.print_r($e->getMessage(),true));
			return false;
		}
		
	}
	
	public function update($document, $collection, $criteria=array(), $multiple=false, $upsert=false, $options=array()){
		
		$options = array_merge($this->options, $options);
		
		$criteria = (!empty($criteria)) ? $criteria : array('_id'=>new \MongoId($document['id']));
		$collection = $this->database->selectCollection($collection);
		try {
			$response = $collection->update($criteria, $document, array('upsert'=>$upsert,
															'safe'=>$options['safe'],
															'fsync'=>$options['fsync'],
															'timeout'=>$options['timeout'],
															'multiple'=>$multiple
															));
			return $response;
		} catch (\MongoCursorException $e){
			error_log(__METHOD__.'::MongoCursorException::line:'.__LINE__.':'.print_r($e->getMessage(), true));
			return false;
		}
	}
	
	public function deleteById($document, $collection, $justOne=true,$options=array()){
		
		$options = array_merge($this->options, $options);
		
		$criteria 	= null;

		$collection = $this->database->selectCollection($collection);
		$id = (!is_object($document['_id'])) ? new \MongoId($document['_id']) : $document['_id'];
		$criteria = array('_id'=>$id);
		try{
			$collection->remove($criteria, array('justOne'=>$justOne,
												'safe'=>$options['safe'],
												'fsync'=>$options['fsync'],
												'timeout'=>$options['timeout']
												));
			return true;
		} catch (\Exception $e) {
			error_log('deleteById exception:'.print_r($e->getMessage(),true));
			return false;
		}
	}
	
	public function remove($criteria, $collection, $justOne=true, $options=array()){
		$options = array_merge($this->options, $options);
		$collection = $this->database->selectCollection($collection);
		try{
			$collection->remove($criteria, array('justOne'=>$justOne,
												'safe'=>$options['safe'],
												'fsync'=>$options['fsync'],
												'timeout'=>$options['timeout']
												));
			return true;
		} catch (\Exception $e) {
			error_log('remove exception:'.print_r($e->getMessage(),true));
			return false;
		}
	}
	
	public function count($query, $collection,$slaveOkay=false){
		$cursor	= null;
		try{
			$collection = $this->database->selectCollection($collection);
			if(!$slaveOkay)
				$collection->setReadPreference(\MongoClient::RP_PRIMARY);
			else
				$collection->setReadPreference(\MongoClient::RP_SECONDARY);
			$cursor 	= $collection->find($query);
			return $cursor->count();
		} catch(\Exception $e){
			error_log('exception:'.print_r($e->getMessage(),true));
			return false;
		}
	}
	
	
	
	///////////////////////////////////////////
	///////////  GRID FS METHODS  /////////////
	///////////////////////////////////////////
	
	/**
	 * retrieves the file contents from mongo grid fs
	 * @param $fileId 		MongoId or string	The variable which identifies the file 
	 * 											(this is the id that's returned from storeBytes and storeFile methods)
	 * @param $collection 	string 				The mongo collection where the file is stored
	 * @param $slaveOkay 	bool 				whether or not to attempt retrieval from a secondary server
	 * @return  			bytes 				returns the byte stream of the file
	 */
	public function getFile($fileId, $collection, $slaveOkay=true){
		$fileId = (!is_object($fileId)) ? new \MongoId($fileId) : $fileId;
		$collection_obj = $this->database->getGridFS($collection);
		if(!$slaveOkay)
			$collection_obj->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection_obj->setReadPreference(\MongoClient::RP_SECONDARY);


		error_log('---------------------------------------------------------------------');
		error_log('---------------------------------------------------------------------');
		error_log('---------------------------------------------------------------------');
		$conns = $this->mongo->getConnections();
		error_log('getFile connection: '.print_r($conns[0]['connection'],true));


		$mongo_file_obj = $collection_obj->get($fileId);
		if(is_object($mongo_file_obj)) // found
			return $mongo_file_obj->getBytes();
		else // not found
			return false;
	}
	public function getFileByCriteria($criteria, $collection, $slaveOkay=true){
		$collection_obj = $this->database->getGridFS($collection);
		if(!$slaveOkay)
			$collection_obj->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection_obj->setReadPreference(\MongoClient::RP_SECONDARY);


		error_log('---------------------------------------------------------------------');
		error_log('---------------------------------------------------------------------');
		error_log('---------------------------------------------------------------------');
		$conns = $this->mongo->getConnections();
		error_log('getFileByCriteria connection: '.print_r($conns[0]['connection'],true));


		$mongo_file_obj = $collection_obj->findOne($criteria);
		if(is_object($mongo_file_obj)) // found
			return $mongo_file_obj->getBytes();
		else // not found
			return false;
	}
	/**
	 * retrieves the file document from mongo grid fs
	 * @param $fileId 		MongoId or string	The variable which identifies the file 
	 * 											(this is the id that's returned from storeBytes and storeFile methods)
	 * @param $collection 	string 				The mongo collection where the file is stored
	 * @param $slaveOkay 	bool 				whether or not to attempt retrieval from a secondary server
	 * @return  			MongoGridFSFile		returns the object and you can still get the bytes out
	 */
	public function getFileObject($fileId, $collection, $slaveOkay=true){
		$fileId = (!is_object($fileId)) ? new \MongoId($fileId) : $fileId;
		$collection_obj = $this->database->getGridFS($collection);
		if(!$slaveOkay)
			$collection_obj->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection_obj->setReadPreference(\MongoClient::RP_SECONDARY);

		$mongo_file_obj = $collection_obj->get($fileId);
		if(is_object($mongo_file_obj)) // found
			return $mongo_file_obj;
		else // not found
			return false;
	}
	public function getFileObjectByCriteria($criteria, $collection, $slaveOkay=true){
		$collection_obj = $this->database->getGridFS($collection);
		if(!$slaveOkay)
			$collection_obj->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection_obj->setReadPreference(\MongoClient::RP_SECONDARY);

		$mongo_file_obj = $collection_obj->get($criteria);
		if(is_object($mongo_file_obj)) // found
			return $mongo_file_obj;
		else // not found
			return false;
	}
	
	/**
	 * Pushes a file into mongo by way of reading the file into a php variable first
	 * @param $file 		string	The variable which contains all of the bytes of the file
	 * @param $collection 	string 	The mongo collection where this will be stored
	 * @param $document 	array 	An array representing a document to be stored with the file for searching later
	 * @return $file_id 	string 	A mongo id 
	 */
	public function storeBytes($file, $collection, $document=array(),$options=array()){
		if(!empty($options)){
			$this->options = array_merge($this->options, $options);
		}
		$collection = $this->database->getGridFS($collection);
		$file_id = $collection->storeBytes($file, $document, array('safe'=>$this->options['safe'],
											'fsync'=>$this->options['fsync'],
											'timeout'=>$this->options['timeout']
											));
		
		return $file_id;
	}
	
	/**
	 * Pushes a file into mongo by way of the file system
	 * @param $uri	 		string	A file name which includes it's path
	 * @param $collection 	string 	The mongo collection where this will be stored
	 * @param $document 	array 	An array representing a document to be stored with the file for searching later
	 * @return $file_id 	string 	A mongo id 
	 */
	public function storeFile($uri, $collection, $document=array(), $options=array()){
		
		if(!empty($options)){
			$this->options = array_merge($this->options, $options);
		}
		$collection = $this->database->getGridFS($collection);
		$file_id = $collection->storeFile($uri, $document,array('safe'=>$this->options['safe'],
											'fsync'=>$this->options['fsync'],
											'timeout'=>$this->options['timeout']
											));
		
		return $file_id;
	}
	/**
	 * Updates a file by deleting the old file and adding a new one.
	 *
	 * NOTE..if there was a document stored with the old file it is lost.
	 * This behavior can be adjusted to pull out the old meta data and save it 
	 * with the new file if necessary
	 * 
	 * @param $id	 	  string	mongo id of the file to update
	 * @param $uri		  string 	full path to the uploaded file
	 * @param $collection string 	the collection where orig file was and new file will be
	 * @param $document	  string 	the document to save with the new file
	 * @return 			  bool		true on success false on error
	 */
	public function updateFile($id, $uri, $collection,$document=array()){
		
		try {
			// get the old files collection if no new document passed in
			if(empty($document)){
				$gridFSFile = $this->getFileObject($id,$collection);
				$document = $gridFSFile->file;
				//unset($document['filename']);
				unset($document['uploadDate']);
				unset($document['length']);
				unset($document['chunkSize']);
				unset($document['md5']);
			}
			// remove the old file
			$result = $this->removeFile($id, $collection);
			
			// add the newly uploaded file
			$newfile_id = $this->storeFile($uri, $collection, $document,$options=array('safe'=>true,'fsync'=>true));
			
			return $newfile_id;
		} catch (\Exception $e) {
			error_log('updateFile exception:'.print_r($e->getMessage(),true));
			return false;
		}
		
	}
	public function updateFileBytes($id, $file_content, $collection,$document=array()){
		
		try {
			// get the old files collection if no new document passed in
			if(empty($document)){
				$gridFSFile = $this->getFileObject($id,$collection);
				$document = $gridFSFile->file;
				//unset($document['filename']);
				unset($document['uploadDate']);
				unset($document['length']);
				unset($document['chunkSize']);
				unset($document['md5']);
			}
			// remove the old file
			$result = $this->removeFile($id, $collection);
			
			// add the newly uploaded file
			$newfile_id = $this->storeBytes($file_content, $collection, $document,$options=array('safe'=>true,'fsync'=>true));
			
			return $newfile_id;
		} catch (\Exception $e) {
			error_log('updateFile exception:'.print_r($e->getMessage(),true));
			return false;
		}
		
	}
	public function removeFile($id, $collection){
		$grid = $this->database->getGridFS($collection);
		return $grid->remove(array('_id' => new \MongoId($id)));
		
	}
	public function removeFileByCriteria($criteria, $collection){
		$grid = $this->database->getGridFS($collection);
		return $grid->remove($criteria);
		
	}
	public function gridfsremove($criteria=array(), $collection){
		$grid = $this->database->getGridFS($collection);
		return $grid->remove($criteria);
		
	}
	public function gridfsfind($collection, $query, $fields=array(), $slaveOkay=true){
		$collection_obj = $this->database->getGridFS($collection);
		if(!$slaveOkay)
			$collection_obj->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection_obj->setReadPreference(\MongoClient::RP_SECONDARY);
		$cursor = $collection_obj->find($query,$fields);
		if($cursor->hasNext()){
			return $cursor;
		}else{
			return false;
		}
	}
	public function gridfsfindOne($collection, $query, $fields=array(), $slaveOkay=true){
		$collection_obj = $this->database->getGridFS($collection);
		if(!$slaveOkay)
			$collection_obj->setReadPreference(\MongoClient::RP_PRIMARY);
		else
			$collection_obj->setReadPreference(\MongoClient::RP_SECONDARY);
		return $collection_obj->findOne($query,$fields);
	}

}