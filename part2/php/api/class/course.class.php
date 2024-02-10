<?php
require_once 'class/abstract.class.php';
require_once 'controller/course.class.php';

class CourseAPI extends API
{

    protected function handleGet()
    {
        $route = substr(explode('?', $_SERVER['REQUEST_URI'])[0], strlen('/api/course/'));

        if ($route != '') {
            self::sendResponse(CourseController::get_one($route));
        } else {
            self::sendResponse(CourseController::get_all());
        }
    }

    protected function handlePost()
    {
    }

    protected function handlePut()
    {
    }

    protected function handleDelete()
    {
    }
}