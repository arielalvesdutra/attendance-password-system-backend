<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\TicketWindowEntityFactory;
use Doctrine\DBAL\Connection;

class TicketWindowRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'ticket_window';

    public function find(int $id)
    {
        $ticketWindowRecord = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'tw')
            ->where('tw.id = ' . $id)
            ->orderBy('tw.name')
            ->execute()
            ->fetch();

        if (empty($ticketWindowRecord)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        $ticketWindowEntity = TicketWindowEntityFactory::create(
            $ticketWindowRecord['name'],
            $ticketWindowRecord['id']
        );

        return $ticketWindowEntity;
    }

    public function findAll()
    {
        $ticketWindowRecords = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'tw')
            ->orderBy('tw.name')
            ->execute()
            ->fetchAll();

        if (empty($ticketWindowRecords)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        $ticketWindowEntities =
            TicketWindowEntityFactory::createFromFetchAllArray($ticketWindowRecords);

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
