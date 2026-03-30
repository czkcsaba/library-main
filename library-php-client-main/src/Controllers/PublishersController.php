<?php
class PublishersController extends Controller
{
    public function index(): void
    {
        $response = $this->api->request('GET', 'publishers');
        $items = $response['ok'] ? normalizeArray($response['data']) : [];

        $this->render('publishers', [
            'title' => 'Kiadók',
            'section' => 'publishers',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $result = $this->api->request('POST', 'publishers', [], [
            'name' => $_POST['name'] ?? ''
        ]);

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Kiadó létrehozva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen létrehozás.'))
        );

        $this->redirect('publishers');
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $payload = ['name' => $_POST['name'] ?? ''];

        $result = $this->api->request('PATCH', 'publishers/' . $id, [], $payload);

        if (!$result['ok'] && stripos((string)($result['error'] ?? ''), 'endpoint not found') !== false) {
            $result = $this->api->request('PUT', 'publishers/' . $id, [], $payload);
        }

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Kiadó módosítva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen módosítás.'))
        );

        $this->redirect('publishers');
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->api->request('DELETE', 'publishers/' . $id);

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Kiadó törölve.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen törlés.'))
        );

        $this->redirect('publishers');
    }
}