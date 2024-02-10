<?php
require_once './class/enrolment.class.php';
$method = $_SERVER['REQUEST_METHOD'];
$api = new EnrolmentAPI();
$api->handle($method);