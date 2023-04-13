<?php
namespace lib\filters;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use lib\services\JWTService\JWTService;

class JWT_Filter
{
    public function __invoke(Request $request, RequestHandler $handler):Response
    {
        $response = new Response();

        if(!$request->hasHeader('jwt'))
            return $response->withStatus(401);
        
        $JwtHeader = $request->getHeader('jwt')[0];

        if(!$codigo = JWTService::decodeJWT($JwtHeader))
            return $response->withStatus(401);
        
        $codigo = $codigo->usr->cod;
        
        $newRequest = $request->withAttribute('codigo_usuario', $codigo);

        return $handler->handle($newRequest);
    }
}
?>