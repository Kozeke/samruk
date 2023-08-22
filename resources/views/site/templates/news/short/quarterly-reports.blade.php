@extends('site.templates.pages')

@section('intro-page')
    @include('site.blocks.sections.intro-page', [
        'introPageBgUrl' => '/site/img/redesign/intro/intro-report-3.jpg'
    ])
@endsection

@section('content')
    @component('site.component.page')

        @if ($records->count())
            <div class="accordion accordion-post">
                @foreach ($records as $record)
                    @php $files = $record->media('file')->whereLang(app()->getLocale())->get(); @endphp

                    <div class="accordion__item {{ $loop->first ? 'is-active' : '' }}">
                        <div class="accordion__head">
                            <div class="accordion__head-toggle" data-accordion>
                                {{ $record->title }}
                            </div>
                        </div>

                        <div class="accordion__body" @if($loop->first) style="max-height: 1000px;" @endif>
                            <div class="accordion__content">
                                <ul class="accordion-post__meta">
                                    <li class="accordion-post__meta-item">
                                        <time class="accordion-post__date"
                                              datetime="{{ date('Y-m-d', strtotime($record->published_at)) }}">
                                            {{ date('d.m.Y', strtotime($record->published_at)) }}
                                        </time>
                                    </li>

                                    <li class="accordion-post__meta-item">
                                        {!! strip_tags($record->short, '<a>') !!}
                                    </li>
                                </ul>

                                <ul class="documents mb-0">
                                    @foreach ($files as $file)
                                        <li class="document document--compact">
                                            <a class="document__link" href="/file/save/{{ $file->id }}" download>
                                                <i class="document__icon document__icon--{{ strtolower(formatFile($file->link)) }}"
                                                   data-ext="{{ strtolower(formatFile($file->link)) }}"></i>

                                                <div class="document__info">
                                                    <div class="document__title">{{ $file->title }}</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @include('site.blocks.snippets.pagination')
        @else
            @include('site.blocks.snippets.filling')
        @endif

    @endcomponent
@endsection



