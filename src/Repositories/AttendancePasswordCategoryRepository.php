<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\AttendancePasswordCategoryEntityFactory;
use Doctrine\DBAL\Connection;

class AttendancePasswordCategoryRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'attendance_password_categories';

    public function find(int $id)
    {
        $attendanceCategoryRecord = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'apc')
            ->where('apc.id = ' . $id)
            ->orderBy('apc.name')
            ->execute()
            ->fetch();

        if (empty($attendanceCategoryRecord)) {
            throw new NotFoundException('Nenhum registro de categoria de atendimento encontrado');
        }

        $attendanceCategoryEntity = AttendancePasswordCategoryEntityFactory::create(
            $attendanceCategoryRecord['name'],
            $attendanceCategoryRecord['code'],
            $attendanceCategoryRecord['id']
        );

        return $attendanceCategoryEntity;
    }

    public function findAll()
    {
        $attendanceCategoriesRecords = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'apc')
            ->orderBy('apc.name')
            ->execute()
            ->fetchAll();

        if (empty($attendanceCategoriesRecords)) {
            throw new NotFoundException('Nenhum registro de categoria de atendimento encontrado');
        }

        $attendanceCategoriesEntities =
            AttendancePasswordCategoryEntityFactory::createFromFetchAllArray(
                $attendanceCategoriesRecords
            );

        return $attendanceCategoriesEntities;
    }

    public function findByNameOrCode(string $name, string $code)
    {
        $attendanceCategories = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'apc')
            ->where('apc.name = ?')
            ->setParameter('0', $name)
            ->orWhere('apc.code = ?')
            ->setParameter('1', $code)
            ->execute()
            ->fetchAll();

        if (empty($attendanceCategories)) {
            throw new NotFoundException("Nenhuma registro categoria de atendimento encontrado.");
        }

        $categoriesEntities =
            AttendancePasswordCategoryEntityFactory::createFromFetchAllArray(
                $attendanceCategories
        );

        return $categoriesEntities;
    }
}
