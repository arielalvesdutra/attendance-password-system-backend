<?php

namespace App\Repositories;

use App\Factories\Entities\TicketWindowUseEntityFactory;
use App\Exceptions\NotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class TicketWindowUseRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'ticket_window_use';

    public function retrieveUnusedTicketWindow()
    {
        $usedTicketWindowIds = $this->connection->createQueryBuilder()
            ->select("id_ticket_window")
            ->from($this->getTableName(), 'twu')
            ->execute()
            ->fetchAll(FetchMode::COLUMN);

        $ticketWindowRepository = new TicketWindowRepository($this->connection);

        $unusedTicketWindow = $ticketWindowRepository->findNotIn(
            $usedTicketWindowIds
        );

        return $unusedTicketWindow;
    }

    public function findFirstByUserOrTicketWindowId(int $userId, int $ticketWindowId)
    {
        $ticketWindowUseRecord = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'twu')
            ->where( "twu.id_user = :id_user")
            ->setParameter(':id_user', $userId)
            ->orWhere('twu.id_ticket_window = :id_ticket_window')
            ->setParameter(':id_ticket_window',$ticketWindowId)
            ->execute()
            ->fetch();

        if (empty($ticketWindowUseRecord)) {
            throw new NotFoundException('Nenhum registro de uso de guichê encontrado');
        }

        $ticketWindowRepository = new TicketWindowRepository($this->connection);
        $userRepository = new UserRepository($this->connection);

        $userEntity = TicketWindowUseEntityFactory::create(
            $ticketWindowRepository->find(
                $ticketWindowUseRecord['id_ticket_window']
            ),
            $userRepository->find(
                $ticketWindowUseRecord['id_user']
            )
        );

        return $userEntity;
    }
}
