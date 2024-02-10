<?php
require_once './class/course.class.php';
$method = $_SERVER['REQUEST_METHOD'];
$api = new CourseAPI();
$api->handle($method);
