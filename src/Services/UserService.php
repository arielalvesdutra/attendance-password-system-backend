<?php

namespace App\Services;

use App\Entities\User;
use App\Exceptions\NotFoundException;
use App\Factories\Entities\UserEntityFactory;
use App\Formatters\Formatter;
use App\Repositories\UserRepository;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;

class UserService
{
    protected $connection;

    protected $repository;

    protected $categoryRepository;

    protected $statusRepository;

    protected $ticketWindowRepository;

    public function __construct(Connection $connection,
                                UserRepository $repository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
    }

    public function createUser(array $parameters)
    {
        if (
            empty($parameters['name']) ||
            empty($parameters['email']) ||
            empty($parameters['password'])
        ) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = UserEntityFactory::create(
            $parameters['name'],
            $parameters['email'],
            $parameters['password'],
        );

        try {

            $fetchedUser = $this->repository->findFirstByEmail(
                $parameters['email']
            );

            if (!empty($fetchedUser)) {

                throw new Exception("Já existe um registro com o mesmo email", 400);
            }

        } catch (NotFoundException $notFoundException) {
            $this->connection->beginTransaction();

            $this->connection->insert(
              $this->repository->getTableName(),
              [
                  'name' => $userEntity->getName(),
                  'email' => $userEntity->getEmail(),
                  'password' => $userEntity->getPassword(),
              ]
            );

            $this->connection->commit();
        }
    }

    public function deleteUser(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->find($parameters['id']);

        $this->connection->beginTransaction();

        $this->connection->delete(
            $this->repository->getTableName(),
            [ 'id' => $userEntity->getId() ]
        );

        $this->connection->commit();
    }
    public function retrieveAllUsers()
    {
        $userEntities = $this->repository->findAll();

        return Formatter::fromObjectToArray($userEntities);
    }


    public function retrieveUser(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->find($parameters['id']);

        return Formatter::fromObjectToArray($userEntity);
    }

    public function retrieveUserByEmailAndPassword(array $parameters)
    {
        if (empty($parameters['email']) || empty($parameters['password'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->findByEmailAndPassword(
            $parameters['email'],
            $parameters['password']
        );

        return Formatter::fromObjectToArray($userEntity);
    }

    public function updateUser(array $parameters)
    {
        if (
            empty($parameters['id']) ||
            empty($parameters['name']) ||
            empty($parameters['password'])
        ) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->find($parameters['id']);

        $userEntity->setName($parameters['name']);
        $userEntity->setPassword($parameters['password']);

        $this->connection->beginTransaction();

        $this->connection->update(
          $this->repository->getTableName(),
            [
                'name' => $userEntity->getName(),
                'password' => $userEntity->getPassword()
            ],
            [ 'id' => $userEntity->getId() ]
        );

        $this->connection->commit();
    }
}
