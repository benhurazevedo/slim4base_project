<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use lib\config\Config;
use lib\routes\Routes;

set_error_handler(
    function($level, $error, $file, $line){
        if(0 === error_reporting()){
            return false;
        }
        throw new ErrorException($error, -1, $level, $file, $line);
    },
    E_ALL
);

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();

$app->addBodyParsingMiddleware();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$config = Config::getConfig();

if($config["dev"])
{
    $app->add(function ($request, $handler) {
        $config = Config::getConfig();
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', $config["base-dir"])
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, jwt')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
}


Routes::setRoutes($app);



$errorMiddleware = $app->addErrorMiddleware($config["dev"], true, true);

$app->run();
?>
