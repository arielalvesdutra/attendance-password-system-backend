<?php

namespace App\Factories\Entities;

use App\Entities\TicketWindow;

class TicketWindowEntityFactory
{
    public static function create(string $name, int $id = null): TicketWindow
    {
        return (new TicketWindow($id))
                ->setName($name);
    }

    public static function createFromFetchAllArray(array $records)
    {
        $entitiesArray = [];


        foreach ($records as $record) {
            $entitiesArray[] = TicketWindowEntityFactory::create(
                $record['name'],
                $record['id']
            );
        }
//        debugd( $entitiesArray);

        return $entitiesArray;
    }
}