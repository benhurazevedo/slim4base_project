<?php
namespace lib\controllers;

use lib\services\dbService\DBConnFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;
class ContatoController
{
  use JsonResponseTrait;
	public function listaContatos(Request $request, Response $response, array $args) : Response
  {
    $cod_usuario = $request->getAttribute('codigo_usuario');

    $conn = DBConnFactory::getConn();
      
    $stmt = $conn->prepare("select id, nome, telefone from contatos where id_usuario = :codigo_usuario");

    $stmt->execute(["codigo_usuario" => $cod_usuario]);
      
    return $this->JsonResponse($stmt->fetchAll(PDO::FETCH_ASSOC), $response, 200);
  }
  public function apagarContato(Request $request, Response $response, array $args) : Response
  {
    $id = $args["id"];

    if(!is_int($id))
      return $response->withStatus(400);
    
    $cod_usuario = $request->getAttribute('codigo_usuario');

    $conn = DBConnFactory::getConn();

    $stmt = $conn->prepare("delete from contatos where id = :id and id_usuario = :id_usuario");

    $stmt->execute(["id" => $id, "id_usuario" => $cod_usuario]);

    return $response->withStatus(204);
  }
  public function criarContato(Request $request, Response $response, array $args) : Response
  {
    $parsedBody = $request->getParsedBody();
    
    $parsedBody['id_usuario'] = $request->getAttribute('codigo_usuario');

    $conn = DBConnFactory::getConn();

    $stmt = $conn->prepare("insert into contatos (id_usuario, nome, telefone ) values (:id_usuario, :nome, :telefone)");

    $stmt->execute($parsedBody);

    $parsedBody["id"] = $conn->lastInsertId();

    return $this->JsonResponse($parsedBody, $response, 201);
  }
}
?>