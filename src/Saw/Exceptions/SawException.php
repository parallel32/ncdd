<?php
namespace Saw\Exceptions;

class SawException extends \Exception {
	
	protected $message;
	protected $exception;
	protected $file;
	protected $line;
	protected $invalidFields;
	protected $httpStatusCode;
	protected $headers;
	/**
	 * lookup resolution by status code
	 * resolveAction can have FAIL, RETRY or WAIT
	 * message can be overwritten by the try catch throwing this saw exception
	 */ 
	protected $resolveMap = array(
									301=>array(	'message'=>'This page has permanently moved.', 
												'resolveMessage'=>'Click the link to the new page.',
												'resolveAction'=>'RETRY'),
									400=>array(	'message'=>'Your request could not be processed due to invalid fields.', 
												'resolveMessage'=>'Fix the fields marked as invalid and try again.',
												'resolveAction'=>'RETRY'),
									401=>array(	'message'=>'The resource you requested is restricted to members with permissions only.', 
												'resolveMessage'=>'You must be logged in and have permissions.',
												'resolveAction'=>'FAIL'),
									402=>array(	'message'=>'Your account is behind in payments.', 
												'resolveMessage'=>'Please navigate to your account billing area and submit payment to re-activate this resource.',
												'resolveAction'=>'FAIL'),
									403=>array(	'message'=>'The resource you requested is restricted to members with permissions only.', 
												'resolveMessage'=>'Please sign-in here: <a href="/login">/login</a> with proper credentials',
												'resolveAction'=>'FAIL'),
									404=>array(	'message'=>'The page you are looking for does not exist.', 
												'resolveMessage'=>'Please re-examine the URL.',
												'resolveAction'=>'FAIL'),
									405=>array(	'message'=>'The URL request method was not allowed.', 
												'resolveMessage'=>'If you tried POST and got this try GET.',
												'resolveAction'=>'FAIL'),
									409=>array(	'message'=>'You have tried to submit something that conflicts with what we already have.', 
												'resolveMessage'=>'Change the data in your submission and try again',
												'resolveAction'=>'RETRY'),
									410=>array(	'message'=>'You have requested a page that no longer exists.', 
												'resolveMessage'=>'Please check the link and try again or go to the home page.',
												'resolveAction'=>'RETRY'),
									420=>array(	'message'=>'We have processed too many requests by you.', 
												'resolveMessage'=>'Please wait a while before re-trying.',
												'resolveAction'=>'WAIT'),
									500=>array(	'message'=>'The system has failed and we are fixing it..please excuse this error.', 
												'resolveMessage'=>'Please try again later.',
												'resolveAction'=>'WAIT'),
									503=>array(	'message'=>'The system is currently inaccessible due to high and unexpected load.', 
												'resolveMessage'=>'Please wait a while and try again later',
												'resolveAction'=>'WAIT'),
									504=>array(	'message'=>'We cannot process the connection to the external social network because they did not respond.', 
												'resolveMessage'=>'Please try again later when their system becomes available again.',
												'resolveAction'=>'WAIT'),
									521=>array(	'message'=>'There was an internal programming error.', 
												'resolveMessage'=>'Please try again later.  We will have the error fixed as soon as we can.',
												'resolveAction'=>'WAIT')
								);
	/**
	 * @exception exception object which was caught and passed in
	 * @message can override default message tied to status code
	 * @invalidFields for model exceptions where the model validator threw a domain exception with the invalid fields
	 */
	public function __construct($exception, $message='', $invalidFields=array(), $extraResponseHeaders = array(), $useMap=true) {
		
		$this->message = $message;
		$this->exception = $exception;
		$this->invalidFields = $invalidFields;
		$this->headers = $extraResponseHeaders;
		
		parent::__construct($message, $exception->getCode());
		if($useMap)
			$this->mapExceptionObject();
		
		
	}
	public function getHeaders(){
		return $this->headers;
	}
	public function getHttpStatusCode(){
		return $this->httpStatusCode;
	}
	public function getAbortResponse(){
		$message = (!empty($this->message)) ? $this->message : $this->resolveMap[$this->httpStatusCode]['message'];;
		$resolve_action = $this->resolveMap[$this->httpStatusCode]['resolveAction'];
		$resolve_message = $this->resolveMap[$this->httpStatusCode]['resolveMessage'];
		return json_encode(array(	'message'=>$message,
									'resolveAction'=>$resolve_action,
									'resolveMessage'=>$resolve_message,
									'invalidFields'=>$this->invalidFields
							));
	}
	private function mapExceptionObject() {
		//*
		//error_log('exception class:'.get_class($this->exception));
		switch (get_class($this->exception)) {
			case 'Swift_TransportException':
				// this means the welcome / other email notice did not go out
				// but the action was completed so we want to write a log and 
				// email it out.  The server email doesn't use swift so the error
				// should go out.
				$this->httpStatusCode = 200;
				$this->writeErrorLog(true);
			case 'Saw\Exceptions\PageMovedException':
				$this->httpStatusCode = 301;
				break;
			case 'Stripe_InvalidRequestError':
			case 'InvalidArgumentException':
			case 'UnexpectedValueException':
			case 'DomainException':
			case 'Saw\Model\Exceptions\DomainException':
			case 'Saw\Component\Communication\Exceptions\RequestDomainException':
			case 'Saw\Component\Communication\Exceptions\ResponseDomainException':
				$this->httpStatusCode = 400;
				break;
			case 'Stripe_AuthenticationError':
			case 'Saw\Exceptions\AuthenticationException':
				$this->httpStatusCode = 401;
				break;
			case 'Saw\Exceptions\PaymentException':
			case 'Stripe_CardError':
				$this->httpStatusCode = 402;
				$this->writeErrorLog(true);
				break;
			case 'Saw\Exceptions\PermissionException':
				$this->httpStatusCode = 403;
				break;
			case 'Saw\Exceptions\NotFoundException':
			case 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException';
				$this->httpStatusCode = 404;
				break;
			case 'DuplicateKeyException':
			case 'Saw\Exceptions\DuplicateKeyException':
				$this->httpStatusCode = 409;
				break;
			case 'Saw\Exceptions\PageGoneException':
				$this->httpStatusCode = 410;
				break;
			case 'Saw\Exceptions\RateLimitException':
				$this->httpStatusCode = 420;
				break;
			case 'Stripe_ApiError':
			case 'Saw\Exceptions\PaymentGatewayException':
			case 'MongoGridFSException':
			case 'MongoException':
			case 'MongoCursorException':
			case 'RuntimeException':
			case 'LogicException':
			case 'BadMethodCallException':
			case 'ErrorException':
			case 'ServerException':
			      $this->httpStatusCode = 500;
				  $this->message = $this->exception->getMessage();
                  $this->writeErrorLog(true);
                  break;
          	case 'Symfony\Component\HttpKernel\Exception\HttpException':
                  $this->httpStatusCode = $this->exception->getStatusCode();
                  $this->message = $this->exception->getMessage();
                  $this->writeErrorLog(true);
                  break;
			case 'MongoConnectionException':
			case 'MongoCursorTimeoutException':
				$this->httpStatusCode = 503;
				$this->writeErrorLog(true);
				break;
			case 'OAuthException':
			case 'FacebookApiException':
				$this->httpStatusCode = 504;
				$this->writeErrorLog(true);
				break;
				
			default:
				$this->httpStatusCode = 500;
				$this->message = $this->exception->getMessage();
				$this->writeErrorLog(true);
				break;
		}
		//*/
	}
	
	public function writeErrorLog($email=false){
		$server_name = SAW_SERVER_NAME;
		
		// prepare previous exceptions as apposed to an unreadable stack trace.
		$prev_exc = '';
		$e = $this->exception->getPrevious();
		$trace = $this->exception->getTraceAsString();
		if($e instanceof \Exception)
			$prev_exc = sprintf("%s:%d %s (%d) [%s]\n", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
		
		$tmp = explode('trace:', $this->exception->getCode());
		$code = $tmp[0];
		$tmp = explode('trace:', $this->exception->getFile());
		$file = $tmp[0];
		$tmp = explode('trace:', $this->exception->getLine());
		$line = $tmp[0];
		$tmp = explode('trace:', $this->exception->getMessage());
		$message = $tmp[0];
		$SAW_message = $this->message;
		
		$email_message = <<<EOD
<h2>Error on SERVER: $server_name</h2><br>
<strong>GW Message:</strong> $SAW_message <br> 
<strong>Message:</strong> $message <br> 
<strong>Code:</strong> $code <br>
<strong>File:</strong> $file <br>
<strong>Line:</strong> $line <br>
<strong>Trace:</strong><br>
$trace
EOD;
		
		$message = <<<EOD
Error on SERVER: $server_name
GW Message: $SAW_message
Message: $message
Code: $code
File: $file 
Line: $line 
EOD;
	
		if($email){
			// TODO: uncomment for production because getting inundated with emails during core development.
			//error_log($email_message, 1,SAW_ERROR_LOG_MAILER_TO,"From: ".SAW_ERROR_LOG_MAILER_FROM."\nContent-Type: text/html; charset=ISO-8859-1");
			error_log($message);
		}else{
			error_log($message);
		}
		
	}
	public static function throwNew($statusCode, $exceptionMessage='',$invalidFields=array(),$extraResponseHeaders=array()){
		switch ($statusCode) {
			case 301:
				throw new SawException(new PageMovedException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 400:
				throw new SawException(new DomainException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 401:
				throw new SawException(new AuthenticationException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 402:
				throw new SawException(new PaymentException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 403:
				throw new SawException(new PermissionException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 404:
				throw new SawException(new NotFoundException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 405:
				throw new SawException(new MethodNotAllowed(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 409:
				throw new SawException(new DuplicateKeyException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 410:
				throw new SawException(new PageGoneException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 420:
				throw new SawException(new RateLimitException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 500:
				throw new SawException(new InternalServerErrorException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 503:
				throw new SawException(new ServiceUnavailableException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 504:
				throw new SawException(new GatewayTimeoutException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			case 521:
				throw new SawException(new InternalProgrammingErrorException(),$exceptionMessage,$invalidFields,$extraResponseHeaders);
				break;
			
			
		}
		
	}

}
