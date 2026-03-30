<?php
class BooksController extends Controller
{
    public function index(): void
    {
        $entities = $this->loadEntities();
        $bookQuery = [
            'table' => $_GET['table'] ?? 'books',
            'text' => trim((string)($_GET['text'] ?? '')),
        ];

        if ($bookQuery['text'] !== '') {
            $bookResponse = $this->api->request('GET', 'books/search', [
                'table' => $bookQuery['table'],
                'attribute' => $this->defaultSearchAttribute($bookQuery['table']),
                'text' => $bookQuery['text'],
            ]);
        } else {
            $bookResponse = $this->api->request('GET', 'books');
        }

        $books = $bookResponse['ok'] ? normalizeArray($bookResponse['data']) : [];

        $this->render('books', array_merge($entities, [
            'title' => 'Könyvek',
            'section' => 'books',
            'bookQuery' => $bookQuery,
            'books' => $books,
        ]));
    }

    private function defaultSearchAttribute(string $table): string
    {
        switch ($table) {
            case 'writers':
            case 'publishers':
            case 'categories':
                return 'name';
            case 'books':
            default:
                return 'title';
        }
    }

    public function create(): void
    {
        $payload = [
            'writerId' => $_POST['writerId'] ?? '',
            'publisherId' => $_POST['publisherId'] ?? '',
            'categoryId' => $_POST['categoryId'] ?? '',
            'title' => $_POST['title'] ?? '',
            'ISBN' => $_POST['ISBN'] ?? '',
            'price' => $_POST['price'] ?? '',
            'content' => $_POST['content'] ?? '',
        ];

        $files = [];
        if (!empty($_FILES['coverImage']['tmp_name'])) {
            $files['coverImage'] = $_FILES['coverImage']['tmp_name'];
        }

        $result = $this->api->request('POST', 'books', [], $payload, $files);
        setFlash($result['ok'] ? 'success' : 'error', $result['ok'] ? 'Könyv sikeresen létrehozva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen létrehozás.')));
        $this->redirect('books');
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $payload = [
            'writerId' => $_POST['writerId'] ?? '',
            'publisherId' => $_POST['publisherId'] ?? '',
            'categoryId' => $_POST['categoryId'] ?? '',
            'title' => $_POST['title'] ?? '',
            'ISBN' => $_POST['ISBN'] ?? '',
            'price' => $_POST['price'] ?? '',
            'content' => $_POST['content'] ?? '',
        ];

        $files = [];
        if (!empty($_FILES['coverImage']['tmp_name'])) {
            $files['coverImage'] = $_FILES['coverImage']['tmp_name'];
        }

        $result = $this->api->request('PUT', 'books/' . $id, [], $payload, $files);
        setFlash($result['ok'] ? 'success' : 'error', $result['ok'] ? 'Könyv sikeresen módosítva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen módosítás.')));
        $this->redirect('books');
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->api->request('DELETE', 'books/' . $id);
        setFlash($result['ok'] ? 'success' : 'error', $result['ok'] ? 'Könyv törölve.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen törlés.')));
        $this->redirect('books');
    }
}