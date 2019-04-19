<?php

namespace App\Controllers;

use App\Services\AttendanceStatusService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AttendanceStatusController extends AbstractController
{
    /**
     * @var AttendanceStatusService
     */
    protected $service;

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->createAttendanceStatus($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $this->service->deleteAttendanceStatus($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieve(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $attendanceStatusRecord = $this->service->retrieveAttendanceStatus($parameters);

            return $response->withJson($attendanceStatusRecord, 200);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $ticketWindowRecords = $this->service->retrieveAllAttendanceStatus();

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

            $this->service->updateAttendanceStatus($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
