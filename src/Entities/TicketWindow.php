<?php

namespace App\Entities;

use Exception;
use InvalidArgumentException;

class TicketWindow extends Entity
{
    protected $code;

    protected $name;

    public function getName(): string
    {
        if(!empty($this->name)) {

            return $this->name;
        }

        throw new Exception('O atributo nome está vazio.');
    }

    public function setName(string $name)
    {
        if (!empty($name)) {
            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException('Parametro nome inválido.');
    }
}
