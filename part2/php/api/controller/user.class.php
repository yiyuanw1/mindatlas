<?php
include_once './DB.class.php';

class UserController{
    

    static function get_one($id)
    {
        $stmt = DB::getInstance()->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    static function get_all()
    {
        $stmt = DB::getInstance()->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}