<?php

namespace App\Controllers;

use App\Services\UserService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends AbstractController
{
    /**
     * @var UserService
     */
    protected $service;

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->createUser($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $this->service->deleteUser($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieve(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $ticketWindowRecords = $this->service->retrieveUser($parameters);

            return $response->withJson($ticketWindowRecords, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $ticketWindowRecords = $this->service->retrieveAllUsers();

            return $response->withJson($ticketWindowRecords, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();
            $parameters['id'] = $request->getAttribute('id');

            $this->service->updateUser($parameters);

            return $response->withStatus( 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
