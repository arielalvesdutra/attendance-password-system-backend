<?php

namespace App\Services;

use App\Repositories\TicketWindowRepository;
use Doctrine\DBAL\Connection;
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
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }


    }

    public function deleteTicketWindow(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }
    }

    public function retrieveTicketWindow(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException('Parametros necessários não preenchidos.');
        }
    }

    public function retrieveAllTicketWindow()
    {
        $ticketWindowEntities = $this->repository->findAll();
    }
}