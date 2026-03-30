<?php

namespace App\Api;

class ApiResponse
{
    public static function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function ok(mixed $data = null, int $status = 200): void
    {
        self::json([
            'ok' => true,
            'data' => $data,
        ], $status);
    }

    public static function fail(string $message, int $status = 400, mixed $details = null): void
    {
        self::json([
            'ok' => false,
            'error' => $message,
            'details' => $details,
        ], $status);
    }
}
