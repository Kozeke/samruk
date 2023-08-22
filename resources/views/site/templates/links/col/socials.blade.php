@if (count($links))
    <div class="socials">
        @foreach($links as $link)
            <a class="socials__link" href="{{ $link->link }}" title="{{ $link->title }}" target="_blank">
                @if ($link->class)
                    {!! icon($link->class === 'icon--inst' ? 'icon--instagram' : $link->class) !!}
                @endif
            </a>
        @endforeach
    </div>
@endif
