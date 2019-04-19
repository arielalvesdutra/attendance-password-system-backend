<?php

namespace Tests;


use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class FakeRequest
{
    public static function create(string $method, string  $uri,
                                  array $requestParameters = []): Request
    {
        $env = Environment::mock([
            'REQUEST_URI' => $uri,
            'REQUEST_METHOD' => $method,
            'CONTENT_TYPE' => 'application/json;'
        ]);

        $body = new RequestBody();
        $body->write(json_encode($requestParameters));

        return new Request(
            $method,
            Uri::createFromEnvironment($env),
            Headers::createFromEnvironment($env),
            [],
            $env->all(),
            $body
        );
    }
}