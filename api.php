<?php

require __DIR__ . "/eloquent/bootstrap.php";

$userController = new Controllers\UserController();
$routes = $userController::routes();

$requestUri =  str_replace('/api.php', '', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

$route = collect($routes)->where('uri', $requestUri)->first();

if (!$route) {
    $userController->errorNotFound();
}

if ($route['method'] != $_SERVER['REQUEST_METHOD']) {
    $userController->errorMethodNotAllowed();
}

try {
    call_user_func(array($userController, $route['action']), ${"_" . $_SERVER['REQUEST_METHOD']});
} catch (Exception $e) {
    var_dump($e);
    $userController->errorServer();
}