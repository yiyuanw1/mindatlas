<?php
require_once 'class/abstract.class.php';
require_once 'controller/user.class.php';

class UserAPI extends API
{

    protected function handleGet()
    {
        $route = (explode('/api/user', $_SERVER['REQUEST_URI'])[1]);
        if ($route != '') {
            self::sendResponse(UserController::get_one(substr($route,1)));
        } else {
            self::sendResponse(UserController::get_all());
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

