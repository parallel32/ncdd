<?php
namespace Saw\Exceptions;

class AuthenticationException extends \Exception
{
  public function __construct($message=null)
  {
    parent::__construct($message);
  }
}
