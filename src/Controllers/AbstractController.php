<?php

namespace App\Controllers;


abstract class AbstractController
{
    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }
}