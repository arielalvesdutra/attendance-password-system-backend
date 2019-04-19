<?php

namespace Tests;

use Slim\Http\Response;

class FakeResponse
{
    public static function create(): Response
    {
        return new Response();
    }
}