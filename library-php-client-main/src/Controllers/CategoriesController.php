<?php
class CategoriesController extends Controller
{
    public function index(): void
    {
        $response = $this->api->request('GET', 'categories');
        $items = $response['ok'] ? normalizeArray($response['data']) : [];

        $this->render('categories', [
            'title' => 'Kategóriák',
            'section' => 'categories',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $result = $this->api->request('POST', 'categories', [], [
            'name' => $_POST['name'] ?? ''
        ]);

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Kategória létrehozva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen létrehozás.'))
        );

        $this->redirect('categories');
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $payload = ['name' => $_POST['name'] ?? ''];

        $result = $this->api->request('PATCH', 'categories/' . $id, [], $payload);

        if (!$result['ok'] && stripos((string)($result['error'] ?? ''), 'endpoint not found') !== false) {
            $result = $this->api->request('PUT', 'categories/' . $id, [], $payload);
        }

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Kategória módosítva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen módosítás.'))
        );

        $this->redirect('categories');
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->api->request('DELETE', 'categories/' . $id);

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Kategória törölve.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen törlés.'))
        );

        $this->redirect('categories');
    }
}