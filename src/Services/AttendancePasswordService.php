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
use App\Repositories\UserRepository;
use Doctrine\DBAL\Connection;
use DomainException;
use Exception;
use InvalidArgumentException;

class AttendancePasswordService
{
    protected $connection;

    protected $repository;

    protected $categoryRepository;

    protected $statusRepository;

    protected $ticketWindowRepository;

    protected $userRepository;

    public function __construct(Connection $connection,
                                AttendancePasswordRepository $repository,
                                AttendancePasswordCategoryRepository $categoryRepository,
                                AttendanceStatusRepository $statusRepository,
                                TicketWindowRepository $windowRepository,
                                UserRepository $userRepository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->statusRepository = $statusRepository;
        $this->ticketWindowRepository = $windowRepository;
        $this->userRepository = $userRepository;
    }

    public function attendPassword(array $parameters)
    {
        if (empty($parameters['userId']) || empty($parameters['ticketWindowId'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->userRepository->find($parameters['userId']);

        try {

            $fetchCurrentAttendance = $this->repository->findInProgressAttendanceByUserId(
                $userEntity->getId()
            );

            if (!empty($fetchCurrentAttendance)) {
                throw new DomainException(
                    'O usuário já possui um atendimento em andamento.', 400);
            }

        } catch (NotFoundException $notFoundException) {

            $passwordEntity = $this->repository->findFirstAwaitingAttendance();

            $ticketWindowEntity = $this->ticketWindowRepository->find(
                $parameters['ticketWindowId']
            );

            $statusEntity = $this->statusRepository->findFirstByCode(
                Status\InProgressStatus::CODE
            );

            $passwordEntity->setTicketWindow($ticketWindowEntity);
            $passwordEntity->setStatus($statusEntity);

            $passwordEntity->setUser($userEntity);

            $this->connection->beginTransaction();

            $this->connection->update(
                $this->repository->getTableName(),
                [
                    'id_ticket_window' => $passwordEntity->getTicketWindow()->getId(),
                    'id_status' => $passwordEntity->getStatus()->getId(),
                    'id_user' => $userEntity->getId()
                ],
                [ 'id' => $passwordEntity->getId() ]
            );

            $this->connection->commit();

            return Formatter::fromObjectToArray($passwordEntity);
        }
    }

    public function cancelPassword(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $passwordEntity = $this->repository->find($parameters['id']);

        $statusEntity = $this->statusRepository->findFirstByCode(
            Status\CanceledStatus::CODE
        );

        $passwordEntity->setStatus($statusEntity);

        $this->connection->beginTransaction();

        $this->connection->update(
            $this->repository->getTableName(),
            [
                'id_status' => $passwordEntity->getStatus()->getId()
            ],
            [ 'id' => $passwordEntity->getId() ]
        );

        $this->connection->commit();
    }

    public function concludePassword(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $passwordEntity = $this->repository->find($parameters['id']);

        $statusEntity = $this->statusRepository->findFirstByCode(
            Status\CompletedStatus::CODE
        );

        $passwordEntity->setStatus($statusEntity);

        $this->connection->beginTransaction();

        $this->connection->update(
            $this->repository->getTableName(),
            [
                'id_status' => $passwordEntity->getStatus()->getId()
            ],
            [ 'id' => $passwordEntity->getId() ]
        );

        $this->connection->commit();
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
                'id_status' => $passwordEntity->getStatus()->getId(),
                'creation_date' => $passwordEntity->getCreationDate()->format('Y-m-d H:i:s O')
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

    public function retrieve10LastFinishedAttendances()
    {
        $passwordsEntities = $this->repository->find10LastFinishedAttendances();

        return Formatter::fromObjectToArray($passwordsEntities);
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

    public function retrieveInProgressUserAttendance(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                "Parametros necessários não preenchidos.", 400);
        }

        $passwordsEntities = $this->repository->findInProgressAttendanceByUserId($parameters['id']);

        return Formatter::fromObjectToArray($passwordsEntities);
    }

    public function retrieveLastInProgressAttendance()
    {
        $passwordsEntity = $this->repository->findLastInProgressAttendance();

        return Formatter::fromObjectToArray($passwordsEntity);
    }
}
