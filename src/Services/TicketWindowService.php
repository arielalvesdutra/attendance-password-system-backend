<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Formatters\Formatter;
use App\Repositories\TicketWindowRepository;
use App\Factories\Entities\TicketWindowEntityFactory;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;

class TicketWindowService
{
    protected $connection;

    protected $repository;

    public function __construct(Connection $connection,
                                TicketWindowRepository $repository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
    }

    public function createTicketWindow(array $parameters)
    {
        if (empty($parameters['name'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.', 400);
        }

        $ticketWindowEntity = TicketWindowEntityFactory::create($parameters['name']);

        try {

            $ticketEntity =
                $this->repository->findByName($ticketWindowEntity->getName());

            if (!empty($ticketEntity)) {

                throw new Exception("Já existe um registro com o mesmo nome", 400);
            }
        } catch (NotFoundException $notFoundException) {

            $this->connection->beginTransaction();

            $this->connection->insert(
                $this->repository->getTableName(),
                [ 'name' => $ticketWindowEntity->getName() ]
            );

            $this->connection->commit();
        }
    }

    public function deleteTicketWindow(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $ticketWindowEntity = $this->repository->find($parameters['id']);

        $this->connection->beginTransaction();

        $this->connection->delete(
            $this->repository->getTableName(),
            [ 'id' => $ticketWindowEntity->getId() ]
        );

        $this->connection->commit();
    }

    public function retrieveTicketWindow(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }

        $ticketWindowEntity = $this->repository->find($parameters['id']);

        return Formatter::fromObjectToArray($ticketWindowEntity);
    }

    public function retrieveAllTicketWindow()
    {
        $ticketWindowEntities = $this->repository->findAll();

        return Formatter::fromObjectToArray($ticketWindowEntities);
    }
}
