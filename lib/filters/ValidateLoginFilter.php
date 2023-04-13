<?php
namespace lib\filters;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ValidateLoginFilter
{
  public function __invoke(Request $request, RequestHandler $handler):Response
  {
    $response = new Response();

    $parsedBody = $request->getParsedBody();
        
    if(!is_array($parsedBody))
      return $response->withStatus(400);
        
    if(!isset($parsedBody['email']) || strlen($parsedBody['email']) == 0)
      return $response->withStatus(400);
        
    if(!isset($parsedBody['senha']) || strlen($parsedBody['senha']) == 0) 
      return $response->withStatus(400);

    return $handler->handle($request);
  }
}
?>