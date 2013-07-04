<?php
namespace Saw\Model\Exceptions;

class DomainException extends \DomainException {
	private $invalidFieldsArr;
	public function __construct($message=null, $invalidFieldsArr=array()) {
		parent::__construct($message);
		$this->invalidFieldsArr = $invalidFieldsArr;
	}

	public function getInvalidFields() {
		return $this->invalidFieldsArr;
	}

}
