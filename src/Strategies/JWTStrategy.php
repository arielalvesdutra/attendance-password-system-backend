<?php

namespace App\Strategies;

use Exception;
use Firebase\JWT\JWT;
use InvalidArgumentException;

class JWTStrategy
{
    /**
     * Expressão Regular para verificar se possui o bearer
     * (case insensitive) no inicio da string
     */
    const BEARER_REGEX = "/(^bearer)/i";

    /**
     * Retorna o secret do JWT configurado no arquivo .env
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getSecret()
    {
        if (!empty($_ENV['AUTH_SECRET'])){
            return $_ENV['AUTH_SECRET'];
        }

        throw new Exception('Secret não está configurado!');
    }

    public function getTimestamp30SecondsForward()
    {
        return time() + (30);
    }

    public  function getTimestamp10MinutesForward()
    {
        return time() + (60 * 10);
    }

    public function getTimestamp60MinutesForward()
    {
        return time() + (60 * 60);
    }

    public function validateToken(string $token)
    {
        if (empty($token)) {
            throw new InvalidArgumentException('Token está vazio!');
        }

        if (!$this->tokenHasBearer($token)) {
            throw new InvalidArgumentException('O cabeçalho não utiliza o Bearer Schema!');
        }

        $secret = $this->getSecret();
        $algorithms = [ 'HS256' ];
        $tokenWithoutBearer = $this->removeBearerFromToken($token);

        JWT::decode($tokenWithoutBearer, $secret, $algorithms);
    }

    /**
     * @param string $token
     *
     * @return string
     */
    private function removeBearerFromToken(string $token)
    {
        return str_replace(["bearer ", "Bearer "] , "" , $token);
    }

    /**
     * Verifica com a expressão regular se a string possui
     * a string bearer no seu inicio
     *
     * @param string $token
     *
     * @return bool
     */
    private function tokenHasBearer(string $token)
    {
        if (preg_match(self::BEARER_REGEX, $token)) {
            return true;
        }

        return false;
    }
}
