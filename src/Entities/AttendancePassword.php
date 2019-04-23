<?php

namespace App\Entities;

use Exception;
use InvalidArgumentException;

class AttendancePassword extends Entity
{
    protected $category;

    protected $name;

    protected $status;

    protected $ticketWindow;

    public function getCategory(): AttendancePasswordCategory
    {
        if (!empty($this->category)) {

            return $this->category;
        }

        throw new Exception('Parametro categoria inválido.');
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

    public function setCategory(AttendancePasswordCategory $category)
    {
        $this->category = $category;
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
}
