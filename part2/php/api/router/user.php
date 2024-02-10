<?php
require_once './class/user.class.php';
$method = $_SERVER['REQUEST_METHOD'];
$api = new UserAPI();
$api->handle($method);
