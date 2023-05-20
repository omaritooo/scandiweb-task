<?php

namespace Infrastructure\Response;

use JsonException;

class JsonResponse
{
    /**
     * @throws JsonException
     */
    public static function make($data = [], int $status = 200, bool $isSuccess = true,array $errors = []): void
    {
        self::applyHeaders($status);

        echo json_encode([
            'success' => $isSuccess,
            'data' => $data,
            'errors' => $errors
        ], JSON_THROW_ON_ERROR);
    }

    private static function applyHeaders(int $status = 200): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 1000");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: *");
        http_response_code($status);
    }
}