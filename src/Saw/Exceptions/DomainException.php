<?php
namespace Saw\Exceptions;

class DomainException extends \Exception
{
  public function __construct($message=null)
  {
	$message = $message ?: 'There was a problem manipulating your data. Most likely due to a database connection error.';
    parent::__construct($message);
  }
}
