@foreach ($categories as $category)
  <option value="{{ $category->id }}">{{ str_repeat('&middot; ', $category->lvl) }} {{ $category->name }}</option>
@endforeach
