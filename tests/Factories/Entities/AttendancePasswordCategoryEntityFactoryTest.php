<?php

namespace Tests\Factories\Entities;

use App\Entities\AttendancePasswordCategory;
use App\Factories\Entities\AttendancePasswordCategoryEntityFactory;
use PHPUnit\Framework\TestCase;

class AttendancePasswordCategoryEntityFactoryTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Factories\Entities\AttendancePasswordCategoryEntityFactory'),
            "Classe App\Factories\Entities\AttendancePasswordCategoryEntityFactory não existe!"
        );
    }

    public function testCreate()
    {
        $id = 1;
        $name = "Financeiro";
        $code = "FIN";

        $attendanceCategoryEntity = AttendancePasswordCategoryEntityFactory::create(
          $name,
          $code,
          $id
        );

        $this->assertEquals(
            $id,
            $attendanceCategoryEntity->getId()
        );

        $this->assertEquals(
            $name,
            $attendanceCategoryEntity->getName()
        );

        $this->assertEquals(
            $code,
            $attendanceCategoryEntity->getCode()
        );

        $this->assertInstanceOf(
            AttendancePasswordCategory::class,
            $attendanceCategoryEntity
        );
    }

    public function testCreateWithoutId()
    {

        $name = "Financeiro";
        $code = "FIN";

        $attendanceCategoryEntity = AttendancePasswordCategoryEntityFactory::create(
            $name,
            $code
        );

        $this->assertEquals(
            $name,
            $attendanceCategoryEntity->getName()
        );

        $this->assertEquals(
            $code,
            $attendanceCategoryEntity->getCode()
        );

        $this->assertInstanceOf(
            AttendancePasswordCategory::class,
            $attendanceCategoryEntity
        );
    }
}
