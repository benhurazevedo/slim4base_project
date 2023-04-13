<?php
namespace lib\controllers;

use lib\services\dbService\DBConnFactory;
use lib\services\JWTService\JWTService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginController
{
  use JsonResponseTrait;
	public function consultarUsuario(Request $request, Response $response, array $args) : Response
  {
    $conn = DBConnFactory::getConn();
      
    $stmt = $conn->prepare("select * from usuario where email = :email and senha = :senha");

    $parsedBody = $request->getParsedBody();

    $parsedBody["senha"] = md5($parsedBody["senha"]);

    $stmt->execute($parsedBody);

    if(!($usuario = $stmt->fetch()))
    {
      return $response->withStatus(404);
    }

    $jwt = JWTService::encodeJWT($usuario['id']);
      
    return $this->JsonResponse(['jwt' => $jwt, 'nome' => $usuario['nome']], $response, 200);
  }
}
?>