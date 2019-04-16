<?php

namespace Tests\Entities;

use App\Entities\AttendancePassword;
use App\Entities\AttendancePasswordCategory;
use App\Entities\AttendanceStatus;
use App\Entities\TicketWindow;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Throwable;

class AttendancePasswordTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
          class_exists('App\Entities\AttendancePassword'),
          "Classe App\Entities\AttendancePassword não existe!"
        );
    }

    public function testSetName()
    {
        $name = "TEST-001";
        $attendancePasswordEntity = new AttendancePassword();

        $attendancePasswordEntity->setName($name);
    }

    public function testSetNameWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $name = "";

        $attendancePasswordEntity = new AttendancePassword();

        $attendancePasswordEntity->setName($name);
    }

    public function testGetName()
    {
        $name = "TEST-001";
        $attendancePasswordEntity = new AttendancePassword();

        $attendancePasswordEntity->setName($name);

        $this->assertEquals(
            $name,
            $attendancePasswordEntity->getName(),
            'Os nomes não conferem.'
        );
    }

    public function testGetNameWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $attendancePasswordEntity = new AttendancePassword();
        $attendancePasswordEntity->getName();
    }

    public function testSetCategory()
    {
        $attendanceCategoryEntity = new AttendancePasswordCategory();
        $attendancePasswordEntity = new AttendancePassword();

        $attendancePasswordEntity->setCategory(
            $attendanceCategoryEntity
        );
    }

    public function testSetCategoryWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(Throwable::class);

        $attendanceCategoryEntity = "";
        $attendancePasswordEntity = new AttendancePassword();

        $attendancePasswordEntity->setCategory(
            $attendanceCategoryEntity
        );
    }

    public function testGetCategory()
    {
        $attendanceCategoryEntity = new AttendancePasswordCategory();
        $attendancePasswordEntity = new AttendancePassword();

        $attendancePasswordEntity->setCategory(
            $attendanceCategoryEntity
        );

        $this->assertEquals(
          $attendanceCategoryEntity,
          $attendancePasswordEntity->getCategory()
        );
    }

    public function testGetCategoryWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $attendancePasswordEntity = new AttendancePassword();
        $attendancePasswordEntity->getCategory();
    }

    public function testSetStatus()
    {
        $attendanceStatus = new AttendanceStatus();
        $attendancePassword =  new AttendancePassword();

        $attendancePassword->setStatus($attendanceStatus);
    }

    public function testSetStatusWithInvalidDataShouldThrownAnInvalidArgumentException()
    {
        $this->expectException(Throwable::class);

        $attendanceStatus = "";

        $attendancePassword =  new AttendancePassword();
        $attendancePassword->setStatus($attendanceStatus);
    }

    public function testGetStatus()
    {
        $attendanceStatus = new AttendanceStatus();
        $attendancePassword =  new AttendancePassword();

        $attendancePassword->setStatus($attendanceStatus);

        $this->assertEquals(
            $attendanceStatus,
            $attendancePassword->getStatus()
        );
    }

    public function testGetStatusWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $attendancePassword =  new AttendancePassword();
        $attendancePassword->getStatus();
    }

    public function testSetTicketWindow()
    {
        $ticketWindow = new TicketWindow();
        $attendancePassword =  new AttendancePassword();

        $attendancePassword->setTicketWindow($ticketWindow);
    }

    public function
        testSetTicketWindowWithInvalidDataShouldThrownAnInvalidArgumentException()
    {
        $this->expectException(Throwable::class);

        $ticketWindow = "";
        $attendancePassword =  new AttendancePassword();

        $attendancePassword->setTicketWindow($ticketWindow);
    }

    public function testGetTicketWindow()
    {
        $ticketWindow = new TicketWindow();
        $attendancePassword =  new AttendancePassword();

        $attendancePassword->setTicketWindow($ticketWindow);

        $this->assertEquals(
          $ticketWindow,
          $attendancePassword->getTicketWindow()
        );
    }

    public function testGetTicketWindowWithEmptyDataShouldThrowAnException()
    {
        $this->expectException(Exception::class);

        $attendancePassword = new AttendancePassword();
        $attendancePassword->getTicketWindow();
    }
}
