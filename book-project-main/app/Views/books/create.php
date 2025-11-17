<?php

use App\Models\BookModel;
$book = new BookModel();

echo <<<HTML
<form method="post" action="/" enctype="multipart/form-data" class="form-card">

    <h2 class="form-title">📘 Új könyv hozzáadása</h2>

    <div class="form-group">
        <label for="writerId">Író</label>
        <select name="writerId" id="writerId">
            {$book->getWriters()}
        </select>
    </div>

    <div class="form-group">
        <label for="publisherId">Kiadó</label>
        <select name="publisherId" id="publisherId">
            {$book->getPublishers()}
        </select>
    </div>

    <div class="form-group">
        <label for="categoryId">Kategória</label>
        <select name="categoryId" id="categoryId">
            {$book->getCategories()}
        </select>
    </div>

    <div class="form-group">
        <label for="title">Cím</label>
        <input type="text" name="title" id="title">
    </div>

    <div class="form-group">
        <label for="coverImage">Borítókép</label>
        <input type="file" name="coverImage" id="coverImage">
    </div>

    <div class="form-group">
        <label for="ISBN">ISBN</label>
        <input type="text" name="ISBN" id="ISBN">
    </div>

    <div class="form-group">
        <label for="price">Ár</label>
        <input type="text" name="price" id="price">
    </div>

    <div class="form-group">
        <label for="content">Leírás</label>
        <textarea name="content" id="content" class="content"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" name="btn-save" class="btn-save">
            <i class="fa fa-save"></i> Mentés
        </button>

        <a href="/" class="btn-cancel">
            <i class="fa fa-times"></i> Mégse
        </a>
    </div>

</form>
HTML;
