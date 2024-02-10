<?php 
include 'config.php';

$route = $_SERVER['REQUEST_URI'];
$route = substr($route, 1);

try {
    if (!str_starts_with($route, 'api/')) throw new Error("Not Found");
    $route = explode('/', explode('?', $route)[0])[1];
    require "router/$route.php";
} catch (Error $e) {
    include_once 'class/abstract.class.php';
    API::handleError(404, $e->getMessage());
}
?>