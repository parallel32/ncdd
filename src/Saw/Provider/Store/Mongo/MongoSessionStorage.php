<?php
namespace Saw\Provider\Store\Mongo;

use Silex\Application;

class MongoSessionStorage {
	// session options
	protected $options = array();
	// mongo options
	protected $mongoOptions = array('collection' => 'session');
	// stores the mongo connection
	protected $connection;
	// stores the mongo collection
	protected $mongo;
	// stores session data results
	protected $session;
	// silex service container
	public $app;
	public $started;
	public $closed;

	/**
	* Constructor.
	*
	* @param array $options   An associative array of session options
	* @param array $dbOptions An associative array of DB options
	*/
	public function __construct(Application $app, array $options = array(), array $mongoOptions = array())
	{
		$this->app = $app;
		$this->options = $options;
		$this->mongoOptions = array_merge($this->mongoOptions, $mongoOptions);
		
		// override any php.ini cookie / session settings
		foreach ($options as $key => $value) {
	        if (in_array($key, array(
	            'auto_start', 'cache_limiter', 'cookie_domain', 'cookie_httponly',
	            'cookie_lifetime', 'cookie_path', 'cookie_secure',
	            'entropy_file', 'entropy_length', 'gc_divisor',
	            'gc_maxlifetime', 'gc_probability', 'hash_bits_per_character',
	            'hash_function', 'name', 'referer_check',
	            'save_path', 'serialize_handler', 'use_cookies',
	            'use_only_cookies', 'use_trans_sid', 'upload_progress.enabled',
	            'upload_progress.cleanup', 'upload_progress.prefix', 'upload_progress.name',
	            'upload_progress.freq', 'upload_progress.min-freq', 'url_rewriter.tags'))) {
	            ini_set('session.'.$key, $value);
	        }
	    }
	
		$this->registerSaveHandlers();
		$this->registerShutdownFunction();
		
	}

	/**
	* Opens a session.
	*
	* @param  string $path  (ignored)
	* @param  string $name  (ignored)
	*
	* @return Boolean true, if the session was opened, otherwise an exception is thrown
*/
	public function open($path = null, $name = null)
	{	
		
		// ensure they supplied a database
		if (empty($this->mongoOptions['database'])) {
			throw new \Exception('You must specify a MongoDB database to use for session storage.');
		}

		if (empty($this->mongoOptions['collection'])) {
			throw new \Exception('You must specify a MongoDB collection to use for session storage.');
		}

		$options = array(
			'connect' => true, // Immediately connect to MongoDB
			'replicaSet' => $this->mongoOptions['replicaSet'],
			'readPreference' => \MongoClient::RP_PRIMARY_PREFERRED
		);
		try {
			// load mongo servers
			//error_log('mongoOptions:'.print_r($this->mongoOptions, true));
			//error_log('options:'.print_r($options, true));
			
			$this->connection = new \MongoClient('mongodb://' . $this->mongoOptions['servers'], $options);
		} catch (\MongoConnectionException $e){
			throw new \MongoConnectionException("Couldn't connect to mongo..catastrophe!");
		}

		// load db
		try {
			$database = $this->connection->selectDB($this->mongoOptions['database']);
			$database->setReadPreference(\MongoClient::RP_PRIMARY_PREFERRED);
		} catch (\InvalidArgumentException $e) {
			throw new \MongoConnectionException('The MongoDB database specified in the config does not exist.');
		}

		// load collection
		try {
			$this->mongo = $database->selectCollection($this->mongoOptions['collection']);
		} catch (\Exception $e) {
			throw new \MongoConnectionException('The MongoDB collection specified in the config does not exist.');
		}
		// ensure we have proper indexing on the expiration
		//$this->mongo->ensureIndex('expiry', array('expiry' => 1));

		return true;
	}

	/**
	* Closes a session.
	*
	* @return Boolean true, if the session was closed, otherwise false
*/
	public function close()
	{
		// do nothing
		return true;
	}

	/**
	* Destroys a session.
	*
	* @param  string $id  A session ID
	*
	* @return Boolean   true, if the session was destroyed, otherwise an exception is thrown
	*
	* @throws \RuntimeException If the session cannot be destroyed
*/
	public function destroy($id)
	{
		$this->mongo->remove(array('session_id' => $id), true);
		return true;
	}

	/**
	* Cleans up old sessions.
	*
	* @param  int $lifetime  The lifetime of a session
	*
	* @return Boolean true, if old sessions have been cleaned, otherwise an exception is thrown
	*
	* @throws \RuntimeException If any old sessions cannot be cleaned
*/
	public function gc($lifetime)
	{
		// define the query
		$query = array('expiry' => array('$lt' => time()));

		// specify the update vars
		$update = array('$set' => array('active' => 0));

		// update options
		$options = array(
			'multiple' => TRUE,
			'safe' => $this->mongoOptions['safe'],
			'fsync' => $this->mongoOptions['fsync']
		);

		// update expired elements and set to inactive
		try {
			$this->mongo->update($query, $update, $options);
		} catch (\MongoCursorException $e) {
			throw new \Exception("Couldn't garbage collect session data to mongo",0,$e);
		} catch (\Exception $e) {
			throw new \Exception("Couldn't garbage collect session data to mongo",0,$e);
		}

		// re-set the cookie expiry time. it's here because there's no need to re-set on each request
		// but rather to piggy back on the probability of the gc getting called seems good enough.
		$cookie_params = session_get_cookie_params();
		//error_log('gc.cookie_params'.print_r($cookie_params,true));
		setcookie(	session_name(), 
		session_id(), 
		time() + $cookie_params['lifetime'], 
		$cookie_params['path'], 
		$cookie_params['domain'],
		$cookie_params['secure'],
		$cookie_params['httponly']);

		return true;
	}

	/**
	* Reads a session.
	*
	* @param  string $id  A session ID
	*
	* @return string      The session data if the session was read or created, otherwise an exception is thrown
	*
	* @throws \RuntimeException If the session cannot be read
*/
	public function read($id)
	{
		try {
			// retrieve valid session data
			$now = time();
			$query = array(
	             'session_id' => $id,
	             'expiry' => array('$gte' => $now),
	             'active' => 1
	         );
			// exclude results that are inactive or expired
			$result = $this->mongo->findOne(
			         $query
			);
			if (!empty($result)) {
				$this->session = $result;
				return $result['data'];
			}

			return '';
		} catch (\MongoCursorException $e){
			throw new \Exception("Couldn't read the session data from mongo",0,$e);
		} catch (\Exception $e) {
			throw new \RuntimeException(sprintf('Exception was thrown when trying to read the session data from mongo: %s', $e->getMessage()), 0, $e);
		}

	}

	/**
	* Writes session data.
	*
	* @param  string $id    A session ID
	* @param  string $data  A serialized chunk of session data
	*
	* @return Boolean true, if the session was written, otherwise an exception is thrown
	*
	* @throws \RuntimeException If the session data cannot be written
*/
	public function write($id, $data)
	{	
		// create expires
		$cookie_params = session_get_cookie_params();
		if(array_key_exists('lifetime', $cookie_params))
			$expiry = time() + $cookie_params['lifetime'];
		else
			$expiry = time();
		// create new session data
		$new_obj = array(
			'session_id' => $id,
			'data' => $data,
			'active' => 1,
			'expiry' => $expiry
		);

		// atomic update
		$query = array('session_id' => $id);
		// update options
		$options = array(
			'upsert' => true,
			'safe' => $this->mongoOptions['safe'],
			'fsync' => $this->mongoOptions['fsync']
		);

		// perform the update or insert
		try {
			if($this->mongo){
				//error_log('new_obj:'.print_r($new_obj, true));
				//error_log('options:'.print_r($options, true));
				
				$result = $this->mongo->update($query, array('$set' => $new_obj), $options);
				//error_log('result:'.print_r($result, true));
				
			}
		} catch (\MongoCursorException $e) {
			throw new \MongoConnectionException("Couldn't write session data to mongo",0,$e);
		} catch (\Exception $e) {
			throw new \MongoConnectionException("Couldn't write session data to mongo",0,$e);
		}

		return true;
	}
	/**
	* Overrides AbstractSessionStorage::start() so that the cookie can be reset as the 
	* session expiry updates on the server side so does the cookie expiry time.
	*/
	public function start()
	{
		if ($this->started && !$this->closed) {
			error_log('in here and should not be');
			return true;
		}
		
		if (headers_sent()) {
			throw new \RuntimeException('Failed to start the session because header have already been sent.');
		}
		
		// start the session
		if (!session_start()) {
			throw new \RuntimeException('Failed to start the session');
		}
		
		$this->started = true;
		$this->closed = false;
		
		return true;
	}
	
	protected function registerSaveHandlers()
	{
	        session_set_save_handler(
	            array($this, 'open'),
	            array($this, 'close'),
	            array($this, 'read'),
	            array($this, 'write'),
	            array($this, 'destroy'),
	            array($this, 'gc')
	        );
	}
	
	protected function registerShutdownFunction()
	{
	    register_shutdown_function('session_write_close');
	}
	
	public function set($key, $value){
		$_SESSION[$key] = $value;
		return true;		
	}
	
	public function get($key){
		if(array_key_exists($key,$_SESSION))
			return $_SESSION[$key];
		else
			return false;
	}
	public function getId(){
		return session_id();
	}
}