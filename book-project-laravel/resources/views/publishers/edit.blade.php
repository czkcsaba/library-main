@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('publishers.update', $publisher) }}" class="form-card">
        @csrf
        @method('PATCH')
        <h2 class="form-title">Elem szerkesztése</h2>
        <div class="form-group">
            <label for="name">Név</label>
            <input type="text" name="name" id="name" value="{{ old('name', $publisher->name) }}" required maxlength="50">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">💾 Mentés</button>
            <a href="{{ route('publishers.index') }}" class="btn-cancel">Mégse</a>
        </div>
    </form>
@endsection
