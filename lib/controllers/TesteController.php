<?php 
namespace lib\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TesteController 
{
  use JsonResponseTrait;

  public function teste (Request $request, Response $response, array $args) {
    $valor = [
      ["id" => 1, "nome" => "benhur"],
      ["id" => 2, "nome" => "alan"],
      ["id" => 3, "nome" => "ingo"]
    ];

    return $this->JsonResponse($valor, $response, 201);
 }
}

?>