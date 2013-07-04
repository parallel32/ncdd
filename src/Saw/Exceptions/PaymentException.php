<?php
namespace Saw\Exceptions;

class PaymentException extends \Exception
{
  public function __construct($message=null, $errorArr=array())
  {
    parent::__construct($message);
    $this->error_array = $errorArr;
  }

  public function getErrorArr()
  {
    return $this->error_array;
  }

}
