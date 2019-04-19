<?php

namespace App\Factories\Entities;

use App\Entities\AttendanceStatus;

class AttendanceStatusEntityFactory
{
    public static function create(string $name, int $id = null): AttendanceStatus
    {
        return (new AttendanceStatus($id))
            ->setName($name);
    }

    public static function createFromFetchAllArray(array $records)
    {
        $entitiesArray = [];

        foreach ($records as $record) {
            $entitiesArray[] = AttendanceStatusEntityFactory::create(
                $record['name'],
                $record['id']
            );
        }

        return $entitiesArray;
    }
}
