<?php
class DashboardController extends Controller
{
    public function index(): void
    {
        $entities = $this->loadEntities();
        $health = $this->api->request('GET', '');
        $booksResponse = $this->api->request('GET', 'books');
        $books = $booksResponse['ok'] ? normalizeArray($booksResponse['data']) : [];

        $reviewCount = 0;
        foreach ($books as $book) {
            $bookId = (int)($book['id'] ?? 0);
            if ($bookId <= 0) {
                continue;
            }

            $reviewResponse = $this->api->request('GET', 'books/' . $bookId . '/reviews');
            if ($reviewResponse['ok']) {
                $reviewCount += count(normalizeArray($reviewResponse['data']));
            }
        }

        $this->render('dashboard', array_merge($entities, [
            'title' => 'Áttekintés',
            'section' => 'dashboard',
            'health' => $health,
            'books' => $books,
            'reviewCount' => $reviewCount,
        ]));
    }
}