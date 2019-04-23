<?php

namespace Tests\Factories\Entities;

use App\Entities\Status\CreatedStatus;
use App\Factories\Entities\AttendancePasswordEntityFactory;
use App\Factories\Entities\AttendancePasswordCategoryEntityFactory;
use App\Factories\Entities\AttendanceStatusEntityFactory;
use App\Factories\Entities\TicketWindowEntityFactory;
use PHPUnit\Framework\TestCase;

class AttendancePasswordEntityFactoryTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Factories\Entities\AttendancePasswordEntityFactory'),
            "Classe App\Factories\Entities\AttendancePasswordEntityFactory não existe!"
        );
    }

    public function testCreateAnExistingAttendancePassword()
    {
        $attendanceCategoryEntity = $this->getFakeAttendanceCategoryEntity();
        $attendanceStatusEntity = $this->getFakeAttendanceStatusEntity();
        $ticketWindowEntity = $this->getFakeTicketWindowEntity();

        $attendancePasswordName = "FIN-0001";
        $attendancePasswordId = 1;

        $attendancePasswordEntity = AttendancePasswordEntityFactory::create(
            $attendancePasswordName,
            $attendanceCategoryEntity,
            $attendanceStatusEntity,
            $ticketWindowEntity,
            $attendancePasswordId
        );

        $this->assertEquals(
            $attendancePasswordId,
            $attendancePasswordEntity->getId()
        );

        $this->assertEquals(
            $attendancePasswordName,
            $attendancePasswordEntity->getName()
        );

        $this->assertEquals(
            $attendanceCategoryEntity,
            $attendancePasswordEntity->getCategory()
        );

        $this->assertEquals(
            $attendanceStatusEntity,
            $attendancePasswordEntity->getStatus()
        );

        $this->assertEquals(
          $ticketWindowEntity,
          $attendancePasswordEntity->getTicketWindow()
        );
    }

    public function testCreateNewAttendancePassword()
    {
        $amountOfPasswordsByCategory = 10;

        $attendanceCategoryEntity = $this->getFakeAttendanceCategoryEntity();

        $attendanceStatusEntity = AttendanceStatusEntityFactory::create('Criado', CreatedStatus::CODE, 1);

        $attendancePasswordEntity = AttendancePasswordEntityFactory::createNewAttendancePassword(
            $attendanceCategoryEntity,
            $attendanceStatusEntity,
            $amountOfPasswordsByCategory
        );

        $this->assertEquals(
          "FIN-0011",
          $attendancePasswordEntity->getName()
        );

        $this->assertEquals(
            $attendanceCategoryEntity,
            $attendancePasswordEntity->getCategory()
        );

        $this->assertEquals(
            $attendanceStatusEntity,
            $attendancePasswordEntity->getStatus()
        );
    }

    private function getFakeAttendanceCategoryEntity()
    {
        $categoryName = "Financeiro";
        $categoryCode = "FIN";
        $categoryId = 1;

        return AttendancePasswordCategoryEntityFactory::create(
            $categoryName,
            $categoryCode,
            $categoryId
        );
    }

    private function getFakeAttendanceStatusEntity()
    {
        $statusName = "Em atendimento";
        $statusCode = "IN_PROGRESS";
        $statusId = 1;

        return AttendanceStatusEntityFactory::create(
            $statusName,
            $statusCode,
            $statusId
        );
    }

    private function getFakeTicketWindowEntity()
    {
        $ticketWindowName = "PA - 001";
        $ticketWindowId = 1;

        return TicketWindowEntityFactory::create(
            $ticketWindowName,
            $ticketWindowId
        );
    }
}
