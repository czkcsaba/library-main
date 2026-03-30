<?php

namespace App\Api;

abstract class ApiController
{
    protected function body(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_CONTENT_TYPE'] ?? '';
        $contentType = strtolower(trim(explode(';', $contentType)[0]));

        if ($contentType === 'application/json') {
            $raw = file_get_contents('php://input');
            $decoded = json_decode($raw ?: '[]', true);
            return is_array($decoded) ? $decoded : [];
        }

        // form-data / x-www-form-urlencoded
        return is_array($_POST) ? $_POST : [];
    }

    protected function query(): array
    {
        return is_array($_GET) ? $_GET : [];
    }

    protected function int(mixed $v, int $default = 0): int
    {
        if ($v === null || $v === '') return $default;
        return (int)$v;
    }

    protected function str(mixed $v, string $default = ''): string
    {
        if ($v === null) return $default;
        return (string)$v;
    }

    protected function isLoadFile(string $value): bool
    {
        return str_starts_with($value, "LOAD_FILE(");
    }

    protected function tmpUploadToLoadFile(string $fileFieldName, string $tmpPrefix = 'api_upload_'): ?string
    {
        if (!isset($_FILES[$fileFieldName]) || empty($_FILES[$fileFieldName]['tmp_name'])) {
            return null;
        }

        $tmpName = $_FILES[$fileFieldName]['tmp_name'];
        if (!is_uploaded_file($tmpName)) {
            return null;
        }

        $ext = pathinfo($_FILES[$fileFieldName]['name'] ?? '', PATHINFO_EXTENSION);
        $ext = $ext ? ('.' . $ext) : '';
        $dest = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $tmpPrefix . uniqid() . $ext;

        if (!move_uploaded_file($tmpName, $dest)) {
            return null;
        }

        $real = realpath($dest);
        if (!$real) return null;

        // MySQL expects forward slashes
        $real = str_replace('\\', '/', $real);
        return "LOAD_FILE('{$real}')";
    }
}
