<?php 
abstract class API {

    abstract protected function handleGet();
    abstract protected function handlePost();
    abstract protected function handleDelete();
    abstract protected function handlePut();

    public function handle($method, ...$args) {
        switch($method){
            case 'GET':
                $this->handleGet();
                break;
            case 'POST':
                $this->handlePost();
                break;
            case 'DELETE':
                $this->handleDelete();
                break;
            case 'PUT':
                $this->handlePut();
                break;
            default:
                http_response_code(405);
                self::sendResponse('METHOD NOT ALLOWED');
                break;
        }
    }

    public static function sendResponse($m) {
        echo json_encode($m);
    }

    public static function handleError($code, $m) {
        http_response_code($code);
        self::sendResponse($m);
    }
}

?>