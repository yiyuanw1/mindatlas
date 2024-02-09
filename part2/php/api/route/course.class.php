<?php 
require 'route/abstract.class.php';

class CourseAPI extends API{

    protected function handleGet()
    {
        $route = $_SERVER['REQUEST_URI'];
        $route = substr($route, strlen('/course/'));
        if ($route != '') {
            $stmt = $this->db->prepare('SELECT * FROM courses WHERE id = :id');
            $stmt->bindValue(':id', $route);
            $stmt->execute();
            self::sendResponse($stmt->fetch());
        } else {
            $stmt = $this->db->prepare('SELECT * FROM courses');
            $stmt->execute();
            self::sendResponse($stmt->fetchAll());
        }
    }

    protected function handlePost()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if (!empty($data) && isset($data['title']) && isset($data['description'])) {
            $stmt = $this->db->prepare('INSERT INTO courses (title, description) VALUES (:title, :description)');
            $stmt->bindValue(':title', $data['title']);
            $stmt->bindValue(':description', $data['description']);
            if ($stmt->execute()) {
                self::sendResponse('OK');
            } else {
                self::handleError(500, 'internal server error');
            }
        } else {
            self::handleError(400, "Bad Request");
        }
    }

    protected function handlePut()
    {
        $route = $_SERVER['REQUEST_URI'];
        $route = substr($route, strlen('/course/'));
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if ($route != '' && !empty($data) && isset($data['title']) && isset($data['description'])) {
            $stmt = $this->db->prepare('UPDATE courses SET title=:title, description=:description WHERE id = :id');
            $stmt->bindValue(':id', $route);
            $stmt->bindValue(':title', $data['title']);
            $stmt->bindValue(':description', $data['description']);
            
            if ($stmt->execute()) {
                self::sendResponse('OK');
            } else {
                self::handleError(500, 'internal server error');
            }
        } else {
            self::handleError(400, "Bad Request");
        }
    }
    
    protected function handleDelete()
    {
        $route = $_SERVER['REQUEST_URI'];
        $route = substr($route, strlen('/course/'));
        if ($route != '') {
            $stmt = $this->db->prepare('DELETE FROM courses WHERE id = :id');
            $stmt->bindValue(':id', $route);
            if ($stmt->execute()) {
                self::sendResponse('OK');
            } else {
                self::handleError(500, 'internal server error');
            }
        } else {
            self::handleError(400, 'Bad Request');
        }
    }

}

$method = $_SERVER['REQUEST_METHOD'];
$api = new CourseAPI();
$api->handle($method);
?>