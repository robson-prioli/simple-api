<?php

class Response {
    public static function success($data = null) {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['usuarios' => $data]);
    }

    public static function error(InvalidArgumentException $e) {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
}