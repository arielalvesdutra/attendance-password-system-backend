<?php

namespace Tests\Entities;

use App\Entities\AttendanceStatus;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AttendanceStatusTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
          class_exists('App\Entities\AttendanceStatus'),
          "Classe App\Entities\AttendanceStatus não existe!"
        );
    }

    public function testSetName()
    {
        $name = "Criado";
        $attendanceStatusEntity = new AttendanceStatus();

        $attendanceStatusEntity->setName($name);
    }

    public function testSetNameWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $name = "";

        $attendanceStatusEntity = new AttendanceStatus();

        $attendanceStatusEntity->setName($name);
    }

    public function testGetName()
    {
        $name = "Criado";
        $attendanceStatusEntity = new AttendanceStatus();

        $attendanceStatusEntity->setName($name);

        $this->assertEquals(
            $name,
            $attendanceStatusEntity->getName(),
            'Os nomes não conferem.'
        );
    }

    public function testGetNameWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $attendanceStatusEntity = new AttendanceStatus();
        $attendanceStatusEntity->getName();
    }
}
