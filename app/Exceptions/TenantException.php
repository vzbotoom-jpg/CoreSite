<?php
// app/Exceptions/TenantException.php

namespace App\Exceptions;

use Exception;

class TenantException extends Exception
{
    protected $storeId;
    protected $slug;

    public function __construct($message, $storeId = null, $slug = null, $code = 0, Exception $previous = null)
    {
        $this->storeId = $storeId;
        $this->slug = $slug;
        parent::__construct($message, $code, $previous);
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}