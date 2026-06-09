@extends('layouts.app')

@section('content')
    <a href="{{ route('writers.create') }}" class="btn-plus">➕ Új</a>

    <div class="writersContainer">
        @forelse($writers as $writer)
            <div class="card item-card">
                <h3>{{ $writer->name }}</h3>
                <p>{{ $writer->bio }}</p>
                <div class="btnContainer">
                    <a href="{{ route('writers.edit', $writer) }}" class="btn-edit">✏️</a>
                    <form method="post" action="{{ route('writers.destroy', $writer) }}" onsubmit="return confirm('Biztosan törlöd?')">
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
