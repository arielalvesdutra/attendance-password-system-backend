<?php

namespace App\Factories\Entities;

use App\Entities\TicketWindowUse;

class TicketWindowUseEntityFactory
{

    public static function create($ticketWindow, $user): TicketWindowUse
    {

        return (new TicketWindowUse())
            ->setTicketWindow($ticketWindow)
            ->setUser($user);
    }
}
