<?php

namespace Tests\Services;

use App\Factories\Entities\TicketWindowEntityFactory;
use App\Repositories\TicketWindowRepository;
use App\Services\TicketWindowService;
use Doctrine\DBAL\Connection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Throwable;

class TicketWindowServiceTest extends TestCase
{

    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Services\TicketWindowService'),
            "Classe App\Services\TicketWindowService não existe!"
        );
    }

    public function
        testInstantiateTicketWindowWithoutDependencyShouldThrowAnException()
    {
        $this->expectException(Throwable::class);

        new TicketWindowService();
    }

    public function testCreateTicketWindow()
    {
        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $parameters = [
          'name' => 'PA - 01'
        ];

        $ticketWindowService->createTicketWindow($parameters);
    }

    public function testCreateTicketWindowWithInvalidDataShouldThrownAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $parameters = [];

        $ticketWindowService->createTicketWindow($parameters);
    }

    public function testRetrieveAllTicketWindow()
    {
        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $ticketWindowService->retrieveAllTicketWindow();
    }

    public function testRetrieveTicketWindow()
    {
        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $parameters = [
            'id' => 1
        ];

        $ticketWindowService->retrieveTicketWindow($parameters);
    }

    public function
        testRetrieveTicketWindowWithInvalidDataShouldThrownAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $parameters = [];

        $ticketWindowService->retrieveTicketWindow($parameters);
    }

    public function testDeleteTicketWindow()
    {
        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);

        $ticketWindowRepository->method('find')
                ->willReturn(TicketWindowEntityFactory::create('PA - 001', 1));

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $parameters = [
            'id' => 1
        ];

        $ticketWindowService->deleteTicketWindow($parameters);
    }

    public function testDeleteTicketWindowWithInvalidDataShouldThrownAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        $connectionMock =  $this->createMock(Connection::class);
        $ticketWindowRepository = $this->createMock(TicketWindowRepository::class);;

        $ticketWindowService = new TicketWindowService(
            $connectionMock,
            $ticketWindowRepository
        );

        $parameters = [];

        $ticketWindowService->deleteTicketWindow($parameters);
    }
}
