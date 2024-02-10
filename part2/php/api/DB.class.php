<?php 
global $user;
global $password;
global $dsn;
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mindatlas_part2';

// data source name
$dsn = "mysql:host={$host};dbname={$dbname}";
class DB {
    private static $instance;

    public static function getInstance(){
        if (!isset(self::$instance)) {
            global $user;
            global $password;
            global $dsn;
            self::$instance = new PDO($dsn, $user, $password);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$instance;
    }
}
?>