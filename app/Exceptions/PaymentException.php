<?php
// app/Exceptions/PaymentException.php

namespace App\Exceptions;

use Exception;

class PaymentException extends Exception
{
    protected $transactionId;
    protected $paymentMethod;
    protected $errorCode;

    public function __construct(
        $message, 
        $transactionId = null,
        $paymentMethod = null,
        $errorCode = null,
        $code = 0, 
        Exception $previous = null
    ) {
        $this->transactionId = $transactionId;
        $this->paymentMethod = $paymentMethod;
        $this->errorCode = $errorCode;
        parent::__construct($message, $code, $previous);
    }

    public function getTransactionId() { return $this->transactionId; }
    public function getPaymentMethod() { return $this->paymentMethod; }
    public function getErrorCode() { return $this->errorCode; }
}