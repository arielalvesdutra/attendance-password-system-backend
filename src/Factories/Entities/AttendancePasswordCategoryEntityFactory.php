<?php

namespace App\Factories\Entities;

use App\Entities\AttendancePasswordCategory;

class AttendancePasswordCategoryEntityFactory
{
    public static function create(string $name, string $code,
                                  int $id = null): AttendancePasswordCategory
    {
        return (new AttendancePasswordCategory($id))
            ->setName($name)
            ->setCode($code);
    }

    public static function createFromFetchAllArray(array $records): array
    {
        $entitiesArray = [];

        foreach ($records as $record) {
            $entitiesArray[] = AttendancePasswordCategoryEntityFactory::create(
                $record['name'],
                $record['code'],
                $record['id']
            );
        }

        return $entitiesArray;
    }
}
