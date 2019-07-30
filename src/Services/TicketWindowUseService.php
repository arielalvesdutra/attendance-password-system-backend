<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Formatters\Formatter;
use App\Repositories\TicketWindowRepository;
use App\Repositories\TicketWindowUseRepository;
use App\Repositories\UserRepository;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;

class TicketWindowUseService
{
    protected $connection;

    protected $repository;

    protected $ticketWindowRepository;

    protected $userRepository;

    public function __construct(Connection $connection,
                                TicketWindowUseRepository $repository,
                                TicketWindowRepository $ticketWindowRepository,
                                UserRepository $userRepository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
        $this->ticketWindowRepository = $ticketWindowRepository;
        $this->userRepository = $userRepository;
    }

    public function useTicketWindow(array $parameters)
    {
        if (empty($parameters['userId']) || empty($parameters['ticketWindowId'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->userRepository->find($parameters['userId']);

        $ticketWindowEntity = $this->ticketWindowRepository->find(
            $parameters['ticketWindowId']
        );

        try {
            $fetchedEntity = $this->repository->findFirstByUserOrTicketWindowId(
              $userEntity->getId(),
              $ticketWindowEntity->getId()
            );

            if (!empty($fetchedEntity)) {

                throw new Exception(
                    "O guichê selecionado já está em uso ou o usuário já está em um guichê.", 400);
            }

        } catch (NotFoundException $notFoundException) {

            $this->connection->beginTransaction();

            $this->connection->insert(
              $this->repository->getTableName(),
              [
                  'id_user' => $userEntity->getId(),
                  'id_ticket_window' => $ticketWindowEntity->getId()
              ]
            );

            $this->connection->commit();
        }
    }

    public function releaseTicketWindow(array $parameters)
    {
        if (empty($parameters['userId']) || empty($parameters['ticketWindowId'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->userRepository->find($parameters['userId']);

        $ticketWindowEntity = $this->ticketWindowRepository->find(
            $parameters['ticketWindowId']
        );

        $fetchedEntity = $this->repository->findFirstByUserOrTicketWindowId(
            $userEntity->getId(),
            $ticketWindowEntity->getId()
        );

        $this->connection->beginTransaction();

        $this->connection->delete(
            $this->repository->getTableName(),
            [
                'id_user' => $fetchedEntity->getUser()->getId(),
                'id_ticket_window' => $fetchedEntity->getTicketWindow()->getId()
            ]
        );

        $this->connection->commit();
    }

    public function retrieveUnusedTicketWindow()
    {
        $unusedTicketWindow = $this->repository->findUnusedTicketWindow();

        return Formatter::fromObjectToArray($unusedTicketWindow);
    }

    /**
     * @param array $parameters
     * @return array
     *
     * @throws NotFoundException
     */
    public function retrieveUserTicketWindow(array $parameters)
    {
        $unusedTicketWindow = $this->repository->findUserTicketWindow($parameters['id_user']);

        return  Formatter::fromObjectToArray($unusedTicketWindow);
    }
}
