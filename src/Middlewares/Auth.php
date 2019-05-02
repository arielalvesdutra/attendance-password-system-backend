<?php

namespace App\Middlewares;

use App\Strategies\JWTStrategy;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Middleware de Autenticação
 *
 * Class Auth
 * @package App\Middlewares
 */
class Auth
{

    protected $jwtStrategy;

    public function __construct(JWTStrategy $jwtStrategy)
    {
        $this->jwtStrategy = $jwtStrategy;
    }

    /**
     * Caso o token JWT seja inválido, é retornado o status 401
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {

        try {

            $this->jwtStrategy->validateToken($request->getHeaderLine('Authorization'));

            return $next($request, $response);

        } catch (Exception $exception) {
            return $response->withStatus(401);
        }
    }
}

