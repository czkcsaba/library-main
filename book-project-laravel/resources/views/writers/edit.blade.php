@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('writers.update', $writer) }}" class="form-card">
        @csrf
        @method('PATCH')
        <h2 class="form-title">Elem szerkesztése</h2>
        <div class="form-group">
            <label for="name">Név</label>
            <input type="text" name="name" id="name" value="{{ old('name', $writer->name) }}" required maxlength="50">
        </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name="bio" id="bio" required maxlength="400">{{ old('bio', $writer->bio) }}</textarea>
                </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">💾 Mentés</button>
            <a href="{{ route('writers.index') }}" class="btn-cancel">Mégse</a>
        </div>
    </form>
@endsection
