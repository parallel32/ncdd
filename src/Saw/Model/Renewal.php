<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Renewal Model.
 * Belongs to member.  This model nests inside member as the renewal attribute.
 * Used to determine if the Member must fill out a renewal / update form.  Also tracks the status of their renewal.
 * Holds functions that set and update the renewal
 */
class Renewal extends Model {
	
	static public $status = array('UNSUBMITTED'=>5, 'SUBMITTED'=>10, 'APPROVED'=>20, 'PAID'=>40);
	static public $statusReversed = array(5=>'UNSUBMITTED',10=>'SUBMITTED',20=>'APPROVED',40=>'PAID');
	public $currentStatus;  // when the applicatoin is paid the status is reset.
	public $year;
	public $applicationId;  // when the renewal application is submitted this is set in the member record.
	public $submittedDate;
	public $approvedDate;
	public $paidDate;
	public $paymentId;
	public $contributionPaymentId;
	public $payByCheck;
	
	static public function loadValidatorMetadata(ClassMetadata $metadata){
		
	}
	public function __construct($doc, Application $app){
		parent::__construct($app);
		$this->init($doc);
		
		$this->currentStatus = $doc['currentStatus'];
		$this->year = $doc['year'];
		$this->applicationId = $doc['applicationId'];
		$this->submittedDate = $doc['submittedDate'];
		$this->approvedDate = $doc['approvedDate'];
		$this->paidDate = $doc['paidDate'];
		$this->paymentId = $doc['paymentId'];
		$this->contributionPaymentId = $doc['contributionPaymentId'];
		$this->payByCheck = $doc['payByCheck'];

	}
	/**
	 * This method prepares defaults for empty attributes
	*/
	public function prepareInsert(){
		$this->currentStatus = $this->currentStatus ?: self::$status['UNSUBMITTED'];
		$this->year = (date('n') < 11) ? date('Y'): date('Y')+1;// when setting the renewal, if it's after or on November it should be for the next year.  Otherwise, for the current year
		$this->applicationId = $this->applicationId ?: new \stdClass();
		$this->submittedDate = $this->submittedDate ?: new \stdClass();
		$this->approvedDate = $this->approvedDate ?: new \stdClass();
		$this->paidDate = $this->paidDate ?: new \stdClass();
		$this->paymentId = $this->paymentId ?: new \stdClass();
		$this->contributionPaymentId = $this->contributionPaymentId ?: null;
		$this->payByCheck = $this->payByCheck ?: '';
	
	}
	
	public function setRenewalByMember($memberId){
		$this->prepareInsert();
		$renewal = $this->__toArray();
		$member = new Member(array('_id'=>$memberId,'renewal'=>$renewal),self::$app);
		return $member->saveSafe();
	}
}