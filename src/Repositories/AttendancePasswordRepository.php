<?php

namespace App\Repositories;

use App\Entities\AttendanceStatus;
use App\Entities\Status\InProgressStatus;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\AttendancePasswordEntityFactory;
use Doctrine\DBAL\Connection;

class AttendancePasswordRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'attendance_passwords';

    public function fetchAmountByCategoryId(int $categoryId)
    {
        $amountByCategoryId = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'ap')
            ->where('ap.id_category = ' . $categoryId)
            ->execute()
            ->rowCount();

        return $amountByCategoryId;
    }

    public function find(int $id)
    {

        $attendancePasswordRecord = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'ap')
            ->where('ap.id = ' . $id)
            ->execute()
            ->fetch();

        if (empty($attendancePasswordRecord)) {
            throw new NotFoundException('Nenhum registro de senha de atendimento encontrado');
        }


        $categoryRepository = new AttendancePasswordCategoryRepository($this->connection);
        $categoryEntity = $categoryRepository->find(
            $attendancePasswordRecord['id_category']
        );

        $statusRepository = new AttendanceStatusRepository($this->connection);
        $statusEntity = $statusRepository->find(
            $attendancePasswordRecord['id_status']
        );

        $ticketWindowRepository =  new TicketWindowRepository($this->connection);
        $ticketWindowEntity = null;

        if ($attendancePasswordRecord['id_ticket_window']) {
            $ticketWindowEntity = $ticketWindowRepository->find(
                $attendancePasswordRecord['id_ticket_window']
            );
        }

        $attendancePasswordEntity = AttendancePasswordEntityFactory::create(
            $attendancePasswordRecord['name'],
            $categoryEntity,
            $statusEntity,
            $ticketWindowEntity,
            $attendancePasswordRecord['id'],
        );

        return $attendancePasswordEntity;
    }

    public function findAll()
    {
        $attendancePasswordRecords = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'ap')
            ->orderBy('ap.name')
            ->execute()
            ->fetchAll();

        if (empty($attendancePasswordRecords)) {
            throw new NotFoundException('Nenhum registro de senha de atendimento encontrado');
        }

        $attendancePasswordEntities = [];

        $categoryRepository = new AttendancePasswordCategoryRepository($this->connection);
        $statusRepository = new AttendanceStatusRepository($this->connection);
        $ticketWindowRepository =  new TicketWindowRepository($this->connection);

        foreach ($attendancePasswordRecords as $attendancePasswordRecord) {
            $categoryEntity = $categoryRepository->find(
                $attendancePasswordRecord['id_category']
            );

            $statusEntity = $statusRepository->find(
                $attendancePasswordRecord['id_status']
            );

            $ticketWindowEntity = null;

            if ($attendancePasswordRecord['id_ticket_window']) {
                $ticketWindowEntity = $ticketWindowRepository->find(
                    $attendancePasswordRecord['id_ticket_window']
                );
            }

            $attendancePasswordEntities[] = AttendancePasswordEntityFactory::create(
                $attendancePasswordRecord['name'],
                $categoryEntity,
                $statusEntity,
                $ticketWindowEntity,
                $attendancePasswordRecord['id'],
            );
        }

        return $attendancePasswordEntities;
    }

    public function findAttendancesInProgress()
    {
        $statusRepository = new AttendanceStatusRepository($this->connection);

        $attendancePasswordRecords = $this->connection->createQueryBuilder()
            ->select('ap.*')
            ->from($this->getTableName(), 'ap')
            ->innerJoin('ap', $statusRepository->getTableName(), 'aps', 'ap.id_status = aps.id')
            ->where('aps.code = ?')
            ->setParameter(0, InProgressStatus::CODE)
            ->execute()
            ->fetchAll();

        if (empty($attendancePasswordRecords)) {
            throw new NotFoundException('Nenhum registro de senha de atendimento encontrado');
        }

        $attendancePasswordEntities = [];

        $categoryRepository = new AttendancePasswordCategoryRepository($this->connection);
        $ticketWindowRepository =  new TicketWindowRepository($this->connection);

        foreach ($attendancePasswordRecords as $attendancePasswordRecord) {
            $categoryEntity = $categoryRepository->find(
                $attendancePasswordRecord['id_category']
            );

            $statusEntity = $statusRepository->find(
                $attendancePasswordRecord['id_status']
            );

            $ticketWindowEntity = null;

            if ($attendancePasswordRecord['id_ticket_window']) {
                $ticketWindowEntity = $ticketWindowRepository->find(
                    $attendancePasswordRecord['id_ticket_window']
                );
            }

            $attendancePasswordEntities[] = AttendancePasswordEntityFactory::create(
                $attendancePasswordRecord['name'],
                $categoryEntity,
                $statusEntity,
                $ticketWindowEntity,
                $attendancePasswordRecord['id'],
            );
        }

        return $attendancePasswordEntities;
    }
}
