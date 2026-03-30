<?php
abstract class Controller
{
    protected ApiClient $api;
    protected Config $config;

    public function __construct(ApiClient $api, Config $config)
    {
        $this->api = $api;
        $this->config = $config;
    }

    protected function render(string $view, array $data = []): void
    {
        $flash = pullFlash();
        $apiBaseUrl = $this->config->getApiBaseUrl();
        $title = $data['title'] ?? 'Library API PHP kliens';
        $section = $data['section'] ?? 'dashboard';
        extract($data);
        require __DIR__ . '/../Views/' . $view . '.php';
    }

    protected function redirect(string $section, array $query = []): void
    {
        redirectTo($section, $this->config->getApiBaseUrl(), $query);
    }

    protected function loadEntities(): array
    {
        $writersResponse = $this->api->request('GET', 'writers');
        $publishersResponse = $this->api->request('GET', 'publishers');
        $categoriesResponse = $this->api->request('GET', 'categories');

        return [
            'writers' => $writersResponse['ok'] ? normalizeArray($writersResponse['data']) : [],
            'publishers' => $publishersResponse['ok'] ? normalizeArray($publishersResponse['data']) : [],
            'categories' => $categoriesResponse['ok'] ? normalizeArray($categoriesResponse['data']) : [],
        ];
    }
}
