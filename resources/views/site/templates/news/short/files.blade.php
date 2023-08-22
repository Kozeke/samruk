@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page')
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <ul class="documents mb-0">
                @foreach ($records as $record)
                    @php $file = $record->media('file')->whereLang(app()->getLocale())->first(); @endphp

                    @if (!is_null($file) && file_exists(public_path($file->link)))
                        <li class="document">
                            <a class="document__link" href="/file/save/{{ $file->id }}" download>
                                <i class="document__icon document__icon--{{ strtolower(formatFile($file->link)) }}"
                                   data-ext="{{ strtolower(formatFile($file->link)) }}"></i>

                                <div class="document__info">
                                    <h4 class="document__title">
                                        @if ($record->title)
                                            {{ $record->title }}
                                        @else
                                            {{ strip_tags($record->short) }}
                                        @endif
                                    </h4>

                                    <div class="document__meta">
                                        <div class="document__meta-item">
                                            {{ formatFileSize(File::size(public_path($file->link))) }},
                                        </div>

                                        <div class="document__meta-item">
                                            {{ studly_case(formatFile($file->link)) }},
                                        </div>

                                        <div class="document__meta-item">
                                            {{ __('translations.date_published') }}
                                            {{ date('d.m.Y', strtotime($record->published_at)) }},
                                        </div>

                                        <div class="document__meta-item">
                                            {{ __('translations.date_updated') }}
                                            {{ date('d.m.Y, H:m', strtotime($record->updated_at)) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



