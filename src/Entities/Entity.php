<?php

namespace App\Entities;

use InvalidArgumentException;

abstract class Entity
{
    protected $id;

    public function __construct($id = null)
    {
        if ($id) {
            $this->setId($id);
        }
    }

    public function getId()
    {
        if (!empty($this->id)) {

            return $this->id;
        }

        throw new InvalidArgumentException("O atributo id está vazio", 400);
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
}
