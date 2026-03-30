<?php
class WritersController extends Controller
{
    public function index(): void
    {
        $response = $this->api->request('GET', 'writers');
        $items = $response['ok'] ? normalizeArray($response['data']) : [];

        $this->render('writers', [
            'title' => 'Írók',
            'section' => 'writers',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        $payload = [
            'name' => $_POST['name'] ?? '',
            'bio' => $_POST['bio'] ?? '',
        ];

        $result = $this->api->request('POST', 'writers', [], $payload);

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Író létrehozva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen létrehozás.'))
        );

        $this->redirect('writers');
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);

        $payload = [
            'name' => $_POST['name'] ?? '',
            'bio' => $_POST['bio'] ?? '',
        ];

        $result = $this->api->request('PATCH', 'writers/' . $id, [], $payload);

        if (!$result['ok'] && stripos((string)($result['error'] ?? ''), 'endpoint not found') !== false) {
            $result = $this->api->request('PUT', 'writers/' . $id, [], $payload);
        }

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Író módosítva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen módosítás.'))
        );

        $this->redirect('writers');
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->api->request('DELETE', 'writers/' . $id);

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Író törölve.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen törlés.'))
        );

        $this->redirect('writers');
    }
}