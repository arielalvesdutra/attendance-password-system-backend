<?php

namespace App\Repositories;

use App\Factories\Entities\UserEntityFactory;
use App\Exceptions\NotFoundException;
use Doctrine\DBAL\Connection;

class UserRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'users';

    public function find(int $id)
    {
        $userRecord = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'u')
            ->where('u.id = ' . $id)
            ->execute()
            ->fetch();

        if (empty($userRecord)) {
            throw new NotFoundException('Nenhum registro de usuário encontrado');
        }

        $userEntity = UserEntityFactory::create(
            $userRecord['name'],
            $userRecord['email'],
            $userRecord['password'],
            $userRecord['id']
        );

        return $userEntity;
    }

    public function findAll()
    {
        $userRecords = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName(), 'u')
            ->orderBy('u.name')
            ->execute()
            ->fetchAll();

        if (empty($userRecords)) {
            throw new NotFoundException('Nenhum registro de usuário encontrado');
        }

        $userEntities = UserEntityFactory::createFromFetchAllArray(
            $userRecords
        );

        return $userEntities;
    }

    public function findFirstByEmail(string $email)
    {
        $userRecord = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'u')
            ->where( "u.email = :email")
            ->setParameter(':email', $email)
            ->execute()
            ->fetch();

        if (empty($userRecord)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        $userEntity = UserEntityFactory::create(
          $userRecord['name'],
          $userRecord['email'],
          $userRecord['password'],
          $userRecord['id']
        );

        return $userEntity;
    }
}
