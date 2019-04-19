<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class TicketWindowRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'ticket_window';

    public function find(int $id)
    {
        $ticketWindowEntity = $this->connection->createQueryBuilder()
            ->select()
            ->from($this->getTableName(), 'tw')
            ->where('tw.id = ' . $id)
            ->orderBy('tw.name')
            ->execute()
            ->fetch();

        if (empty($ticketWindowEntity)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        return $ticketWindowEntity;
    }

    public function findAll()
    {
        $ticketWindowEntities = $this->connection->createQueryBuilder()
            ->select()
            ->from($this->getTableName(), 'tw')
            ->orderBy('tw.name')
            ->execute()
            ->fetchAll();

        if (empty($ticketWindowEntities)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        return $ticketWindowEntities;
    }

    public function findByName(string $name)
    {
        $ticketEntities = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'tw')
            ->where( "tw.name = ?")
            ->setParameter('0', $name)
            ->execute()
            ->fetchAll();

        if (empty($ticketEntities)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        return $ticketEntities;
    }
}
