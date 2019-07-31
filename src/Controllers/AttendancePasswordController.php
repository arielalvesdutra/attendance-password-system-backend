<?php

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\AttendancePasswordService;
use App\Strategies\JWTStrategy;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AttendancePasswordController extends AbstractController
{
    protected $jwtStrategy;

    /**
     * @var AttendancePasswordService
     */
    protected $service;

    public function __construct($service, JWTStrategy $jwtStrategy)
    {
        $this->service = $service;
        $this->jwtStrategy = $jwtStrategy;
    }

    public function attendPassword(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $attendancePassword = $this->service->attendPassword($parameters);

            return $response->withJson($attendancePassword, 200);

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

            $decodedToken =
                $this->jwtStrategy->decode($request->getHeaderLine('Authorization'));

            $parameters['user_id'] = $decodedToken['id'];

            $attendancePasswords = $this->service->retrieveAwaitingAttendances($parameters);

            return $response->withJson($attendancePasswords, 200);

        } catch (NotFoundException $notFoundException) {

            return $response->withJson([], $notFoundException->getCode());

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), 400);
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


    public function retrieveInProgressUserAttendance(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $attendancePasswords = $this->service->retrieveInProgressUserAttendance($parameters);

            return $response->withJson($attendancePasswords, 200);

        } catch (NotFoundException $notFoundException) {

            return $response->withJson([], 200);
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
