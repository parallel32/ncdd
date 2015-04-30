<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * RegistrationSeminar Model Extends Registration.
 * This class is the seminar registration model to handle the specific attributes.
 */
class RegistrationSeminar extends Registration {
	 
	public $type = 'NEW SEMINAR REGISTRATION';
	public $class = 'RegistrationSeminar';
	public $nameTag;
	public $barNumber;
	public $rsvp;
	public $rsvpkids;
	public $attendanceCertificationStatement;
	public $hardCopy; // YES | NO
	public $registrationFee;
	public $registrationFeeOriginal;
	public $hardCopyFee;
	public $total;
	public $seminarId;
	public $previouslyAttended;
	public $previouslyAttendedExists;
	public $depositQuestion; // yes | no
	public $deposit; // the amount for the initial deposit
	public $depositPaymentId; // the paymentId for the initial deposit
	public $depositDueDate; // the due date for payment of the remainer of the deposit
	public $depositPaidDate; // the date the deposit was recieved
	public $registrationNumber; // the scholarship registration number
	public $userAgent;
	public $tempPayment;
	public $scholarshipId;

	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('nameTag', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('barNumber', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('attendanceCertificationStatement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addConstraint(new Callback(array(
            'methods' => array('previouslyAttended'),
        )));
	}
	public function previouslyAttended(ExecutionContext $context){
		
		if($this->previouslyAttendedExists == 'yes' && $this->previouslyAttended != 0 && empty($this->previouslyAttended)){
			$propertyPath = $context->getPropertyPath().'previouslyAttended';
        	$context->addViolationAtPath($propertyPath,'Please enter how many times you have previously attended this seminar.', array(), null);
		}
		
	}
	
	public function __construct($doc, Application $app){
		$this->previouslyAttendedExists = (array_key_exists('previouslyAttended',$doc)) ? 'yes': 'no';
		parent::__construct($doc,$app);
		$this->init($doc);
		$this->nameTag = $doc['nameTag'];
		$this->barNumber = (string)$doc['barNumber'];
		$this->rsvp = (string)$doc['rsvp'];
		$this->rsvpkids = (string)$doc['rsvpkids'];
		$date = new \DateTime();
		$acs_text = ', on this '.$date->format('dS').' day of '.$date->format('F').', 20'.$date->format('y');
		if(!empty($doc['attendanceCertificationStatement']) && strpos($doc['attendanceCertificationStatement'],'day of') === false){
			$this->attendanceCertificationStatement = $doc['attendanceCertificationStatement'].$acs_text;
		}else{
			$this->attendanceCertificationStatement = $doc['attendanceCertificationStatement'];
		}
		$this->hardCopy = $doc['hardCopy'];
		$this->registrationFee = $doc['registrationFee'];
		$this->registrationFeeOriginal = $doc['registrationFeeOriginal'];
		$this->hardCopyFee = $doc['hardCopyFee'];
		$this->total = $doc['total'];
		$this->previouslyAttended = $doc['previouslyAttended'];
		if(!empty($doc['seminarId'])) $this->seminarId = (is_object($doc['seminarId'])) ? $doc['seminarId'] : new \MongoId($doc['seminarId']);
		$this->deposit = $doc['deposit'];
		if(!empty($doc['depositPaymentId'])) $this->depositPaymentId = (is_object($doc['depositPaymentId'])) ? $doc['depositPaymentId'] : new \MongoId($doc['depositPaymentId']);
        $this->depositDueDate = $doc['depositDueDate'];
        $this->depositQuestion = $doc['depositQuestion'];
        $this->depositPaidDate = $doc['depositPaidDate'];
        $this->registrationNumber = $doc['registrationNumber'];
        $this->userAgent = $doc['userAgent'];
        $this->tempPayment = $doc['tempPayment'];
        $this->scholarshipId = $doc['scholarshipId'];
	}
	
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
		$this->nameTag = $this->nameTag ?: '';
		$this->barNumber = $this->barNumber ?: '';
		$this->rsvp = $this->rsvp ?: '';
		$this->rsvpkids = $this->rsvpkids ?: '';
		$this->attendanceCertificationStatement = $this->attendanceCertificationStatement ?: '';
		$this->hardCopy = $this->hardCopy ?: 'NO';
		$this->registrationFee = $this->registrationFee ?: 0;
		$this->registrationFeeOriginal = $this->registrationFeeOriginal ?: 0;
		$this->hardCopyFee = $this->hardCopyFee ?: 0;
		$this->total = $this->total ?: 0;
		$this->seminarId = $this->seminarId ?: new \stdClass();
		$this->previouslyAttended = $this->previouslyAttended ?: '';
		$this->deposit = $this->deposit ?: 0;
		$this->depositPaymentId = $this->depositPaymentId ?: new \stdClass();
		$this->depositDueDate = $this->depositDueDate ?: new \stdClass();
		$this->depositQuestion = $this->depositQuestion ?: 'no';
		$this->depositPaidDate = $this->depositPaidDate ?: new \stdClass();
		$this->registrationNumber = $this->registrationNumber ?: 'no';
		$this->userAgent = $this->userAgent ?: '';
		$this->tempPayment = $this->tempPayment ?: new \stdClass();
		$this->scholarshipId = $this->scholarshipId ?: new \stdClass();
	}
	
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Registration Failed due to a server error.  Wait a moment and please try again.");
		}
	}
	public function markPaid($paymentId){
		$pp = self::$app;
		$registration = $this->findOne(array('_id'=>$this->_id),array(),$slaveOk=false);
		$payment = new Payment(array('_id'=>$paymentId), self::$app);
		$payment = $payment->findById();
		$seminar = new Seminar(array('_id'=>$registration['seminarId']), self::$app);
		$seminar = $seminar->findById();

			// is there a hardcopy fee? if so remove it to isolate the total
			if($registration['hardCopy'] == 'YES'){
				$total = $payment['amount'] - $registration['hardCopyFee'];
			}else{
				$total = $payment['amount'];
			}
			// does the total equal the deposit fee?
		$total_is_deposit_fee = ($total < $registration['registrationFee']) ? true : false;
			// does the total equal the balance due?
			// first derive the total registration amount due
			$accessLevel = call_user_func(function($aapp){ $user = $aapp['session']->get('user'); return $user['accessLevel'];},self::$app);
			$base_fee = (!empty($accessLevel)) ? $seminar['register']['memberPrice'] : $seminar['register']['nonMemberPrice'];
			$hard_copy_fee = ($registration['hardCopy'] == 'YES') ? $registration['hardCopyFee']: 0;
			$total_original_registration_fee = $base_fee + $hard_copy_fee;
			$deposit_price = $seminar['register']['deposit'] + $hard_copy_fee;
			$balance_due = (int)$total_original_registration_fee - (int)$deposit_price;
		$total_is_balance_due = ($payment['amount'] == $balance_due) ? true : false;
		$total_is_full_payment = ($payment['amount'] == $total_original_registration_fee) ? true : false;

		error_log(__FILE__.' '.__LINE__.' for variable: is deposit  ==>'.print_r($total_is_deposit_fee,true));
		error_log(__FILE__.' '.__LINE__.' for variable: is balance due  ==>'.print_r($total_is_balance_due,true));
		error_log(__FILE__.' '.__LINE__.' for variable: is full payment  ==>'.print_r($total_is_full_payment,true));
		error_log(__FILE__.' '.__LINE__.' for variable: is paymentId  ==>'.print_r($registration['paymentId'],true));
		error_log(__FILE__.' '.__LINE__.' for variable: is depositPaymentId  ==>'.print_r((array_key_exists('depositPaymentId', $registration)) ? $registration['depositPaymentId'] : '',true));
		error_log(__FILE__.' '.__LINE__.' for variable: is payment amount  ==>'.print_r($payment['amount'],true));
		error_log(__FILE__.' '.__LINE__.' for variable: is total  ==>'.print_r($total,true));
		error_log(__FILE__.' '.__LINE__.' for variable: is registration fee  ==>'.print_r($registration['registrationFee'],true));
		error_log(__FILE__.' '.__LINE__.' for variable: is balance_due  ==>'.print_r($balance_due,true));
		
		// is this a deposit? .. total has to match a deposit fee and there can be no paymentid's recorded
		if($total_is_deposit_fee && (empty($registration['paymentId']) && (array_key_exists('depositPaymentId', $registration) && empty($registration['depositPaymentId'])))){
			error_log(__FILE__.' '.__LINE__.' for variable: thisvar  ==>'.print_r('AA',true));
			$this->currentStatus = self::$status['DEPOSIT'];
			$this->depositPaidDate = new Date(self::$app,'now', 'America/New_York');
			$this->depositPaymentId = new \MongoId($paymentId);
		}
		// is this a balance payment? .. total has to match a balance payment and paymentId has to be there for legacy or depositPaymentId cannot be blank for new registrations
		if($total_is_balance_due && (!empty($registration['paymentId']) || (array_key_exists('depositPaymentId', $registration) && !empty($registration['depositPaymentId'])))){
			error_log(__FILE__.' '.__LINE__.' for variable: thisvar  ==>'.print_r('BB',true));
			$this->currentStatus = self::$status['PAID'];
			$this->paidDate = new Date(self::$app,'now', 'America/New_York');
			if(!empty($registration['paymentId'])){
				$this->depositPaymentId = $registration['paymentId'];
				$this->paymentId = new \MongoId($paymentId);
			}else{
				$this->paymentId = new \MongoId($paymentId);
			}
			
		}
		// is this a full upfront payment?
		if($total_is_full_payment && (empty($registration['paymentId']) || ( empty($registration['paymentId']) && array_key_exists('depositPaymentId', $registration) && empty($registration['depositPaymentId'])))){
			error_log(__FILE__.' '.__LINE__.' for variable: thisvar  ==>'.print_r('CC',true));
			$this->currentStatus = self::$status['PAID'];
			$this->paidDate = new Date(self::$app,'now', 'America/New_York');
			$this->paymentId = new \MongoId($paymentId);
		}		
		
		// save everything.
		$this->saveSafe();

	////////////////////
	// prepare emails //
	////////////////////
		

		// confirmation letter email
		$user = self::$app['session']->get('user');
	    if(is_array($user) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
			// don't send the email		
		}else{
			$pp['seminarConfirmationEmail']($pp,$registration['_id']);
		}
	    // thank you receipt message
		$subject = 'NCDD Payment Received';
		$to = $payment['email'];
		$view_vars = array('payment'=>$payment
							,'paymentId'=>$paymentId
							,'email'=>$payment['email']
		);
		$body = $pp['view']->render('email/payment-thankyou','email', $view_vars);
		
		
		if(is_array($user) && array_key_exists('accessLevel', $user) && ($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )) && array_key_exists('suppress_emails', $user) && $user['suppress_emails'] == 'yes'){
			// don't send the email		
		}else{
			$pp['sendMail']($subject, $body, $to);	
		}

		return true;

	}
	
	
	public function fetchByStatusSeminar($seminarId, $status, $offset=0,$limit=100){
		$seminarId = (is_object($seminarId)) ? $seminarId : new \MongoId($seminarId);
		$query = array('seminarId'=>$seminarId,'currentStatus'=>self::$status[$status]);
		$fields = array('name'=>true
						,'email'=>true
						,'phone'=>true
						,'currentStatus'=>true
						,'currentPaymentType'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'depositPaymentId'=>true
						,'seminarId'=>true
						,'scholarshipId'=>true
						);
		switch ($status) {
			case 'SUBMITTED':
				$sort=array('submittedDate.date'=>-1);
				break;
			case 'PAID':
				$sort=array('paidDate.date'=>-1);
				break;
			default:
				$sort=array('_id'=>-1);
				break;
		}
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}

	public function fetchDepositStatus($seminarId, $offset=0,$limit=100){
		$seminarId = (is_object($seminarId)) ? $seminarId : new \MongoId($seminarId);
		$query = array('seminarId'=>$seminarId,'currentStatus'=>array('$in'=>array(self::$status['DEPOSIT'],self::$status['DEPOSITBALANCE'])));
		$fields = array('name'=>true
						,'email'=>true
						,'phone'=>true
						,'currentStatus'=>true
						,'currentPaymentType'=>true
						,'class'=>true
						,'submittedDate'=>true
						,'paidDate'=>true
						,'_id'=>true
						,'memberId'=>true
						,'paymentId'=>true
						,'depositPaymentId'=>true
						,'seminarId'=>true
						);
		$sort=array('submittedDate.date'=>-1);
		$result = $this->find($query,$fields,$slaveOkay=true,$sort,(int)$offset,(int)$limit);
		//error_log('fetch:'.print_r($result,true));
		return $result;

	}
	
		
}