<?php
require_once 'class/abstract.class.php';
require_once 'controller/enrolment.class.php';

class EnrolmentAPI extends API
{
    protected function handleGet()
    {
        $route = explode('/api/enrolment', explode('?', $_SERVER['REQUEST_URI'])[0])[1];
        switch ($route) {
            case '':
                self::sendResponse(EnrolmentController::get_record());
                break;
            case '/count':
                self::sendResponse(EnrolmentController::get_record_counts());
                break;
            default:
                self::handleError(404, 'Not Found');
                break;
        }
    }

    // create new enrolment
    protected function handlePost()
    {
        EnrolmentController::generate_enrolments();
    }

    protected function handleDelete()
    {
    }

    protected function handlePut()
    {
    }
}

