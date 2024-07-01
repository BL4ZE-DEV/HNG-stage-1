<?php
header("Content-Type: application/json");

$routes = [
    '/api/hello' => 'hello',
];

$currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($currentRoute, $routes)) {
    $page = $routes[$currentRoute];

    if ($page == 'hello') {
        require 'hello.php';
    }
} else {
    echo json_encode(["error" => "Oops! This page doesn't exist."]);
}
?>
