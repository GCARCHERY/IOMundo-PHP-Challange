<?php

namespace Controllers;

abstract class BaseApiController
{
    abstract public static function routes(): array;

    public function errorNotFound(): void
    {
        $this->sendApiResponse(['Not Found'], array('HTTP/1.1 404 Not Found'));
    }

    public function errorMethodNotAllowed()
    {
        $this->sendApiResponse(['Method Not Allowed'], array('HTTP/1.1 405 Method Not Allowed'));
    }

    public function errorServer()
    {
        $this->sendApiResponse(['Server Error'], array('HTTP/1.1 500 Server Error'));
    }

    protected function errorBadRequest()
    {
        $this->sendApiResponse(['Bad Request'], array('HTTP/1.1 400 Bad Request'));
    }

    protected function success(array $data = array()): void
    {
        $this->sendApiResponse(
            [
                'success' => true,
                'data' => $data
            ],
            array('HTTP/1.1 200 OK', 'Content-Type: application/json')
        );
    }

    protected function error(array $data): void
    {
        $this->sendApiResponse(
            [
                'success' => false,
                'data' => $data
            ],
            array('HTTP/1.1 200 OK', 'Content-Type: application/json')
        );
    }

    private function sendApiResponse(array $data, array $headers): void
    {
        header_remove('Set-Cookie');

        if (count($headers)) {
            foreach ($headers as $header) {
                header($header);
            }
        }

        echo json_encode($data);
        exit;
    }
}