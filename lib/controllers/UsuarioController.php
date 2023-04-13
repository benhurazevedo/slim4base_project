<?php
namespace lib\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use lib\services\dbService\DBConnFactory;
use PDO;
class UsuarioController 
{
  use JsonResponseTrait;
  public function createUsuario(Request $request, Response $response, array $args)
  {
    $conn = DBConnFactory::getConn();
      
    $stmt = $conn->prepare("INSERT INTO usuario(nome, email, senha) VALUES (:nome, :email, :senha)");

    $parsedBody = $request->getParsedBody();

    $parsedBody["senha"] = md5($parsedBody["senha"]);
    unset($parsedBody["copia_senha"]);

    $stmt->execute($parsedBody);

    return $response->withStatus(201);
  }
  public function listarEmail(Request $request, Response $response, array $args) : Response
  {
    $parsedBody = $request->getParsedBody();

    $conn = DBConnFactory::getConn();

    $stmt = $conn->prepare("select email from usuario where email = :email");

    $stmt->execute($parsedBody);

    return $this->JsonResponse($stmt->fetchAll(PDO::FETCH_ASSOC), $response, 200);
  }
}
?>