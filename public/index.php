<?php

require '../bootstrap.php';

use App\Controllers\AttendanceStatusController;
use App\Controllers\TicketWindowController;
use Slim\App;
use Slim\Container;

/**
 * Container
 */
$container = new Container();

/**
 * Injeta a conexão com o banco de dados.
 *
 * @return \Doctrine\DBAL\Connection
 */
$container['Connection'] = function () {

    $config = new \Doctrine\DBAL\Configuration();

    $connectionParameters = [
        'user' => 'root',
        'host' => '192.168.11.101',
        'driver' => 'pdo_mysql',
        'password' => 'password',
        'port' => '3601',
        'dbname' => 'aps'
    ];

    return \Doctrine\DBAL\DriverManager::getConnection($connectionParameters, $config);
};

/**
 * Injeta o AttendanceStatusController
 * @param $container
 * @return AttendanceStatusController
 */
$container[AttendanceStatusController::class] = function ($container)
{
    return new \App\Controllers\AttendanceStatusController(
        new \App\Services\AttendanceStatusService(
            $container['Connection'],
            new \App\Repositories\AttendanceStatusRepository($container['Connection'])
        )
    );
};

/**
 * Injeta TicketWindowController
 * @param $container
 * @return TicketWindowController
 */
$container[TicketWindowController::class] = function ($container)
{
    return new \App\Controllers\TicketWindowController(
        new \App\Services\TicketWindowService(
            $container['Connection'],
            new \App\Repositories\TicketWindowRepository($container['Connection'])
        )
    );
};

/**
 * Define configuração de middleware e de debug
 */
$container->get('settings')
    ->replace([
        'debug' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true
]);

/**
 * Instancia o Slim
 */
$slim = new App($container);

$slim->get('/', function() {
    return "Primeira rota.";
});

/**
 * AttendanceStatus
 */
$slim->delete('/attendance-status/{id}', AttendanceStatusController::class . ":delete");
$slim->get('/attendance-status', AttendanceStatusController::class . ":retrieveAll");
$slim->get('/attendance-status/{id}', AttendanceStatusController::class . ":retrieve");
$slim->post('/attendance-status', AttendanceStatusController::class . ":create");
$slim->put('/attendance-status/{id}', AttendanceStatusController::class . ":update");

/**
 * TicketWindow
 */
$slim->delete('/ticket-window/{id}', TicketWindowController::class . ":delete");
$slim->get('/ticket-window/{id}', TicketWindowController::class . ":retrieve");
$slim->get('/ticket-window', TicketWindowController::class . ":retrieveAll");
$slim->post('/ticket-window', TicketWindowController::class . ":create");

$slim->run();