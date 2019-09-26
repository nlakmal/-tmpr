<?php

require_once 'ResponseInterface.php';

    class JsonResponse implements ResponseInterface{
        /**
         * @param int $code
         * @param array $headers
         * @param string $data
         */
        public function send(int $code, array $data) {
            $headers = [
                'Content-Type' => 'application/json; charset=utf-8'
            ];
            foreach ($headers as $key => $value) {
                header("$key: $value");
            }
            http_response_code($code);
            echo json_encode($data);
            exit();
        }
    }
