<?php
namespace lib\services\JWTService;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use lib\config\Config;

class JWTService
{
    public static function encodeJWT(int $codigoUsuario):string
    {
        $config = Config::getConfig();

        $payload = [
            'iss' => $config['JWT']['iss'],
            'aud' => $config['JWT']['aud'],
            'usr' => ['cod' => $codigoUsuario],
            'exp' => strtotime("+2 hours")
        ];
        $jwt = JWT::encode($payload, $config['JWT']['key'], 'HS256');
        return $jwt;
    }
    public static function decodeJWT(string $jwt)
    {
        $config = Config::getConfig();

        try 
        {
            return JWT::decode($jwt, new Key($config['JWT']['key'], 'HS256'));
        }
        catch(ExpiredException $e)
        {
            return false;
        }
    }
}
?>