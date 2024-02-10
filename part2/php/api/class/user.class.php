<?php
require_once 'class/abstract.class.php';
require_once 'controller/user.class.php';

class UserAPI extends API
{

    protected function handleGet()
    {
        $route = substr(explode('?', $_SERVER['REQUEST_URI'])[0], strlen('/api/user/'));
        if ($route != '') {
            self::sendResponse(UserController::get_one($route));
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

