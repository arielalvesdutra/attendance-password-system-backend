<?php

namespace Tests\Entities;

use App\Entities\User;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
          class_exists('App\Entities\User'),
          "Classe App\Entities\User não existe!"
        );
    }

    public function testSetName()
    {
        $name = "Daenerys Targaryen";
        $userEntity = new User();

        $userEntity->setName($name);
    }

    public function testSetNameWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $name = "";

        $userEntity = new User();

        $userEntity->setName($name);
    }

    public function testGetName()
    {
        $name = "Daenerys Targaryen";
        $userEntity = new User();

        $userEntity->setName($name);

        $this->assertEquals(
            $name,
            $userEntity->getName(),
            'Os nomes não conferem.'
        );
    }

    public function testGetNameWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $userEntity = new User();
        $userEntity->getName();
    }

    public function testSetEmail()
    {
        $email = "daenerys@targaryen.got";

        $userEntity = new User();
        $userEntity->setEmail($email);
    }

    public function
        testSetEmailWithInvalidDataShouldThrownAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $email = "";

        $userEntity = new User();
        $userEntity->setEmail($email);
    }

    public function
       testSetEmailWithInvalidEmailRegexShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $email = "daenerys";

        $userEntity = new User();
        $userEntity->setEmail($email);
    }

    public function testGetEmail()
    {
        $email = "daenerys@targaryen.got";

        $userEntity = new User();
        $userEntity->setEmail($email);

        $this->assertEquals(
          $email,
          $userEntity->getEmail()
        );
    }

    public function testGetEmailWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $userEntity = new User();
        $userEntity->getEmail();
    }

    public function testSetPassword()
    {
        $password = "password";

        $userEntity = new User();
        $userEntity->setPassword($password);
    }

    public function
        testSetPasswordWithInvalidDataShouldThrownAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $password = "";

        $userEntity = new User();
        $userEntity->setPassword($password);
    }

    public function testGetPassword()
    {
        $password = "password";

        $userEntity = new User();
        $userEntity->setPassword($password);

        $this->assertEquals(
          $password,
          $userEntity->getPassword()
        );
    }

    public function testGetPasswordWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $userEntity = new User();
        $userEntity->getPassword();
    }
}
