<?php

namespace Tests\Factories\Entities;

use App\Entities\AttendanceStatus;
use App\Factories\Entities\AttendanceStatusEntityFactory;
use PHPUnit\Framework\TestCase;

class AttendanceStatusEntityFactoryTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Factories\Entities\AttendanceStatusEntityFactory'),
            "Classe App\Factories\Entities\AttendanceStatusEntityFactory não existe!"
        );
    }

    public function testCreate()
    {
        $id = 1;
        $name = "Senha Emitida";

        $attendanceStatusEntity = AttendanceStatusEntityFactory::create(
            $name,
            $id
        );

        $this->assertEquals(
            $id,
            $attendanceStatusEntity->getId()
        );

        $this->assertEquals(
          $name,
          $attendanceStatusEntity->getName()
        );

        $this->assertInstanceOf(
          AttendanceStatus::class,
          $attendanceStatusEntity
        );
    }

    public function testCreateWithoutId()
    {

        $name = "Senha Emitida";

        $attendanceStatusEntity = AttendanceStatusEntityFactory::create(
            $name
        );

        $this->assertEquals(
            $name,
            $attendanceStatusEntity->getName()
        );

        $this->assertInstanceOf(
            AttendanceStatus::class,
            $attendanceStatusEntity
        );
    }
}
