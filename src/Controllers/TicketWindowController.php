<?php

namespace App\Controllers;

use App\Services\TicketWindowService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TicketWindowController extends AbstractController
{
    /**
     * @var TicketWindowService
     */
    protected $service;

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->createTicketWindow($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}