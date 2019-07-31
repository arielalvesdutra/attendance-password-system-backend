<?php

namespace App\Entities;

use Exception;
use InvalidArgumentException;

class User extends Entity
{
    const EMAIL_REGEX =
        "/^([a-z0-9.]{1,})([@])([a-z0-9]{1,})([.])([a-z0-9.]{1,})([a-z]{1})$/";

    protected $admin = false;

    protected $allowedPasswordCategories = [];

    protected $email;

    protected $name;

    protected $password;

    public function addAllowedPasswordCategory(AttendancePasswordCategory $attendancePasswordCategory)
    {

        $this->allowedPasswordCategories[$attendancePasswordCategory->getCode()] =
            $attendancePasswordCategory;

        return $this;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function getAllowedPasswordCategories()
    {
        return $this->allowedPasswordCategories;
    }

    public function getEmail()
    {
        if (!empty($this->email)) {

            return $this->email;
        }

        throw new Exception('O atributo email está vazio.');
    }

    public function getName(): string
    {
        if(!empty($this->name)) {

            return $this->name;
        }

        throw new Exception('O atributo nome está vazio.');
    }

    public function getPassword()
    {
        if (!empty($this->password)) {

            return $this->password;
        }

        throw new Exception('O atributo senha está vazio.');
    }

    public function setAdmin(bool $isAdmin)
    {
        $this->admin = $isAdmin;
        return $this;
    }

    public function setAllowedPasswordCategories(array $allowedPasswordCategories)
    {
        if (!empty($allowedPasswordCategories)) {
            $this->allowedPasswordCategories = $allowedPasswordCategories;
            return $this;
        }

        throw new Exception('O array de categorias de senhas permitidas está vazio.');
    }

    public function setEmail(string $email)
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Parametro email inválido.');
        }

        if (!$this->isValidEmail($email)) {
            throw new InvalidArgumentException('Parametro email com formato inválido.');
        }

        $this->email = $email;
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

    public function setPassword(string $password)
    {
        if (!empty($password)) {

            $this->password = $password;
            return $this;
        }

        throw new InvalidArgumentException('Parametro senha inválido.');
    }

    private function isValidEmail(string $email)
    {
        if (preg_match(self::EMAIL_REGEX, $email)) {
            return true;
        }

        return false;
    }
}
