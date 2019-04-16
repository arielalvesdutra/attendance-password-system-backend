<?php

namespace App\Entities;

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
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
}
