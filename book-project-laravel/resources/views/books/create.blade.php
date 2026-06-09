@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('books.store') }}" enctype="multipart/form-data" class="form-card">
        <h2 class="form-title">📘 Új könyv hozzáadása</h2>
        @include('books._form')
    </form>
@endsection