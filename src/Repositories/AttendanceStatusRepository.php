<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\AttendanceStatusEntityFactory;
use Doctrine\DBAL\Connection;

class AttendanceStatusRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'attendance_password_status';

    public function find(int $id)
    {
        $attendanceStatusRecord = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'aps')
            ->where('aps.id = ' . $id)
            ->orderBy('aps.name')
            ->execute()
            ->fetch();

        if (empty($attendanceStatusRecord)) {
            throw new NotFoundException('Nenhum registro de status de atendimento encontrado');
        }

        $attendanceStatusEntity = AttendanceStatusEntityFactory::create(
            $attendanceStatusRecord['name'],
            $attendanceStatusRecord['id']
        );

        return $attendanceStatusEntity;
    }

    public function findAll()
    {
        $attendanceStatusRecords = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'aps')
            ->orderBy('aps.name')
            ->execute()
            ->fetchAll();

        if (empty($attendanceStatusRecords)) {
            throw new NotFoundException('Nenhum registro de status de atendimento encontrado');
        }

        $attendanceStatusEntities =
            AttendanceStatusEntityFactory::createFromFetchAllArray($attendanceStatusRecords);

        return $attendanceStatusEntities;
    }

    public function findByName(string $name)
    {
        $attendanceRecords = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'aps')
            ->where( "aps.name = ?")
            ->setParameter('0', $name)
            ->execute()
            ->fetchAll();

        if (empty($attendanceRecords)) {
            throw new NotFoundException('Nenhum registro de status de atendimento encontrado');
        }

        $ticketEntities =
            AttendanceStatusEntityFactory::createFromFetchAllArray($attendanceRecords);

        return $ticketEntities;
    }
}
