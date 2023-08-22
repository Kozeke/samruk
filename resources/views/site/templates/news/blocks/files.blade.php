@if ($files->count())
    <ul class="documents" id="documents">
        @foreach ($files as $file)
            <li class="document document--compact">
                <a class="document__link" href="/file/save/{{ $file->id }}" download>
                    <i class="document__icon document__icon--{{ strtolower(formatFile($file->link)) }}"
                       data-ext="{{ strtolower(formatFile($file->link)) }}"></i>

                    <div class="document__info">
                        <h4 class="document__title">{{ $file->title }}</h4>

                        {{--<div class="document__meta">
                            <div class="document__meta-item">
                                {{ formatFileSize(File::size(public_path($file->link))) }},
                            </div>

                            <div class="document__meta-item">
                                {{ studly_case(formatFile($file->link)) }},
                            </div>
                        </div>--}}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endif
