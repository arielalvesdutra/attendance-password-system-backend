<?php

namespace App\Controllers;

use App\Services\AttendancePasswordService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AttendancePasswordController extends AbstractController
{
    /**
     * @var AttendancePasswordService
     */
    protected $service;

    public function attendPassword(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();
            $parameters['id'] = $request->getAttribute('id');

            $this->service->attendPassword($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function cancelPassword(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $this->service->cancelPassword($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function concludePassword(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $this->service->concludePassword($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->createAttendancePassword($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $this->service->deleteAttendancePassword($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieve(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $attendancePasswordRecord = $this->service->retrieveAttendancePassword($parameters);

            return $response->withJson($attendancePasswordRecord, 200);

        } catch (Exception $exception) {

            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieve10LastFinished(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $attendancePasswords =
                $this->service->retrieve10LastFinishedAttendances();

            return $response->withJson($attendancePasswords, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $attendancePasswords = $this->service->retrieveAllAttendancePasswords();

            return $response->withJson($attendancePasswords, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveAwaiting(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $attendancePasswords = $this->service->retrieveAwaitingAttendances();

            return $response->withJson($attendancePasswords, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveInProgress(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $attendancePasswords = $this->service->retrieveInProgressAttendances();

            return $response->withJson($attendancePasswords, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveLastInProgress(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $attendancePassword = $this->service->retrieveLastInProgressAttendance();

            return $response->withJson($attendancePassword, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
