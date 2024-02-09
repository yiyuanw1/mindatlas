<?php
require 'route/abstract.class.php';

class UserAPI extends API{

    protected function handleGet()
    {
        $route = $_SERVER['REQUEST_URI'];
        $route = substr($route, strlen('/user/'));
        if ($route != '') {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->bindValue(':id', $route);
            $stmt->execute();
            self::sendResponse($stmt->fetch());
        } else {
            $stmt = $this->db->prepare('SELECT * FROM users');
            $stmt->execute();
            self::sendResponse($stmt->fetchAll());
        }
    }

    protected function handlePost()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if (!empty($data) && isset($data['firstname']) && isset($data['surname'])) {
            $stmt = $this->db->prepare('INSERT INTO users (firstname, surname) VALUES (:firstname, :surname)');
            $stmt->bindValue(':firstname', $data['firstname']);
            $stmt->bindValue(':surname', $data['surname']);
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
        $route = substr($route, strlen('/user/'));
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if ($route != '' && !empty($data) && isset($data['firstname']) && isset($data['surname'])) {
            $stmt = $this->db->prepare('UPDATE users SET firstname=:firstname, surname=:surname WHERE id = :id');
            $stmt->bindValue(':id', $route);
            $stmt->bindValue(':firstname', $data['firstname']);
            $stmt->bindValue(':surname', $data['surname']);
            
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
        $route = substr($route, strlen('/user/'));
        if ($route != '') {
            $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
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
$api = new UserAPI();
$api->handle($method);
?>