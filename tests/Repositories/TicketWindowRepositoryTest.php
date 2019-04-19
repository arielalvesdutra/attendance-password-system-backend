<?php

namespace Tests\Repositories;

use App\Repositories\TicketWindowRepository;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Throwable;

class TicketWindowRepositoryTest extends TestCase
{

    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Repositories\TicketWindowRepository'),
            "Classe App\Repositories\TicketWindowRepository não existe!"
        );
    }

    public function
        testInstantiateWithoutConnectionDependencyShouldThrowAnException()
    {
        $this->expectException(Throwable::class);

        new TicketWindowRepository();
    }

    public function testFind()
    {
        $id = 1;

        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowRepository->find($id);
    }

    public function testFindAll()
    {
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowRepository->findAll();
    }
}
