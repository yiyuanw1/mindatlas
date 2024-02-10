<?php
include_once './DB.class.php';
class CourseController
{

    static function get_one($id)
    {
        $stmt = DB::getInstance()->prepare('SELECT * FROM courses WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    static function get_all()
    {
        $stmt = DB::getInstance()->prepare('SELECT * FROM courses');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
