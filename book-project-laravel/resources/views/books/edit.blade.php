@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('books.update', $book) }}" enctype="multipart/form-data" class="form-card">
        @method('PATCH')
        <h2 class="form-title">✏️ Könyv szerkesztése</h2>
        @include('books._form')
    </form>
@endsection
