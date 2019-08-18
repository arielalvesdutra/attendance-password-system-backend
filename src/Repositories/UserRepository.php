<?php

namespace App\Repositories;

use App\Entities\User;
use App\Factories\Entities\UserEntityFactory;
use App\Exceptions\NotFoundException;
use Doctrine\DBAL\Connection;
use Exception;

class UserRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'users';

    /**
     * @param int $id
     *
     * @return User
     *
     * @throws Exception
     * @throws NotFoundException
     */
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
            $userRecord['admin'],
            $userRecord['id']
        );

        $userPasswordCategoryRepository = new UserPasswordCategoryRepository($this->connection);

        try {

            $userPasswordCategories = $userPasswordCategoryRepository->findPasswordCategoriesByUserId($id);

            $userEntity->setAllowedPasswordCategories($userPasswordCategories);

        } catch (NotFoundException $notFoundException) {}

        return $userEntity;
    }

    /**
     * @return User[]
     *
     * @throws NotFoundException
     */
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

    /**
     * @param string $email
     *
     * @return User
     *
     * @throws NotFoundException
     */
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
          $userRecord['admin'],
          $userRecord['id']
        );

        return $userEntity;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     *
     * @throws NotFoundException
     */
    public function findByEmailAndPassword(string $email, string $password)
    {
        $userRecord = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->getTableName(), 'u')
            ->where( "u.email = :email")
            ->setParameter(':email', $email)
            ->andWhere('u.password = :password')
            ->setParameter(':password', $password)
            ->execute()
            ->fetch();

        if (empty($userRecord)) {
            throw new NotFoundException('Nenhum registro de guiche encontrado');
        }

        $userEntity = UserEntityFactory::create(
            $userRecord['name'],
            $userRecord['email'],
            $userRecord['password'],
            $userRecord['admin'],
            $userRecord['id']
        );

        return $userEntity;
    }
}
