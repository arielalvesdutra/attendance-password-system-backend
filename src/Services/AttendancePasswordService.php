<?php

namespace App\Services;

use App\Entities\Status;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\AttendancePasswordEntityFactory;
use App\Formatters\Formatter;
use App\Repositories\AttendancePasswordRepository;
use App\Repositories\AttendancePasswordCategoryRepository;
use App\Repositories\AttendanceStatusRepository;
use App\Repositories\TicketWindowRepository;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;

class AttendancePasswordService
{
    protected $connection;

    protected $repository;

    protected $categoryRepository;

    protected $statusRepository;

    protected $ticketWindowRepository;

    public function __construct(Connection $connection,
                                AttendancePasswordRepository $repository,
                                AttendancePasswordCategoryRepository $categoryRepository,
                                AttendanceStatusRepository $statusRepository,
                                TicketWindowRepository $windowRepository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->statusRepository = $statusRepository;
        $this->ticketWindowRepository = $windowRepository;
    }

    public function createAttendancePassword(array $parameters)
    {
        if (empty($parameters['categoryId'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.', 400);
        }

        $categoryEntity = $this->categoryRepository->find($parameters['categoryId']);
        $statusEntity = $this->statusRepository->findFirstByCode(
            Status\CreatedStatus::CODE
        );

        $amountOfPasswordByCategory =
            $this->repository->fetchAmountByCategoryId($categoryEntity->getId());

        $passwordEntity = AttendancePasswordEntityFactory::createNewAttendancePassword(
            $categoryEntity,
            $statusEntity,
            $amountOfPasswordByCategory
        );

        $this->connection->beginTransaction();

        $this->connection->insert(
            $this->repository->getTableName(),
            [
                'name' => $passwordEntity->getName(),
                'id_category' => $passwordEntity->getCategory()->getId(),
                'id_status' => $passwordEntity->getStatus()->getId()
            ]
        );

        $this->connection->commit();
    }

    public function deleteAttendancePassword(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                "Parametros necessários não preenchidos.", 400);
        }

        $attendancePasswordEntity = $this->repository->find($parameters['id']);

        $this->connection->beginTransaction();

        $this->connection->delete(
          $this->repository->getTableName(),
          [ 'id' => $attendancePasswordEntity->getId() ]
        );

        $this->connection->commit();
    }

    public function retrieveAttendancePassword(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.', 400);
        }

        $passwordEntity = $this->repository->find($parameters['id']);

        return Formatter::fromObjectToArray($passwordEntity);
    }

    public function retrieveAllAttendancePasswords()
    {
        $passwordsEntities = $this->repository->findAll();

        return Formatter::fromObjectToArray($passwordsEntities);
    }

    public function retrieveAwaitingAttendances()
    {
        $passwordsEntities = $this->repository->findAwaitingAttendances();

        return Formatter::fromObjectToArray($passwordsEntities);
    }

    public function retrieveInProgressAttendances()
    {
        $passwordsEntities = $this->repository->findInProgressAttendances();

        return Formatter::fromObjectToArray($passwordsEntities);
    }
}
