<?php

namespace App\Factories\Entities;

use App\Entities\AttendancePassword;
use App\Entities\AttendancePasswordCategory;
use App\Entities\AttendanceStatus;
use App\Entities\TicketWindow;
use App\Entities\User;
use App\Strategies\AttendancePasswordStrategy;

use DateTime;

class AttendancePasswordEntityFactory
{

    public static function create(string $name, AttendancePasswordCategory $category,
                                  AttendanceStatus $status, TicketWindow $ticketWindow = null,
                                  User $user = null, int $id = null): AttendancePassword
    {

        $attendancePasswordEntity = (new AttendancePassword($id))
            ->setName($name)
            ->setCategory($category)
            ->setStatus($status);

        if (!empty($ticketWindow)) {
            $attendancePasswordEntity->setTicketWindow($ticketWindow);
        }

        if (!empty($user)) {
            $attendancePasswordEntity->setUser($user);
        }

        return $attendancePasswordEntity;
    }

    public static function createNewAttendancePassword(AttendancePasswordCategory $category,
                            AttendanceStatus $status, int $amountOfPasswordsByCategory): AttendancePassword
    {
        $attendancePasswordStrategy = new AttendancePasswordStrategy();

        $name = $category->getCode() . "-" .
                $attendancePasswordStrategy->addZerosToLeftStringSide(
                    ++$amountOfPasswordsByCategory
                );

        $creationDate = new DateTime();

        return (new AttendancePassword())
            ->setName($name)
            ->setCategory($category)
            ->setStatus($status)
            ->setCreationDate($creationDate);
    }
}
