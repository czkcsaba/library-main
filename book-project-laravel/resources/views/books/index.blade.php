@extends('layouts.app')

@section('content')
    <div class="top-actions">
        <a href="{{ route('books.create') }}" class="btn-plus">➕ Új könyv</a>
    </div>

    <form method="get" action="{{ route('books.index') }}" class="search-card">
        <input type="text" name="text" value="{{ request('text') }}" placeholder="Keresés cím, ISBN, leírás, író, kiadó vagy kategória alapján...">
        <select name="sort">
            <option value="title" @selected($sort === 'title')>Rendezés cím szerint</option>
            <option value="ISBN" @selected($sort === 'ISBN')>Rendezés ISBN szerint</option>
            <option value="price" @selected($sort === 'price')>Rendezés ár szerint</option>
        </select>
        <button type="submit" class="btn-save">Keresés / rendezés</button>
    </form>

    <div id="container">
        @forelse($books as $book)
            <div class="card book-card">
                <div class="book-cover">
                    <img src="{{ route('books.cover', $book) }}" alt="{{ $book->title }} borítója">
                </div>

                <div class="title"><b>{{ $book->title }}</b></div>

                <table>
                    <tr><td><b>Író</b></td><td>{{ $book->writer?->name }}</td></tr>
                    <tr><td><b>Kiadó</b></td><td>{{ $book->publisher?->name }}</td></tr>
                    <tr><td><b>Kategória</b></td><td>{{ $book->category?->name }}</td></tr>
                    <tr><td><b>ISBN</b></td><td>{{ $book->ISBN }}</td></tr>
                    <tr><td><b>Ár</b></td><td>{{ $book->price }} Ft</td></tr>
                </table>

                <p>{{ $book->content }}</p>

                <div class="btnContainer">
                    <a href="{{ route('books.edit', $book) }}" class="btn-edit">✏️</a>
                    <form method="post" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Biztosan törlöd ezt a könyvet?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">🗑️</button>
                    </form>
                </div>

                <form method="post" action="{{ route('books.rate', $book) }}" class="rating-form">
                    @csrf
                    <label>Értékelés</label>
                    <select name="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} csillag</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn-ok">Ok</button>
                    <div class="stars">⭐ {{ $book->average_stars }} ({{ $book->reviews->count() }} értékelés)</div>
                </form>
            </div>
        @empty
            <div class="card">Nincs megjeleníthető könyv.</div>
        @endforelse
    </div>
@endsection
