<?php

namespace App\Entities;

use Exception;

class TicketWindowUse
{

    protected $user;

    protected $ticketWindow;

    public function getUser(): User
    {
        if (!empty($this->user)) {
            return $this->user;
        }

        throw new Exception('Atributo usuário está vazio.');
    }

    public function getTicketWindow(): TicketWindow
    {
        if (!empty($this->ticketWindow)) {
            return $this->ticketWindow;
        }

        throw new Exception('Atributo guichê está vazio.');
    }

    public function setTicketWindow(TicketWindow $ticketWindow)
    {
        $this->ticketWindow = $ticketWindow;
        return $this;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
