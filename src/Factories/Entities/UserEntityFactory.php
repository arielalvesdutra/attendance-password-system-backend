<?php

namespace App\Factories\Entities;

use App\Entities\User;

class UserEntityFactory
{

    public static function create(string $name, string $email, string $password,
                                  int $id = null): User
    {

        return (new User($id))
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password);
    }

    public static function createFromFetchAllArray(array $records): array
    {
        $entitiesArray = [];

        foreach ($records as $record) {
            $entitiesArray[] = UserEntityFactory::create(
                $record['name'],
                $record['email'],
                $record['password'],
                $record['id']
            );
        }

        return $entitiesArray;
    }
}
