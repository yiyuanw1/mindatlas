<?php 
header('Access-Control-Allow-Origin: http://localhost:3000');
// Check if the request is a GET request
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    echo 'method not allowed';
    exit();
}

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mindatlas_part2';
// data source name
$dsn = "mysql:host={$host};dbname={$dbname}";

$db = new PDO($dsn, $user, $password);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // to make the pagination working properly


header('Content-Type: application/json; charset=utf-8');
echo json_encode($stmt->fetchAll());
?>