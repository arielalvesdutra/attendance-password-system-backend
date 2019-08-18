<?php

namespace App\Entities;

use Exception;
use InvalidArgumentException;
use OutOfBoundsException;

class User extends Entity
{
    const EMAIL_REGEX =
        "/^([a-z0-9.]{1,})([@])([a-z0-9]{1,})([.])([a-z0-9.]{1,})([a-z]{1})$/";

    protected $admin = false;

    /**
     * @var AttendancePasswordCategory[]
     */
    protected $allowedPasswordCategories = [];

    protected $email;

    protected $name;

    protected $password;

    /**
     * @param AttendancePasswordCategory $attendancePasswordCategory
     *
     * @return $this
     *
     * @throws Exception
     */
    public function addAllowedPasswordCategory(AttendancePasswordCategory $attendancePasswordCategory)
    {

        $this->allowedPasswordCategories[$attendancePasswordCategory->getCode()] =
            $attendancePasswordCategory;

        return $this;
    }

    public function getAdmin()
    {
        return (int)$this->admin;
    }

    /**
     * @return AttendancePasswordCategory[]
     *
     * @throws OutOfBoundsException
     */
    public function getAllowedPasswordCategories()
    {
        if (!empty($this->allowedPasswordCategories)) {

            return $this->allowedPasswordCategories;
        }

        throw new OutOfBoundsException('O atributo categorias de senha permitidas está vazio');
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function getEmail()
    {
        if (!empty($this->email)) {

            return $this->email;
        }

        throw new Exception('O atributo email está vazio.');
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function getName(): string
    {
        if(!empty($this->name)) {

            return $this->name;
        }

        throw new Exception('O atributo nome está vazio.');
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function getPassword()
    {
        if (!empty($this->password)) {

            return $this->password;
        }

        throw new Exception('O atributo senha está vazio.');
    }

    /**
     * @param bool $isAdmin
     *
     * @return $this
     */
    public function setAdmin(bool $isAdmin)
    {
        $this->admin = $isAdmin;
        return $this;
    }

    /**
     * @param array $allowedPasswordCategories
     * @return $this
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function setAllowedPasswordCategories(array $allowedPasswordCategories)
    {
        $this->allowedPasswordCategories = [];

        if (!empty($allowedPasswordCategories)) {

            foreach ($allowedPasswordCategories as $allowedPasswordCategory) {
                $this->addAllowedPasswordCategory($allowedPasswordCategory);
            }

            return $this;
        }

        throw new InvalidArgumentException('O array de categorias de senhas permitidas está vazio.');
    }

    /**
     * @param string $email
     *
     * @return $this
     */
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

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        if (!empty($name)) {
            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException('Parametro nome inválido.');
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password)
    {
        if (!empty($password)) {

            $this->password = $password;
            return $this;
        }

        throw new InvalidArgumentException('Parametro senha inválido.');
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    private function isValidEmail(string $email)
    {
        if (preg_match(self::EMAIL_REGEX, $email)) {
            return true;
        }

        return false;
    }
}
