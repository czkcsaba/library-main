@csrf

<div class="form-group">
    <label for="writerId">Író</label>
    <select name="writerId" id="writerId" required>
        @foreach($writers as $writer)
            <option value="{{ $writer->id }}" @selected(old('writerId', $book->writerId ?? '') == $writer->id)>{{ $writer->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="publisherId">Kiadó</label>
    <select name="publisherId" id="publisherId" required>
        @foreach($publishers as $publisher)
            <option value="{{ $publisher->id }}" @selected(old('publisherId', $book->publisherId ?? '') == $publisher->id)>{{ $publisher->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="categoryId">Kategória</label>
    <select name="categoryId" id="categoryId" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('categoryId', $book->categoryId ?? '') == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="title">Cím</label>
    <input type="text" name="title" id="title" value="{{ old('title', $book->title ?? '') }}" required maxlength="50">
</div>

<div class="form-group">
    <label for="coverImage">Borítókép</label>
    <input type="file" name="coverImage" id="coverImage" {{ isset($book) ? '' : 'required' }}>
</div>

<div class="form-group">
    <label for="ISBN">ISBN</label>
    <input type="text" name="ISBN" id="ISBN" value="{{ old('ISBN', $book->ISBN ?? '') }}" required maxlength="50">
</div>

<div class="form-group">
    <label for="price">Ár</label>
    <input type="number" name="price" id="price" value="{{ old('price', $book->price ?? '') }}" required min="0">
</div>

<div class="form-group">
    <label for="content">Leírás</label>
    <textarea name="content" id="content" class="content" required maxlength="800">{{ old('content', $book->content ?? '') }}</textarea>
</div>

<div class="form-actions">
    <button type="submit" class="btn-save">💾 Mentés</button>
    <a href="{{ route('books.index') }}" class="btn-cancel">Mégse</a>
</div>
