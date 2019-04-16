<?php

namespace Tests\Entities;

use App\Entities\TicketWindow;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TicketWindowTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
          class_exists('App\Entities\TicketWindow'),
          "Classe App\Entities\TicketWindow não existe!"
        );
    }

    public function testSetName()
    {
        $name = "PA - 01";
        $categoryEntity = new TicketWindow();

        $categoryEntity->setName($name);
    }

    public function testSetNameWithInvalidDataShouldThrowAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $name = "";

        $categoryEntity = new TicketWindow();

        $categoryEntity->setName($name);
    }

    public function testGetName()
    {
        $name = "PA - 01";
        $categoryEntity = new TicketWindow();

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

        $categoryEntity = new TicketWindow();
        $categoryEntity->getName();
    }


}
