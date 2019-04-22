<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\AttendancePasswordCategoryEntityFactory;
use App\Formatters\Formatter;
use App\Repositories\AttendancePasswordCategoryRepository;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;

class AttendancePasswordCategoryService
{
    protected $connection;

    protected $repository;

    public function __construct(Connection $connection,
                                AttendancePasswordCategoryRepository $repository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
    }

    public function createAttendanceCategory(array $parameters)
    {
        if (empty($parameters['name']) || empty($parameters['code'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $attendanceCategoryEntity = AttendancePasswordCategoryEntityFactory::create(
          $parameters['name'],
          $parameters['code']
        );

        try {

            $fetchedEntity = $this->repository->findByNameOrCode(
                $attendanceCategoryEntity->getName(),
                $attendanceCategoryEntity->getCode()
            );

            if (!empty($fetchedEntity)) {
                throw new Exception(
                    "Já existe um registro com o mesmo nome ou código.", 400);
            }
        } catch (NotFoundException $notFoundException) {

            $this->connection->beginTransaction();

            $this->connection->insert(
              $this->repository->getTableName(),
              [
                  'name' => $attendanceCategoryEntity->getName(),
                  'code' => $attendanceCategoryEntity->getCode()
              ]
            );

            $this->connection->commit();
        }
    }

    public function deleteAttendanceCategory(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $attendanceCategoryEntity = $this->repository->find($parameters['id']);

        $this->connection->beginTransaction();

        $this->connection->delete(
            $this->repository->getTableName(),
            [ 'id' => $attendanceCategoryEntity->getId() ]
        );

        $this->connection->commit();
    }

    public function retrieveAttendanceCategory(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $attendanceCategoryEntity = $this->repository->find($parameters['id']);

        return Formatter::fromObjectToArray($attendanceCategoryEntity);
    }

    public function retrieveAllAttendanceCategories()
    {
        $categoriesEntities = $this->repository->findAll();

        return Formatter::fromObjectToArray($categoriesEntities);
    }

    public function updateAttendanceCategory(array $parameters)
    {
        if (empty($parameters['id']) ||
            empty($parameters['name']) ||
            empty($parameters['code'])
        ) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $attendanceCategoryEntity = $this->repository->find($parameters['id']);

        $attendanceCategoryEntity->setName($parameters['name']);
        $attendanceCategoryEntity->setCode($parameters['code']);

        $this->connection->beginTransaction();

        $this->connection->update(
            $this->repository->getTableName(),
            [
                'name' => $attendanceCategoryEntity->getName(),
                'code' => $attendanceCategoryEntity->getCode()
            ],
            [ 'id' => $attendanceCategoryEntity->getId() ]
        );

        $this->connection->commit();
    }
}
