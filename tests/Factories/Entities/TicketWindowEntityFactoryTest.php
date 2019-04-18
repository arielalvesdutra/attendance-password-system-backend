<?php

namespace Tests\Factories\Entities;

use App\Entities\TicketWindow;
use App\Factories\Entities\TicketWindowEntityFactory;
use PHPUnit\Framework\TestCase;

class TicketWindowEntityFactoryTest extends TestCase
{
    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Factories\Entities\TicketWindowEntityFactory'),
            "Classe App\Factories\Entities\TicketWindowEntityFactory não existe!"
        );
    }

    public function testCreate()
    {
        $id = 1;
        $name = 'PA - 01';

        $ticketWindowEntity = TicketWindowEntityFactory::create($name, $id);

        $this->assertInstanceOf(
            TicketWindow::class,
            $ticketWindowEntity
        );

        $this->assertEquals(
            $id,
            $ticketWindowEntity->getId()
        );

        $this->assertEquals(
            $name,
            $ticketWindowEntity->getName()
        );
    }

    public function testCreateWithoutId()
    {
        $name = 'PA - 01';

        $ticketWindowEntity = TicketWindowEntityFactory::create($name);

        $this->assertInstanceOf(
            TicketWindow::class,
            $ticketWindowEntity
        );

        $this->assertEquals(
          $name,
          $ticketWindowEntity->getName()
        );
    }
}
