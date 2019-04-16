<?php

namespace Tests\Entities;

use App\Entities\AttendancePasswordCategory;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AttendancePasswordCategoryTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
          class_exists('App\Entities\AttendancePasswordCategory'),
          "Classe App\Entities\AttendancePasswordCategory não existe!"
        );
    }

    public function testSetName()
    {
        $name = "Categoria de Teste";
        $categoryEntity = new AttendancePasswordCategory();

        $categoryEntity->setName($name);
    }

    public function testSetNameWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $name = "";

        $categoryEntity = new AttendancePasswordCategory();

        $categoryEntity->setName($name);
    }

    public function testGetName()
    {
        $name = "Categoria de Teste";
        $categoryEntity = new AttendancePasswordCategory();

        $categoryEntity->setName($name);

        $this->assertEquals(
            $name,
            $categoryEntity->getName(),
            'Os nomes não conferem.'
        );
    }

    public function testGetNameWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $categoryEntity = new AttendancePasswordCategory();
        $categoryEntity->getName();
    }

    public function testSetCode()
    {
        $code = "test_category";
        $categoryEntity = new AttendancePasswordCategory();

        $categoryEntity->setCode($code);
    }

    public function testSetCodeWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $code = "";

        $categoryEntity = new AttendancePasswordCategory();

        $categoryEntity->setCode($code);
    }

    public function testGetCode()
    {
        $code = "test_category";
        $categoryEntity = new AttendancePasswordCategory();

        $categoryEntity->setCode($code);

        $this->assertEquals(
            $code,
            $categoryEntity->getCode(),
            'Os código não conferem.'
        );
    }

    public function testGetCodeWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $categoryEntity = new AttendancePasswordCategory();
        $categoryEntity->getCode();
    }
}
