<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\AttendanceStatusEntityFactory;
use App\Formatters\Formatter;
use App\Repositories\AttendanceStatusRepository;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;

class AttendanceStatusService
{
    protected $connection;

    protected $repository;

    public function __construct(Connection $connection,
                                AttendanceStatusRepository $repository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
    }

    public function createAttendanceStatus(array $parameters)
    {
        if (empty($parameters['name'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.', 400);
        }

        $attendanceStatusEntity = AttendanceStatusEntityFactory::create($parameters['name']);

        try {

            $fetchedEntity =
                $this->repository->findByName($attendanceStatusEntity->getName());

            if (!empty($fetchedEntity)) {

                throw new Exception("Já existe um registro com o mesmo nome", 400);
            }
        } catch (NotFoundException $notFoundException) {

            $this->connection->beginTransaction();

            $this->connection->insert(
                $this->repository->getTableName(),
                [ 'name' => $attendanceStatusEntity->getName() ]
            );

            $this->connection->commit();
        }
    }

    public function deleteAttendanceStatus(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $attendanceStatusEntity = $this->repository->find($parameters['id']);

        $this->connection->beginTransaction();

        $this->connection->delete(
            $this->repository->getTableName(),
            [ 'id' => $attendanceStatusEntity->getId() ]
        );

        $this->connection->commit();
    }

    public function retrieveAttendanceStatus(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $attendanceStatusEntity = $this->repository->find($parameters['id']);

        return Formatter::fromObjectToArray($attendanceStatusEntity);
    }

    public function retrieveAllAttendanceStatus()
    {
        $attendanceStatusEntities = $this->repository->findAll();

        return Formatter::fromObjectToArray($attendanceStatusEntities);
    }

    public function updateAttendanceStatus(array $parameters)
    {
        if (empty($parameters['id']) || empty($parameters['name'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $attendanceStatusEntity = $this->repository->find($parameters['id']);

        $attendanceStatusEntity->setName($parameters['name']);

        $this->connection->beginTransaction();

        $this->connection->update(
            $this->repository->getTableName(),
            [ 'name' => $attendanceStatusEntity->getName() ],
            [ 'id' => $attendanceStatusEntity->getId() ]
        );

        $this->connection->commit();
    }
}
