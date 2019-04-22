<?php

namespace App\Controllers;

use App\Services\AttendancePasswordCategoryService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AttendancePasswordCategoryController extends AbstractController
{
    /**
     * @var AttendancePasswordCategoryService
     */
    protected $service;

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();

            $this->service->createAttendanceCategory($parameters);

            return $response->withStatus(201);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $this->service->deleteAttendanceCategory($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieve(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters['id'] = $request->getAttribute('id');

            $attendanceCategories = $this->service->retrieveAttendanceCategory($parameters);

            return $response->withJson($attendanceCategories, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function retrieveAll(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $attendanceCategories = $this->service->retrieveAllAttendanceCategories();

            return $response->withJson($attendanceCategories, 200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $parameters = $request->getParsedBody();
            $parameters['id'] = $request->getAttribute('id');

            $this->service->updateAttendanceCategory($parameters);

            return $response->withStatus(200);

        } catch (Exception $exception) {
            return $response->withJson($exception->getMessage(), $exception->getCode());
        }
    }
}
