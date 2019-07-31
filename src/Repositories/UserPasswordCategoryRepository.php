<?php

namespace App\Repositories;

use Doctrine\DBAL\Connection;

/**
 * Classe que representa o repositório de relação entre o usuário e
 * as categorias de senha de atendimento que ele tem acesso.
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
}
