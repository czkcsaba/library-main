<?php
class ApiClient
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function request(string $method, string $path, array $query = [], array $data = [], array $files = []): array
    {
        $url = rtrim($this->config->getApiBaseUrl(), '/') . '/' . ltrim($path, '/');
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $headers = ['Accept: application/json'];
        $method = strtoupper($method);

        if (in_array($method, ['POST', 'PATCH', 'PUT'], true)) {
            if (!empty($files)) {
                foreach ($files as $fieldName => $tmpPath) {
                    if (!empty($tmpPath) && is_uploaded_file($tmpPath)) {
                        $originalName = $_FILES[$fieldName]['name'] ?? basename($tmpPath);
                        $mimeType = mime_content_type($tmpPath) ?: 'application/octet-stream';
                        $data[$fieldName] = curl_file_create($tmpPath, $mimeType, $originalName);
                    }
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $body = curl_exec($ch);
        $error = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($body === false || $body === null || $body === '') {
            return [
                'ok' => false,
                'status' => $status,
                'error' => $error !== '' ? $error : 'Nincs válasz az API-tól.',
                'data' => null,
                'raw' => $body,
            ];
        }

        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            return [
                'ok' => false,
                'status' => $status,
                'error' => 'Az API válasza nem feldolgozható JSON.',
                'data' => null,
                'raw' => $body,
            ];
        }

        return [
            'ok' => !empty($decoded['ok']),
            'status' => $status,
            'error' => $decoded['error'] ?? '',
            'details' => $decoded['details'] ?? null,
            'data' => $decoded['data'] ?? null,
            'raw' => $body,
        ];
    }
}
