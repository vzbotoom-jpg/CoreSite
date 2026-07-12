<?php
// app/Exceptions/StockInsufficientException.php

namespace App\Exceptions;

use Exception;

class StockInsufficientException extends Exception
{
    protected $productId;
    protected $productName;
    protected $requestedQuantity;
    protected $availableStock;
    protected $storeId;

    public function __construct(
        $message, 
        $productId = null, 
        $productName = null,
        $requestedQuantity = null,
        $availableStock = null,
        $storeId = null,
        $code = 0, 
        Exception $previous = null
    ) {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->requestedQuantity = $requestedQuantity;
        $this->availableStock = $availableStock;
        $this->storeId = $storeId;
        parent::__construct($message, $code, $previous);
    }

    public function getProductId() { return $this->productId; }
    public function getProductName() { return $this->productName; }
    public function getRequestedQuantity() { return $this->requestedQuantity; }
    public function getAvailableStock() { return $this->availableStock; }
    public function getStoreId() { return $this->storeId; }
}