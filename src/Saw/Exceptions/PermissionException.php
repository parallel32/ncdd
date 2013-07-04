<?php
namespace Saw\Exceptions;

class PermissionException extends \Exception
{
  public function __construct($message=null)
  {
    $message = $message ?: '';
    parent::__construct($message);
  }

}
