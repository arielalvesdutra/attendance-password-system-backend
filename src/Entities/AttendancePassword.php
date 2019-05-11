<?php

namespace App\Entities;

use DateTime;
use Exception;
use InvalidArgumentException;

class AttendancePassword extends Entity
{
    protected $category;

    protected $creationDate;

    protected $name;

    protected $status;

    protected $ticketWindow;

    protected $user;

    public function getCategory(): AttendancePasswordCategory
    {
        if (!empty($this->category)) {

            return $this->category;
        }

        throw new Exception('O atributo categoria está vazio.');
    }

    public function getCreationDate(): DateTime
    {
        if (!empty($this->creationDate)) {
            return $this->creationDate;
        }

        throw new Exception('O atribuo data de criação está vazio.');
    }

    public function getName(): string
    {
        if(!empty($this->name)) {

            return $this->name;
        }

        throw new Exception('O atributo nome está vazio.');
    }

    public function getStatus(): AttendanceStatus
    {
        if (!empty($this->status)) {

            return $this->status;
        }

        throw new Exception('O atributo status está vazio.');
    }

    public function getTicketWindow(): TicketWindow
    {
        if (!empty($this->ticketWindow)) {

            return $this->ticketWindow;
        }

        throw new Exception('O atributo guichê está vazio.');
    }

    public function getUser(): User
    {
        if (!empty($this->user)) {
            return $this->user;
        }

        throw new Exception('O atributo usuário está vazio.');
    }

    public function setCategory(AttendancePasswordCategory $category)
    {
        $this->category = $category;
        return $this;
    }

    public function setCreationDate(DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setName(string $name)
    {
        if (!empty($name)) {
            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException('Parametro nome inválido.');
    }

    public function setStatus(AttendanceStatus $status)
    {
        $this->status = $status;
        return $this;
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
