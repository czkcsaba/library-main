<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\WriterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index']);
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::post('/books/{book}/rate', [BookController::class, 'rate'])->name('books.rate');
Route::get('/books/{book}/cover', [BookController::class, 'cover'])->name('books.cover');

Route::resource('writers', WriterController::class)->except(['show']);
Route::resource('publishers', PublisherController::class)->except(['show']);
Route::resource('categories', CategoryController::class)->except(['show']);
