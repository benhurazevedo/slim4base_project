<?php
namespace lib\routes;

use Slim\App;
use lib\controllers\LoginController;
use lib\filters\ValidateLoginFilter;
use lib\controllers\UsuarioController;
use lib\controllers\ContatoController;
use lib\filters\ValidateUsuarioFilter;
use lib\filters\ValidateConsultaEmailFilter;
use lib\filters\JWT_Filter;

class Routes 
{
  public static function setRoutes(App $app)
  {
    $app->post("/login", LoginController::class . ":ConsultarUsuario")
      ->add(new ValidateLoginFilter());
    
    $app->post("/create_user", UsuarioController::class . ":createUsuario")
      ->add(new ValidateUsuarioFilter());
    
    $app->post("/consultar_email", UsuarioController::class . ":listarEmail")
      ->add(new ValidateConsultaEmailFilter());
    
    $app->get("/lista_contatos", ContatoController::class . ":listaContatos")
      ->add(new JWT_Filter());
    
    $app->delete("/apagar_contato/{id}", ContatoController::class . ":apagarContato")
      ->add(new JWT_Filter());
    
    $app->post("/incluir_contato", ContatoController::class . ":criarContato")
      ->add(new JWT_Filter());
  }
}
?>