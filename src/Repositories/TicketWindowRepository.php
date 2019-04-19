<?php

namespace App\Repositories;

use Doctrine\DBAL\Connection;

class TicketWindowRepository
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(int $id)
    {

    }

    public function findAll()
    {

    }
}
