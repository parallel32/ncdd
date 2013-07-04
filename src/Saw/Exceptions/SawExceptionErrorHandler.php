<?php
namespace Saw\Exceptions;

class SawExceptionErrorHandler extends SawException {
	
	protected $message;
	protected $errno;
	protected $file;
	protected $line;
	
	public function __construct($errno, $errstr, $errfile, $errline) {
		$this->errno = $errno;
		$this->message = $errstr;
		$this->file = $errfile;
		$this->line = $errline;
		
		// this is here so that we can properly construct parent
		$exception = new \Exception($this->message);
		parent::__construct($exception, $this->message, array(), false);
		
		$this->mapErrorNumber($errno);
	}
	
	private function mapErrorNumber($errno) {
		
		switch ($errno) {
	    	case E_USER_ERROR:
				$this->httpStatusCode = 400;
				$this->message = 'E_USER_ERROR:'.$this->message;
				$this->writeErrorLog();
		        break;
		    case E_USER_WARNING:
				$this->httpStatusCode = 400;
				$this->message = 'E_USER_WARNING:'.$this->message;
				$this->writeErrorLog();
		        break;
		    case E_USER_NOTICE:
				$this->httpStatusCode = 400;
		        $this->message = 'E_USER_NOTICE:'.$this->message;
				$this->writeErrorLog();
				break;
		    case E_ERROR:
				$this->httpStatusCode = 521;
		        $this->message = 'E_ERROR:'.$this->message;
				$this->writeErrorLog(true);
				break;
			case E_WARNING:
				$this->httpStatusCode = 521;
		        $this->message = 'E_WARNING:'.$this->message;
				$this->writeErrorLog();
				break;
		    case E_NOTICE:
				$this->httpStatusCode = 521;
		        $this->message = 'E_NOTICE:'.$this->message;
				$this->writeErrorLog();
				break;
			default:
				$this->httpStatusCode = 521;
		        $this->message = 'Default mapErrorNumber :'.$this->message;
				$this->writeErrorLog();
		        break;
	    }
		
	}
	public function getErrno(){
		return $this->errno;
	}
	public function writeErrorLog($email=false){
		$server_name = SAW_SERVER_NAME;
		$email_message = <<<EOD
<h2>SawExceptionErrorHandler Error on SERVER: $server_name</h2><br>
<strong>Message:</strong> $this->message<br> 
<strong>Errno:</strong> $this->errno <br>
<strong>File:</strong> $this->file <br>
<strong>Line:</strong> $this->line <br>

EOD;
		$message = <<<EOD
SawExceptionErrorHandler
Message: $this->message 
Errno: $this->errno 
File: $this->file 
Line: $this->line 
EOD;

		if($email){
			error_log($email_message, 1,SAW_ERROR_LOG_MAILER_TO,"From: ".SAW_ERROR_LOG_MAILER_FROM."\nContent-Type: text/html; charset=ISO-8859-1");
			error_log($message);
		}else{
			error_log($message);
		}
		
	}

}
