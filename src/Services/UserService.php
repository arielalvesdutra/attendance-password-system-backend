<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Factories\Entities\UserEntityFactory;
use App\Formatters\Formatter;
use App\Repositories\AttendancePasswordCategoryRepository;
use App\Repositories\UserPasswordCategoryRepository;
use App\Repositories\UserRepository;
use Doctrine\DBAL\Connection;
use Exception;
use InvalidArgumentException;
use OutOfBoundsException;

class UserService
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var AttendancePasswordCategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserPasswordCategoryRepository
     */
    protected $userPasswordCategoryRepository;

    public function __construct(
        Connection $connection,
        UserRepository $repository,
        AttendancePasswordCategoryRepository $categoryRepository,
        UserPasswordCategoryRepository $userPasswordCategoryRepository
    ) {
        $this->connection = $connection;
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->userPasswordCategoryRepository = $userPasswordCategoryRepository;
    }

    /**
     * @param array $parameters
     *
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     */
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

    /**
     * @param array $parameters
     *
     * @throws NotFoundException
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
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

    /**
     * @return array
     *
     * @throws NotFoundException
     */
    public function retrieveAllUsers()
    {
        $userEntities = $this->repository->findAll();

        return Formatter::fromObjectToArray($userEntities);
    }

    /**
     * @param array $parameters
     * @return array
     *
     * @throws NotFoundException
     */
    public function retrieveUser(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->find($parameters['id']);

        return Formatter::fromObjectToArray($userEntity);
    }

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotFoundException
     */
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

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotFoundException
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateUser(array $parameters)
    {
        if (empty($parameters['id'])) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->find($parameters['id']);

        $dataToUpdate = [];

        if (!empty($parameters['name'])) {
            $userEntity->setName($parameters['name']);
            $dataToUpdate['name'] = $userEntity->getName();
        }

        if (!empty($parameters['password'])) {
            $userEntity->setPassword($parameters['password']);
            $dataToUpdate['password'] = $userEntity->getPassword();
        }

        if (isset($parameters['admin'])) {
            $userEntity->setAdmin($parameters['admin']);
            $dataToUpdate['admin'] = $userEntity->getAdmin();
        }

        $this->connection->beginTransaction();

        $this->connection->update(
          $this->repository->getTableName(),
            $dataToUpdate,
            [ 'id' => $userEntity->getId() ]
        );

        $this->connection->commit();

        return Formatter::fromObjectToArray($userEntity);
    }

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws Exception
     * @throws NotFoundException
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function updateUserAllowedPasswordCategories(array $parameters)
    {
        if (
            empty($parameters['id']) ||
            !isset($parameters['allowedPasswordCategories'])
        ) {
            throw new InvalidArgumentException(
                'Parametros necessários não preenchidos.', 400);
        }

        $userEntity = $this->repository->find($parameters['id']);

        $passwordCategories = [];

        foreach ($parameters['allowedPasswordCategories'] as $passwordCategory) {
            $passwordCategories[$passwordCategory['id']] =
                    $this->categoryRepository->find($passwordCategory['id']);
        }

        try {

            $userEntity->setAllowedPasswordCategories($passwordCategories);

        } catch (InvalidArgumentException $invalidArgumentException) {}

        $dataToDelete = [
          'user_id' => $userEntity->getId()
        ];

        $this->connection->beginTransaction();

        $this->connection->delete(
            $this->userPasswordCategoryRepository->getTableName(),
            $dataToDelete
        );

        try {

            foreach ($userEntity->getAllowedPasswordCategories() as $allowedPasswordCategory) {

                $this->connection->insert(
                    $this->userPasswordCategoryRepository->getTableName(),
                    [
                        'user_id' => $userEntity->getId(),
                        'password_category_id' => $allowedPasswordCategory->getId()
                    ]
                );
            }
        } catch (OutOfBoundsException $outOfBoundsException) {}

        $this->connection->commit();

        return Formatter::fromObjectToArray($userEntity->getAllowedPasswordCategories());
    }
}
