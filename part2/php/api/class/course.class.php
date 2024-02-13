<?php
require_once 'class/abstract.class.php';
require_once 'controller/course.class.php';

class CourseAPI extends API
{

    protected function handleGet()
    {
        $route = explode('/api/course', $_SERVER['REQUEST_URI'])[1];
        if ($route != '') {
            self::sendResponse(CourseController::get_one(substr($route,1)));
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