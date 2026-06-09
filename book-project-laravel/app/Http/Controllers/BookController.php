<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Review;
use App\Models\Writer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $query = Book::with(['writer', 'publisher', 'category', 'reviews']);

        if ($request->filled('text')) {
            $text = $request->input('text');
            $query->where(function ($q) use ($text) {
                $q->where('title', 'like', "%{$text}%")
                    ->orWhere('ISBN', 'like', "%{$text}%")
                    ->orWhere('content', 'like', "%{$text}%")
                    ->orWhereHas('writer', fn ($w) => $w->where('name', 'like', "%{$text}%"))
                    ->orWhereHas('publisher', fn ($p) => $p->where('name', 'like', "%{$text}%"))
                    ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$text}%"));
            });
        }

        $sort = $request->input('sort', 'title');
        $allowedSorts = ['title', 'ISBN', 'price'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'title';
        }

        $books = $query->orderBy($sort)->get();

        return view('books.index', compact('books', 'sort'));
    }

    public function create(): View
    {
        return view('books.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'A könyv sikeresen létrehozva.');
    }

    public function edit(Book $book): View
    {
        return view('books.edit', array_merge($this->formData(), compact('book')));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $this->validatedData($request, false);

        if (! array_key_exists('coverImage', $data)) {
            unset($data['coverImage']);
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'A könyv sikeresen módosítva.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'A könyv sikeresen törölve.');
    }

    public function rate(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Review::create([
            'bookId' => $book->id,
            'stars' => $data['stars'],
        ]);

        return redirect()->route('books.index')->with('success', 'Értékelés mentve.');
    }

    public function cover(Book $book)
    {
        return response($book->coverImage, 200)
            ->header('Content-Type', 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    private function formData(): array
    {
        return [
            'writers' => Writer::orderBy('name')->get(),
            'publishers' => Publisher::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ];
    }

    private function validatedData(Request $request, bool $coverRequired = true): array
    {
        $rules = [
            'writerId' => ['required', 'exists:writers,id'],
            'publisherId' => ['required', 'exists:publishers,id'],
            'categoryId' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:50'],
            'ISBN' => ['required', 'string', 'max:50'],
            'price' => ['required', 'integer', 'min:0'],
            'content' => ['required', 'string', 'max:800'],
            'coverImage' => [$coverRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('coverImage')) {
            $data['coverImage'] = file_get_contents($request->file('coverImage')->getRealPath());
        }

        return $data;
    }
}
