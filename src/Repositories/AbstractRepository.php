<?php

namespace App\Repositories;


use Doctrine\DBAL\Connection;
use DomainException;

abstract class AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $tableName;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function getTableName()
    {
        if (!empty($this->tableName)) {
            return $this->tableName;
        }

        throw new DomainException('Nome não definido para a tabela.');
    }
}