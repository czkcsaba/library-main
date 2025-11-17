<?php

$html = <<<HTML
<form method="post" action="/" enctype="multipart/form-data" class="form-card">

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="id" value="{$book->id}">

    <h2 class="form-title">✏️ Könyv szerkesztése</h2>

    <div class="form-group">
        <label for="writerId">Író</label>
        <select name="writerId" id="writerId">
            {$book->getWriters($book->writerId)}
        </select>
    </div>

    <div class="form-group">
        <label for="publisherId">Kiadó</label>
        <select name="publisherId" id="publisherId">
            {$book->getPublishers($book->publisherId)}
        </select>
    </div>

    <div class="form-group">
        <label for="categoryId">Kategória</label>
        <select name="categoryId" id="categoryId">
            {$book->getCategories($book->categoryId)}
        </select>
    </div>

    <div class="form-group">
        <label for="title">Cím</label>
        <input type="text" name="title" id="title" value="{$book->title}">
    </div>

    <div class="form-group">
        <label for="coverImage">Borítókép</label>
        <input type="file" name="coverImage" id="coverImage">
    </div>

    <div class="form-group">
        <label for="ISBN">ISBN</label>
        <input type="text" name="ISBN" id="ISBN" value="{$book->ISBN}">
    </div>

    <div class="form-group">
        <label for="price">Ár</label>
        <input type="text" name="price" id="price" value="{$book->price}">
    </div>

    <div class="form-group">
        <label for="content">Leírás</label>
        <textarea name="content" id="content" class="content">{$book->content}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" name="btn-update" class="btn-save">
            <i class="fa fa-save"></i> Mentés
        </button>

        <a href="/" class="btn-cancel">
            <i class="fa fa-times"></i> Mégse
        </a>
    </div>

</form>
HTML;

echo $html;
