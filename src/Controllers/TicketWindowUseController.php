<?php

namespace App\Controllers;

use App\Services\TicketWindowUseService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TicketWindowUseController extends AbstractController
{
    /**
     * @var TicketWindowUseService
     */
    protected $service;

    public function use(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->useTicketWindow($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function release(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->releaseTicketWindow($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveUnused(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $unusedTicketWindow = $this->service->retrieveUnusedTicketWindow();

            return $response->withJson($unusedTicketWindow,200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
