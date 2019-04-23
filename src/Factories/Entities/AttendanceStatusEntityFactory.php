<?php

namespace App\Factories\Entities;

use App\Entities\Status;
use DomainException;

class AttendanceStatusEntityFactory
{
    public static function create(string $name, string $code, int $id = null)
    {
        if ($code === Status\CreatedStatus::CODE) {
            return (new Status\CreatedStatus($id))
                ->setName($name);
        }

        if ($code === Status\InProgressStatus::CODE) {
            return (new Status\InProgressStatus($id))
                ->setName($name);
        }

        if ($code === Status\CanceledStatus::CODE) {
            return (new Status\CanceledStatus($id))
                ->setName($name);
        }

        if ($code === Status\CompletedStatus::CODE) {
            return (new Status\CompletedStatus($id))
                ->setName($name);
        }

        throw new DomainException('Status não aceito pelo domínio!', 400);
    }

    public static function createFromFetchAllArray(array $records): array
    {
        $entitiesArray = [];

        foreach ($records as $record) {
            $entitiesArray[] = AttendanceStatusEntityFactory::create(
                $record['name'],
                $record['code'],
                $record['id']
            );
        }

        return $entitiesArray;
    }
}
