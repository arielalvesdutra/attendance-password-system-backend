<?php

require '../bootstrap.php';

use App\Controllers\AttendancePasswordController;
use App\Controllers\AttendancePasswordCategoryController;
use App\Controllers\AttendanceStatusController;
use App\Controllers\AuthController;
use App\Controllers\TicketWindowController;
use App\Controllers\TicketWindowUseController;
use App\Controllers\UserController;
use App\Middlewares\AccessControlAllow;
use App\Middlewares\Auth;
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
        'user' => $_ENV['MYSQL_USER'],
        'host' => $_ENV['MYSQL_HOST'],
        'driver' => 'pdo_mysql',
        'password' => $_ENV['MYSQL_PASSWORD'],
        'port' => $_ENV['MYSQL_PORT'],
        'dbname' => $_ENV['MYSQL_DATABASE']
    ];

    return \Doctrine\DBAL\DriverManager::getConnection($connectionParameters, $config);
};

/**
 * Injato o AttendancePasswordController
 * @param $container
 * @return AttendancePasswordController
 */
$container[AttendancePasswordController::class] = function ($container)
{
    return new \App\Controllers\AttendancePasswordController(
        new \App\Services\AttendancePasswordService(
            $container['Connection'],
            new \App\Repositories\AttendancePasswordRepository($container['Connection']),
            new \App\Repositories\AttendancePasswordCategoryRepository($container['Connection']),
            new \App\Repositories\AttendanceStatusRepository($container['Connection']),
            new \App\Repositories\TicketWindowRepository($container['Connection']),
            new \App\Repositories\UserRepository($container['Connection'])

        )
    );
};

/**
 * Injeta o AttendancePasswordCategoryController
 * @param $container
 * @return AttendancePasswordCategoryController
 */
$container[AttendancePasswordCategoryController::class] = function ($container)
{
    return new \App\Controllers\AttendancePasswordCategoryController(
        new \App\Services\AttendancePasswordCategoryService(
            $container['Connection'],
            new \App\Repositories\AttendancePasswordCategoryRepository($container['Connection'])
        )
    );
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
 * Injeta AuthController
 * @param $container
 * @return AuthController
 */
$container[AuthController::class] = function ($container)
{
    return new \App\Controllers\AuthController(
        new \App\Services\UserService(
            $container['Connection'],
            new \App\Repositories\UserRepository($container['Connection'])
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
 * Injeta TicketWindowUseController
 * @param $container
 * @return TicketWindowUseController
 */
$container[TicketWindowUseController::class] = function ($container)
{
    return new \App\Controllers\TicketWindowUseController(
        new \App\Services\TicketWindowUseService(
            $container['Connection'],
            new \App\Repositories\TicketWindowUseRepository($container['Connection']),
            new \App\Repositories\TicketWindowRepository($container['Connection']),
            new \App\Repositories\UserRepository($container['Connection'])
        )
    );
};

/**
 * Injeta UserController
 * @param $container
 * @return UserController
 */
$container[UserController::class] = function ($container)
{
    return new \App\Controllers\UserController(
        new \App\Services\UserService(
            $container['Connection'],
            new \App\Repositories\UserRepository($container['Connection'])
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


/**
 * Adiciona Middleware para corrigir o problema de
 * restrição de CORS
 */
$slim->add(new AccessControlAllow());

$slim->get('/', function() {
    return "Primeira rota.";
});

/**
 * AttendanceCategory
 */
$slim->delete('/attendance-categories/{id}',
    AttendancePasswordCategoryController::class . ":delete");
$slim->get('/attendance-categories/{id}',
    AttendancePasswordCategoryController::class . ":retrieve");
$slim->get('/attendance-categories',
    AttendancePasswordCategoryController::class . ":retrieveAll");
$slim->post('/attendance-categories',
    AttendancePasswordCategoryController::class . ":create");
$slim->put('/attendance-categories/{id}',
    AttendancePasswordCategoryController::class . ":update");

/**
 * AttendancePassword
 */
$slim->get('/attendance-passwords', AttendancePasswordController::class . ":retrieveAll");
$slim->get('/attendance-passwords/{id}', AttendancePasswordController::class . ":retrieve");
$slim->get('/attendance-passwords/search/retrieve-10-last-finished',
    AttendancePasswordController::class . ":retrieve10LastFinished");
$slim->get('/attendance-passwords/search/retrieve-awaiting',
    AttendancePasswordController::class . ":retrieveAwaiting");
$slim->get('/attendance-passwords/search/retrieve-in-progress',
    AttendancePasswordController::class . ":retrieveInProgress");
$slim->get('/attendance-passwords/search/retrieve-last-in-progress',
    AttendancePasswordController::class . ":retrieveLastInProgress");
$slim->get('/attendance-passwords/users/{id}/retrieve-in-progress',
    AttendancePasswordController::class . ":retrieveInProgressUserAttendance");
$slim->patch('/attendance-passwords/actions/attend-password',
    AttendancePasswordController::class . ":attendPassword");
$slim->patch('/attendance-passwords/actions/{id}/cancel-password',
    AttendancePasswordController::class . ":cancelPassword");
$slim->patch('/attendance-passwords/actions/{id}/conclude-password',
    AttendancePasswordController::class . ":concludePassword");
$slim->post('/attendance-passwords', AttendancePasswordController::class . ":create");

/**
 * AttendanceStatus
 */
$slim->delete('/attendance-status/{id}', AttendanceStatusController::class . ":delete");
$slim->get('/attendance-status', AttendanceStatusController::class . ":retrieveAll");
$slim->get('/attendance-status/{id}', AttendanceStatusController::class . ":retrieve");
$slim->post('/attendance-status', AttendanceStatusController::class . ":create");
$slim->put('/attendance-status/{id}', AttendanceStatusController::class . ":update");

/**
 * Auth
 */
$slim->post('/signin', AuthController::class . ':signIn');

/**
 * TicketWindow
 */
$slim->delete('/ticket-window/{id}', TicketWindowController::class . ":delete");
$slim->get('/ticket-window/{id}', TicketWindowController::class . ":retrieve");
$slim->get('/ticket-window', TicketWindowController::class . ":retrieveAll");
$slim->post('/ticket-window', TicketWindowController::class . ":create");

/**
 * TicketWindowUse
 */
$slim->get('/ticket-window-use/retrieve-user-ticket-window/{id}',
    TicketWindowUseController::class . ':retrieveUserTicketWindow');
$slim->get('/ticket-window-use/retrieve-unused-ticket-window',
    TicketWindowUseController::class . ':retrieveUnused');
$slim->post('/ticket-window-use/release',
    TicketWindowUseController::class . ':release');
$slim->post('/ticket-window-use/use', TicketWindowUseController::class . ':use');

/**
 * Users
 */
$slim->delete('/users/{id}', UserController::class . ':delete');
$slim->get('/users', UserController::class . ':retrieveAll');
$slim->get('/users/{id}', UserController::class . ':retrieve');
$slim->post('/users', UserController::class . ':create');
$slim->put('/users/{id}', UserController::class . ':update');

$slim->run();