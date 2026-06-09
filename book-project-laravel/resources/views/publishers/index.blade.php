@extends('layouts.app')

@section('content')
    <a href="{{ route('publishers.create') }}" class="btn-plus">➕ Új</a>

    <div class="publishersContainer">
        @forelse($publishers as $publisher)
            <div class="card item-card">
                <h3>{{ $publisher->name }}</h3>

                <div class="btnContainer">
                    <a href="{{ route('publishers.edit', $publisher) }}" class="btn-edit">✏️</a>
                    <form method="post" action="{{ route('publishers.destroy', $publisher) }}" onsubmit="return confirm('Biztosan törlöd?')">
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
