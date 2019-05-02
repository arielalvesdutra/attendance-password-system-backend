<?php

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\UserService;
use App\Strategies\JWTStrategy;
use Exception;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AbstractController
{
    /**
     * @var UserService
     */
    protected $service;

    public function signIn(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $jwtStrategy = new JWTStrategy();

            $secret = $jwtStrategy->getSecret();

            $user = $this->service->retrieveUserByEmailAndPassword($parameters);

            $payload = [
                'id' => $user['id'],
                'name'  => $user['name'],
                'email'  => $user['email'],
                'iet' => time(),
                'exp' => $jwtStrategy->getTimestamp60MinutesForward()
            ];

            $token = JWT::encode($payload, $secret);

            return $response->withJson([
                'payload' => $payload,
                'token' => $token
            ], 200);

        } catch (NotFoundException $notFoundException) {

            return $response->withJson('Email ou senha inválido!', 400);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), 400);
        }
    }
}
