<?php 
namespace lib\controllers;

use Psr\Http\Message\ResponseInterface as Response;

trait JsonResponseTrait
{
  public function JsonResponse (array $data, Response $response, int $status = 200)  : Response
  {
    $valor = json_encode($data);
        
    $response->getBody()->write($valor);

    return $response
      ->withHeader("Content-Type", "application/json")
      ->withStatus($status);
  }
}
?>