<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require_once(__DIR__ . '/../src/model/Evento.php');
require_once(__DIR__ . '/../src/model/User.php');
require_once(__DIR__ . '/../src/routes.php');
require_once(__DIR__ . '/../src/model/Conexao.php');

$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
$request_method = $_SERVER['REQUEST_METHOD'];
$key_request = $request_method . ':' . $request_uri;

if (array_key_exists($key_request, $routes)) {
    $rota = $routes[$key_request];
    $protegido = $rota['protegido'] ?? false;
    $user = '';
    
    if ($protegido) {
        require_once(__DIR__ . '/../src/controllers/UserController.php');
        $userController = new UserController();
        $user = $userController->validaToken();
    }
    if (file_exists(__DIR__ . '/../src/controllers/' . $rota['controlador']  . '.php')) {
        require_once(__DIR__ . '/../src/controllers/' . $rota['controlador'] . '.php');
        $classe = $rota['controlador'];
        if (class_exists($classe)) {
            $controller = new $classe();
            $metodo = $rota['metodo'];
            if (method_exists($controller, $metodo)) {
                $controller->$metodo($user);
            }
        }
    }
}
