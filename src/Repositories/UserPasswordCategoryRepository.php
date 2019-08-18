<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use Doctrine\DBAL\Connection;

/**
 * Classe que representa o repositório de relação entre o usuário e
 * as categorias de senha de atendimento que ele tem permissão.
 *
 * Class UserPasswordCategoryRepository
 * @package App\Repositories
 */
class UserPasswordCategoryRepository extends AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    protected $tableName = 'user_password_category';

    /**
     * Busca as Categorias de Senha que o usuário possui permissão.
     *
     * @param int $userId
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function findPasswordCategoriesByUserId(int $userId)
    {
        $categoryRepository = new AttendancePasswordCategoryRepository($this->connection);

        $categoriesIds = $this->connection->createQueryBuilder()
            ->select('upc.password_category_id')
            ->from($this->getTableName(), 'upc')
            ->where('upc.user_id = :user_id')
            ->setParameter(':user_id', $userId)
            ->execute()
            ->fetchAll();

        if (empty($categoriesIds)) {
            throw new NotFoundException('O usuário não possui categorias de senha vinculadas');
        }

        $passwordCategories = [];

        foreach ($categoriesIds as $categoryId) {
            $passwordCategories[$categoryId['password_category_id']] =
                $categoryRepository->find($categoryId['password_category_id']);
        }

        return $passwordCategories;
    }
}
