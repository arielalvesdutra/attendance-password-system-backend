<?php

namespace Tests\Controllers;

use App\Controllers\TicketWindowController;
use App\Services\TicketWindowService;
use PHPUnit\Framework\TestCase;
use Tests\FakeRequest;
use Tests\FakeResponse;

class TicketWindowControllerTest extends TestCase
{

    protected function assertPreConditions(): void
    {
        $this->assertTrue(
            class_exists('App\Controllers\TicketWindowController'),
            "Classe App\Controllers\TicketWindowController não existe!"
        );
    }

    public function testCreateTicketWindow()
    {
        $ticketWindowService = $this->createMock(TicketWindowService::class);

        $ticketWindowController =  new TicketWindowController($ticketWindowService);

        $requestParameters = [
          'name' => 'PA - 01'
        ];

        $request = FakeRequest::create(
            'POST', '/ticket-window', $requestParameters

        );

        $response = FakeResponse::create();

        $result = $ticketWindowController->create($request, $response);

        $this->assertEquals(
            201,
            $result->getStatusCode()
        );
    }
}
