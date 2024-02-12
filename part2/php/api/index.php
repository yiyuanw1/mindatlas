<?php 
include 'config.php';

$route = $_SERVER['REQUEST_URI'];
$route = substr($route, 1);
try {
    $route = explode('api/', explode('?', $route)[0])[1];
    $route = explode('/', $route)[0];
    require "router/$route.php";
} catch (Error $e) {
    include_once 'class/abstract.class.php';
    API::handleError(404, $e->getMessage());
}
?>