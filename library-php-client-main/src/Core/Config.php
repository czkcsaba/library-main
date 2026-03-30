<?php
class Config
{
    private string $defaultApiBaseUrl = 'http://localhost:8000/api';

    public function getApiBaseUrl(): string
    {
        if (!empty($_POST['api_base_url'])) {
            $url = trim((string)$_POST['api_base_url']);
            $_SESSION['api_base_url'] = $url;
            return $url;
        }

        if (!empty($_GET['api_base_url'])) {
            $url = trim((string)$_GET['api_base_url']);
            $_SESSION['api_base_url'] = $url;
            return $url;
        }

        if (!empty($_SESSION['api_base_url'])) {
            return (string)$_SESSION['api_base_url'];
        }

        return $this->defaultApiBaseUrl;
    }

    public function updateApiBaseUrl(string $url): void
    {
        $url = trim($url);
        $_SESSION['api_base_url'] = $url !== '' ? $url : $this->defaultApiBaseUrl;
    }
}
