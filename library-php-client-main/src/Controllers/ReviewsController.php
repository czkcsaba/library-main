<?php
class ReviewsController extends Controller
{
    public function index(): void
    {
        $entities = $this->loadEntities();
        $booksResponse = $this->api->request('GET', 'books');
        $books = $booksResponse['ok'] ? normalizeArray($booksResponse['data']) : [];
        $selectedBookId = (int)($_GET['book_id'] ?? 0);
        $selectedBook = null;
        $reviews = [];

        if ($selectedBookId > 0) {
            $bookDetailsResponse = $this->api->request('GET', 'books/' . $selectedBookId);
            if ($bookDetailsResponse['ok']) {
                $selectedBook = $bookDetailsResponse['data'];
            }

            $reviewResponse = $this->api->request('GET', 'books/' . $selectedBookId . '/reviews');
            if ($reviewResponse['ok']) {
                $reviews = normalizeArray($reviewResponse['data']);
            }
        }

        $this->render('reviews', array_merge($entities, [
            'title' => 'Értékelések',
            'section' => 'reviews',
            'books' => $books,
            'selectedBookId' => $selectedBookId,
            'selectedBook' => $selectedBook,
            'reviews' => $reviews,
        ]));
    }

    public function saveRating(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $stars = clampStars((int)($_POST['stars'] ?? 0));

        if ($id <= 0 || $stars < 1 || $stars > 5) {
            setFlash('error', 'Adj meg érvényes könyvet és 1-5 közötti értékelést.');
            $this->redirect('reviews', ['book_id' => $id]);
            return;
        }

        $result = $this->api->request(
            'POST',
            'books/' . $id . '/rating',
            [],
            ['stars' => $stars]
        );

        setFlash(
            $result['ok'] ? 'success' : 'error',
            $result['ok'] ? 'Értékelés sikeresen hozzáadva.' : ('Hiba: ' . ($result['error'] ?: 'Sikertelen mentés.'))
        );

        $this->redirect('reviews', ['book_id' => $id]);
    }
}