<?php
namespace Saw\Model;

use Silex\Application;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Extends Reference Model.  Used to separate validation logic for reference forms
 */
class ReferenceMember extends Reference {
	
	public $type = 'NEW MEMBER REFERENCE';
	public $class = 'ReferenceMember';
	private $maxSubmissions = 2;

	static public function loadValidatorMetadata(ClassMetadata $metadata){
		$metadata->addPropertyConstraint('sittingJudge', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('licensedAttorney', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('substantialInvolvement', new Constraints\NotBlank(array('message'=>'cannot be blank')));
		$metadata->addPropertyConstraint('noProfessionalInquiry', new Constraints\NotBlank(array('message'=>'cannot be blank')));
	}
	/**
	* determines if max submission has been reached
	* for new members, the count should be 2
	*/
	public function checkMaxSubmissions(){
		$count = $this->getTotalSubmissions();
		return ($count >= $this->maxSubmissions) ? true : false;
	}
	public function __construct($doc, Application $app){
		parent::__construct($doc,$app);
		$this->init($doc);
	}
	/**
	 * This method prepares defaults for empty attributes
	*/
	protected function prepareInsert(){
		parent::prepareInsert();
	}
	public function insert(){
		$this->prepareInsert();
		if(parent::insert()){
        	return $this->_id;
        }else{
			throw new Saw\Exceptions\SawException(new Saw\Model\Exceptions\DomainException(),"Adding failed.  Please try again.");
		}
	}
	public function getMaxSubmissions(){
		return $this->maxSubmissions;
	}
}