<?php 
include 'config.php';

$route = $_SERVER['REQUEST_URI'];
$route = substr($route, 1);

try {
    // error_reporting(0);
    if (!str_starts_with($route, 'api/')) throw new Error("Not Found");
    $route = explode('/', $route)[1];
    require "route/$route.class.php";
} catch (Error $e) {
    include_once 'route/abstract.class.php';
    API::handleError(404, $e->getMessage());
} finally {
    error_reporting(1);
}
?>