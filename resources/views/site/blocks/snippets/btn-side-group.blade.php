@if (
    !Route::is('auth.*') &&
    !Route::is('registrations.*') &&
    !Route::is('cabinet.*')
)
    <div class="btn-side-group">
        {!! getLinks('col-quiz-link', 'btn-quiz-side') !!}

{{--        @if ($indexPage || (isset($section) && $section->alias !== 'blog'))--}}
        @if ($indexPage || (isset($section) ))
            <a
                class="btn btn--secondary btn-side"
                href="/{{ app()->getLocale() }}/gb/blog"
            >{{ __('translations.chairmanBlog') }}</a>
        @endif
    </div>
@endif
