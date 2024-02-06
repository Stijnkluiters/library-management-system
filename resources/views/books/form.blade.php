@csrf
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" class="form-control" id="title" placeholder="Donald Duck"
           value="{{ $book?->getTitle() ?? old('title') }}">
</div>
<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="number" step=".01" max="300" min="0" class="form-control" name="price"
           value="{{ ($book?->getFullPrice()) ?? old('price') }}" id="price" placeholder="6,99">
</div>
