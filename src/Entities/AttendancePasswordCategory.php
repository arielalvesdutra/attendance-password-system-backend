<?php

namespace App\Entities;

use Exception;
use InvalidArgumentException;

class AttendancePasswordCategory extends Entity
{
    protected $code;

    protected $name;

    public function getCode()
    {

        if(!empty($this->code)) {

            return $this->code;
        }

        throw new Exception('O atributo código está vazio.');
    }

    public function getName(): string
    {
        if(!empty($this->name)) {

            return $this->name;
        }

        throw new Exception('O atributo nome está vazio.');
    }

    public function setCode(string $code)
    {
        if (!empty($code)) {
            $this->code = $code;
            return $this;
        }

        throw new InvalidArgumentException('Parametro código inválido.');
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
