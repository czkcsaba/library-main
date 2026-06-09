@extends('layouts.app')

@section('content')
    <a href="{{ route('categories.create') }}" class="btn-plus">➕ Új</a>

    <div class="categoriesContainer">
        @forelse($categories as $category)
            <div class="card item-card">
                <h3>{{ $category->name }}</h3>

                <div class="btnContainer">
                    <a href="{{ route('categories.edit', $category) }}" class="btn-edit">✏️</a>
                    <form method="post" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Biztosan törlöd?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete">🗑️</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card">Nincs adat.</div>
        @endforelse
    </div>
@endsection
