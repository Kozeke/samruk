@if (count($links) > 0)
    <div class="sidebar-block text-center">
        @foreach ($links as $link)
            <div class="{{ $loop->first ? '' : 'mt-4' }}">
                <img src="/{{ $link->photo }}" alt="{{ $link->title }}">
            </div>
        @endforeach
    </div>
@endif
